<?php

namespace AppBundle\Controller;

use AppBundle\Doctrine\Type\DateTime;
use Psr\Log\LoggerInterface;
use AppBundle\Entity\Pdf;
use AppBundle\Service\PdfService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


trait ApiPdfGeneratable
{
    /**
     * @var mixed Data from $request->getContent()
     */
    private $requestData;

    /**
     * @var string
     */
    private $personalIdNumber;

    /**
     * @var string
     */
    private $modelName;

    /**
     * @var string
     */
    private $decoratorName;

    /**
     * @return mixed
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * @param mixed $requestData
     */
    public function setRequestData($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * @return string
     */
    public function getPersonalIdNumber()
    {
        return $this->personalIdNumber;
    }

    /**
     * @param string $personalIdNumber
     */
    public function setPersonalIdNumber(string $personalIdNumber)
    {
        $this->personalIdNumber = $personalIdNumber;
    }

    /**
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName(string $modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @return string
     */
    public function getDecoratorName()
    {
        return $this->decoratorName;
    }

    /**
     * @param string $decoratorName
     */
    public function setDecoratorName($decoratorName)
    {
        $this->decoratorName = $decoratorName;
    }

    /** @var LoggerInterface string */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param string $personalIdNumber
     * @param string $modelName
     * @param string $decoratorName
     * @param bool $isCreating
     * @param bool $isDebugging
     * @param bool $isApplyingLayout
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \InvalidArgumentException
     */
    public function runGenerateAction(
        Request $request,
        string $personalIdNumber,
        string $modelName,
        string $decoratorName,
        bool $isCreating = true,
        bool $isDebugging = false,
        bool $isApplyingLayout = false
    )
    {
        $this->setRequestData($request->getContent());
        $this->setPersonalIdNumber($personalIdNumber);
        $this->setModelName($modelName);
        $this->setDecoratorName($decoratorName);

        $pdf = $this->generatePdf($isCreating, $isDebugging, $isApplyingLayout);

        $status = 'success';
        $code = $isCreating ? Response::HTTP_CREATED : Response::HTTP_NO_CONTENT;

        if ($isCreating) {
            $message = 'The PDF file was created successfully';
            $this->logger->info($this->getParameter('web_download_dir') . '/' . $pdf->getDirName() . '/' . $pdf->getFileName() . " : The PDF file was created successfully");
        } else {
            $message = 'The PDF file was updated successfully';
            $this->logger->info($this->getParameter('web_download_dir') . '/' . $pdf->getDirName() . '/' . $pdf->getFileName() . " : The PDF file was updated successfully");
        }

        $data = ['file' => $this->getParameter('web_download_dir') . '/' . $pdf->getDirName() . '/' . $pdf->getFileName()];

        $view = $this->view([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
       // $b64Doc = chunk_split(base64_encode(file_get_contents("http://aegon-pdf-service.local/web".$data["file"])));
       // return (new Response($b64Doc,200))->header('ContentType','application/pdf');
        //return $b64Doc;
        return $this->handleView($view, $code);
    }

    /**
     * Generates a PDF
     * @param bool $isCreating
     * @param bool $isDebugging
     * @param bool $isApplyingLayout
     * @return Pdf
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \InvalidArgumentException
     */
    public function generatePdf(bool $isCreating = true, bool $isDebugging = false, bool $isApplyingLayout = false)
    {
        $serializer = $this->get('jms_serializer');
        $fileService = $this->get('AppBundle\Service\FileService');

        $model = $serializer->deserialize($this->getRequestData(), $this->getModelName(), 'json');
        $decoratorName = $this->getDecoratorName();

        $decorator = new $decoratorName(
            $model,
            $fileService,
            $this->get('twig'),
            $this->getParameter('project_pdf_template_dir'),
            $this->getParameter('project_pdf_images_dir'),
            $this->getParameter('web_pdf_images_dir'),
            $this->getParameter('insurance_slugs'),
            $this->getParameter('pdf_type_slugs_map_internal_titles')
        );


        return $this->doGeneratePdf(
            $model->getPolId(),
            $model->getInsuranceSlug(),
            $model->getPdfTypeSlug(),
            $decorator,
            $isCreating,
            $isDebugging,
            $isApplyingLayout
        );
    }

    /**
     * @param string $polId
     * @param string $insuranceSlug
     * @param string $pdfTypeSlug
     * @param mixed $decorator
     * @param bool $isCreating
     * @param bool $isDebugging
     * @param bool $isApplyingLayout
     * @return Pdf
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \InvalidArgumentException
     */
    private function doGeneratePdf(
        string $polId,
        string $insuranceSlug,
        string $pdfTypeSlug,
        $decorator,
        bool $isCreating = true,
        bool $isDebugging = false,
        bool $isApplyingLayout = false
    )
    {
        $pdfFileService = $this->get('AppBundle\Service\PdfFileService');
        $pdfService = $this->get('AppBundle\Service\PdfService');

        $pdf = $this->getPdf($pdfService, $this->getPersonalIdNumber(), $polId, $insuranceSlug, $pdfTypeSlug, $isCreating);

        $pdfData = $decorator->getDecoratedData();

        $now = new \DateTime();

        if ($isCreating) {
            $pdf
                ->setPersonalIdNumber($this->getPersonalIdNumber())
                ->setPolId($decorator->getPolId())
                ->setInsuranceSlug($decorator->getInsuranceSlug())
                ->setPdfTypeSlug($decorator->getPdfTypeSlug())
                ->setCreatedAt($now);
        }

        $isArchivalRequired = $decorator->getIsArchivalRequired() ?? false;

        $pdf
            ->setPolicyNumber($decorator->getPolicyNumber())
            ->setIsArchivalRequired($isArchivalRequired)
            ->setJsonData($this->getRequestData())
            ->setJsonProcessed($pdf->encodeJson($pdfData))
            ->setUpdatedAt($now);

        // in any case (while creating or updating) set moreumDocumentId to NULL, so that the PDF will be archived
        $pdf->setMoreumDocumentId(null);

        $pdf = $pdfFileService->savePdfFile($pdf, $isDebugging, $isApplyingLayout);
        $pdfService->savePdfEntity($pdf);
        $pdfFileService->deleteSignDirectory();

        return $pdf;
    }

    /**
     * @param PdfService $pdfService
     * @param string $personalIdNumber
     * @param string $insuranceSlug
     * @param string $pdfTypeSlug
     * @param bool $isCreating
     * @return Pdf
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    private function getPdf(PdfService $pdfService, string $personalIdNumber, string $polId, string $insuranceSlug, string $pdfTypeSlug, bool $isCreating = true)
    {
        $hydrationMode = $isCreating ? 'array' : 'object';

        // find existing
        $existingPdf = $pdfService->findOneByPersonalIdNumberAndPolIdAndSlugs(
            $personalIdNumber,
            $polId,
            $insuranceSlug,
            $pdfTypeSlug,
            $hydrationMode
        );

        if ($isCreating) {
            // if creating: throw error if already exists
            if ($existingPdf) {
                throw new BadRequestHttpException(sprintf(
                    'A PDF file for the given personalIdNumber "%s", polId "%s", insuranceSlug "%s" and pdfTypeSlug "%s" already exists. ' .
                    'Please update it instead of creating a new one.',
                    $personalIdNumber,
                    $polId,
                    $insuranceSlug,
                    $pdfTypeSlug
                ));
            }

            $pdf = new Pdf();

        } else {
            // if updating: throw error not found
            if (!$existingPdf) {

                throw new NotFoundHttpException(sprintf(
                    'A PDF file for the given personalIdNumber "%s", polId "%s", insuranceSlug "%s" and pdfTypeSlug "%s" was not found.',
                    $personalIdNumber,
                    $polId,
                    $insuranceSlug,
                    $pdfTypeSlug
                ));

            }

            $pdf = $existingPdf;
        }

        return $pdf;
    }
}

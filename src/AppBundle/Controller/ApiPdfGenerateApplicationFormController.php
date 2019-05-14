<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use AppBundle\PdfModel\ApplicationFormPdf;
use AppBundle\PdfDecorator\ApplicationFormPdfDecorator;

/**
 * Api PDF Application Form controller.
 * @package AppBundle\Controller
 * @Route("/api/pdf/application-form")
 */
class ApiPdfGenerateApplicationFormController extends FOSRestController
{
    use JsonResponsible, ApiPdfGeneratable;

    /**
     * Creates a new Application Form PDF file (Başvuru Formu)
     *
     * @SWG\Post(
     *     tags={"PDF Edit - Application Form (Başvuru Formu)"},
     *     @SWG\Parameter(
     *         name="personalIdNumber",
     *         description="Personal ID Number (TC Kimlik No) of the insured person (e.g. '12345678901')",
     *         in="path",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="PDF object that needs to be created",
     *         required=true,
     *         @SWG\Schema(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf::class))
     *     ),
     *     @SWG\Response(response=201, description="PDF file was created successfully"),
     *     @SWG\Response(response=400, description="Invalid input")
     * )
     *
     * @Route("/{personalIdNumber}", name="api.pdf.application_form.post", methods={"POST"})
     * @param Request $request
     * @param string $personalIdNumber
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @return Response
     */
    public function postAction(Request $request, string $personalIdNumber)
    {
        $isDebugging = '1' === $request->get('debug', '0');

        return $this->runGenerateAction(
            $request,
            $personalIdNumber,
            ApplicationFormPdf::class,
            ApplicationFormPdfDecorator::class,
            true,
            $isDebugging
        );
    }


    /**
     * Updates an existing Application Form PDF file (Başvuru Formu)
     *
     * @SWG\Put(
     *     tags={"PDF Edit - Application Form (Başvuru Formu)"},
     *     @SWG\Parameter(
     *         name="personalIdNumber",
     *         description="Personal ID Number (TC Kimlik No) of the insured person (e.g. '12345678901')",
     *         in="path",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="PDF object that needs to be created",
     *         required=true,
     *         @SWG\Schema(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf::class))
     *     ),
     *     @SWG\Response(response=204, description="Resource was updated successfully"),
     *     @SWG\Response(response=400, description="Invalid input"),
     *     @SWG\Response(response=404, description="Resource was not found")
     * )
     *
     * @Route("/{personalIdNumber}", name="api.pdf.application_form.put", methods={"PUT"})
     * @param Request $request
     * @param string $personalIdNumber
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @return Response
     */
    public function putAction(Request $request, string $personalIdNumber)
    {
        $isDebugging = '1' === $request->get('debug', '0');

        return $this->runGenerateAction(
            $request,
            $personalIdNumber,
            ApplicationFormPdf::class,
            ApplicationFormPdfDecorator::class,
            false,
            $isDebugging
        );
    }
}

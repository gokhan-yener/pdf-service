<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use AppBundle\PdfModel\TermsPdf;
use AppBundle\PdfDecorator\TermsPdfDecorator;

/**
 * Api PDF Terms controller.
 * @package AppBundle\Controller
 * @Route("/api/pdf/terms")
 */
class ApiPdfGenerateTermsController extends FOSRestController
{
    use JsonResponsible, ApiPdfGeneratable;

    /**
     * Creates a new Terms PDF file (Özel ve Genel Şartlar)
     *
     * @SWG\Post(
     *     tags={"PDF Edit - Terms (Özel ve Genel Şartlar)"},
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
     *         @SWG\Schema(ref=@Model(type=AppBundle\PdfModel\TermsPdf::class))
     *     ),
     *     @SWG\Response(response=201, description="PDF file was created successfully"),
     *     @SWG\Response(response=400, description="Invalid input")
     * )
     *
     * @Route("/{personalIdNumber}", name="api.pdf.terms.post", methods={"POST"})
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
            TermsPdf::class,
            TermsPdfDecorator::class,
            true,
            $isDebugging
        );
    }


    /**
     * Updates an existing Terms PDF file (Özel ve Genel Şartlar)
     *
     * @SWG\Put(
     *     tags={"PDF Edit - Terms (Özel ve Genel Şartlar)"},
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
     *         @SWG\Schema(ref=@Model(type=AppBundle\PdfModel\TermsPdf::class))
     *     ),
     *     @SWG\Response(response=204, description="Resource was updated successfully"),
     *     @SWG\Response(response=400, description="Invalid input"),
     *     @SWG\Response(response=404, description="Resource was not found")
     * )
     *
     * @Route("/{personalIdNumber}", name="api.pdf.terms.put", methods={"PUT"})
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
            TermsPdf::class,
            TermsPdfDecorator::class,
            false,
            $isDebugging
        );
    }
}

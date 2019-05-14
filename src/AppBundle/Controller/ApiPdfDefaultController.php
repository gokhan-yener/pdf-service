<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;

/**
 * Api PDF controller.
 * @package AppBundle\Controller
 * @Route("/api/pdf")
 */
class ApiPdfDefaultController extends FOSRestController
{
    /**
     * Returns a collection of PDFs by personalIdNumber
     *
     * @SWG\Get(
     *     tags={"PDF List"},
     *     @SWG\Parameter(
     *         name="personalIdNumber",
     *         description="Personal ID Number (TC Kimlik No) of the insured person (e.g. '12345678901')",
     *         in="path",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="polId",
     *         description="POLID of the insurance (e.g. '2223524')",
     *         in="path",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="insuranceSlug",
     *         description="Insurance slug (e.g. '5-5-odullu-birikim', see 'Configuration')",
     *         in="path",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=404, description="Resources not found")
     * )
     *
     * @Route("/get-by-customer/{personalIdNumber}/{polId}/{insuranceSlug}", name="api.pdf.cget_by_personal_id_number", methods={"GET"})
     * @param string $personalIdNumber
     * @param string $polId
     * @param string $insuranceSlug
     *
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function cgetByPersonalIdNumberAction(string $personalIdNumber, string $polId, string $insuranceSlug)
    {
        $pdfService = $this->get('AppBundle\Service\PdfService');

        // find existing
        $pdfs = $pdfService->findAllByPersonalIdNumberAndPolIdAndInsuranceSlug(
            $personalIdNumber,
            $polId,
            $insuranceSlug,
            'array'
        );

        if (!$pdfs) {
            throw new NotFoundHttpException('Resources not found');
        }

        $view = $this->view($pdfs);

        return $this->handleView($view);
    }

}

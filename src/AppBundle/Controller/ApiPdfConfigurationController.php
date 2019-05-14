<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;

/**
 * Api PDF controller.
 * @package AppBundle\Controller
 * @Route("/api/configuration")
 */
class ApiPdfConfigurationController extends FOSRestController
{
    /**
     * Gets all insurance slugs
     *
     * @SWG\Get(
     *     tags={"Configuration"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=404, description="Resource not found")
     * )
     *
     * @Route("/insurance-slugs", name="api.configuration.insurance-slugs", methods={"GET"})
     *
     * @return Response
     */
    public function getInsuranceSlugsAction()
    {
        $slugs = $this->getParameter('insurance_slugs');
        $view = $this->view($slugs);

        return $this->handleView($view);
    }

    /**
     * Gets all PDF type slugs
     *
     * @SWG\Get(
     *     tags={"Configuration"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=404, description="Resource not found")
     * )
     *
     * @Route("/pdf-type-slugs", name="api.configuration.pdf-type-slugs", methods={"GET"})
     *
     * @return Response
     */
    public function getPdfTypeSlugsAction()
    {
        $slugs = $this->getParameter('pdf_type_slugs');
        $view = $this->view($slugs);

        return $this->handleView($view);
    }
}

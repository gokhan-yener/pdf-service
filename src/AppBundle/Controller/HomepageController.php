<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Api PDF controller.
 * @package AppBundle\Controller
 */
class HomepageController extends FOSRestController
{
    use JsonResponsible;

    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexController(Request $request)
    {
        $data = [
            'service' => $this->getParameter('app_name'),
        ];

        return $this->createJsonResponse($data);
    }
}

<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * JsonResponsible trait.
 */
trait JsonResponsible
{
    /**
     * Returns JsonResponse with correctly set encoding options
     * @param $data
     * @param int $status
     * @return JsonResponse
     */
    private function createJsonResponse($data, $status = JsonResponse::HTTP_OK)
    {
        $response = new JsonResponse($data, $status);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        return $response;
    }

    /**
     * Returns JsonResponse with correct "not found" HTTP status
     * @param string $message
     * @return JsonResponse
     */
    private function createNotFoundJsonResponse($message = 'Resource not found')
    {
        return $this->createJsonResponse($message, JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * Returns JsonResponse with correct "unauthorized" HTTP status
     * @param string $message
     * @return JsonResponse
     */
    private function createAuthorizationRequiredJsonResponse($message = 'Authorization Required')
    {
        return $this->createJsonResponse($message, JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Returns JsonResponse with correct "forbidden" HTTP status
     * @param string $message
     * @return JsonResponse
     */
    private function createAccessDeniedJsonResponse($message = 'Access denied')
    {
        return $this->createJsonResponse($message, JsonResponse::HTTP_FORBIDDEN);
    }
}

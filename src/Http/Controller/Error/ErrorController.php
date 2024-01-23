<?php

namespace App\Http\Controller\Error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    /**
     * Simplifie l'affichage des erreurs dans l'environnement de test.
     */
    public function test(?\Throwable $exception = null): Response
    {
        if (!$exception) {
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $exception = FlattenException::createFromThrowable($exception);

        return new Response($exception->getMessage(), $exception->getStatusCode(), $exception->getHeaders());
    }
}
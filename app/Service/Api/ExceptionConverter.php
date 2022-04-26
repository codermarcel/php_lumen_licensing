<?php

namespace App\Service\Api;

use Exception;
use App\Exceptions\ClientException;
use App\Exceptions\ClientException\NotFoundException;
use App\Exceptions\ClientException\PermissionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionConverter
{
    public static function convertException(Exception $exception)
    {
        $exception = self::transformException($exception);
        $code = $exception->getCode();
        $message = null;

        if ($exception instanceof ClientException) 
        {
            $message = $exception->getMessage(); //only expose exception messages if they are meant to be read by the client.
        }

        return [$code, $message];
    }

    private static function transformException(Exception $e)
    {
        if ($e instanceof AuthorizationException)
        {
            return PermissionException::bad();
        }

        if ($e instanceof NotFoundHttpException)
        {
            return NotFoundException::noRoute();
        }

        if ($e instanceof ModelNotFoundException)
        {
            return NotFoundException::noRecord();
        }

        if ($e instanceof HttpException)
        {
            return new ClientException($e->getMessage(), $e->getStatusCode());
        }

        return $e;
    }
}
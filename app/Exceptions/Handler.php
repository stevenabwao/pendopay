<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    /* public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    } */

    public function render($request, Throwable $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, Throwable $exception)
    {

        if ($exception instanceof MethodNotAllowedHttpException) {
            if ($request->expectsJson()) {
                return $this->errorResponse('The specified method for the request is invalid', 405);
            }
        }

        if ($exception instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return $this->errorResponse('The specified URL cannot be found', 404);
            }
        }

        if ($exception instanceof HttpException) {
            if ($request->expectsJson()) {
                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
            }
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        if ($request->expectsJson()) {
            return $this->errorResponse('Unexpected Exception. Try later', 500);
        }

    }

}

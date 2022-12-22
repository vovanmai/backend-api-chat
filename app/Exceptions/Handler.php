<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception Throwable.
     *
     * @return void
     * @throws Exception Exception.
     * @throws Throwable Throwable.
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param mixed     $request   Request.
     * @param Throwable $exception Throwable.
     *
     * @return JsonResponse|Response
     */
    public function render($request, Throwable $exception)
    {
        if (method_exists($exception, 'render')) {
            return Router::toResponse($request, $exception->render($request));
        }

        if ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {
            return response()->notFound(trans('messages.error.route_not_found'));
        }

        if ($exception instanceof AuthenticationException) {
            return response()->error([], 'Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }

        return response()->error($exception, trans('messages.error.internal_server'));
    }
}

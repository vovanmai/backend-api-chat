<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Lang;
use Log;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerSuccessResponse();
        $this->registerErrorResponse();
        $this->registerNotFoundResponse();
    }

    /**
     * Register success response
     *
     * @return void
     */
    private function registerSuccessResponse()
    {
        Response::macro(
            'success',
            function ($data = [], $message = 'Success', $statusCode = 200, $headers = []) {
                return response()->json([
                    'status_code' => $statusCode,
                    'message' => $message,
                    'data' => $data,
                ], $statusCode, $headers);
            }
        );
    }

    /**
     * Register error response
     *
     * @return void
     */
    private function registerErrorResponse()
    {
        Response::macro(
            'error',
            function ($errors = [], $message = 'Server Error', $statusCode = 500, $headers = []) {
                $response = [
                    'status_code' => $statusCode,
                    'message' => $message,
                    'errors' => $errors,
                ];

                if ($errors instanceof Exception) {
                    Log::error($errors);
                    $response['errors'] = [];
                }

                return response()->json($response, $statusCode, $headers);
            }
        );
    }

    /**
     * Register not found response
     *
     * @return void
     */
    private function registerNotFoundResponse()
    {
        Response::macro(
            'notFound',
            function ($message, $errors = [], $statusCode = 404, $headers = []) {
                if ($message instanceof ModelNotFoundException) {
                    $key = "model.{$message->getModel()}";
                    $message = trans('messages.error.not_found');

                    if (Lang::has($key)) {
                        $message = trans(
                            trans('messages.error.model_not_found'),
                            ['model' => trans($key)]
                        );
                    }
                }

                return response()->json([
                    'status_code' => $statusCode,
                    'message' => $message,
                    'errors' => $errors,
                ], $statusCode, $headers);
            }
        );
    }
}

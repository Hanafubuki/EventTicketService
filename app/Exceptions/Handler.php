<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        //$this->renderable(function (Throwable $e) {
            
            // if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
            //     return response(['error' => $e->getMessage(), 'code' => $e->getStatusCode()], $e->getStatusCode() ?: 400);
            // }else{
            //     return response(['error' => $e->getMessage(), 'code' => dd($request)], $e->getCode() ?: 400);
            // }
            // return response()->json([
            //     'message' => $e->getMessage(),
            //     'code' => $e->getStatusCode()
            // ], $e->getStatusCode());
        //});
        $this->reportable(function (Throwable $e) {

        });
    }

    
}

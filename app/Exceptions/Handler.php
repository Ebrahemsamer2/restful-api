<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Validation\ValidationException;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Database\QueryException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Auth\Access\AuthorizationException;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use App\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {

        if($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        
        if($exception instanceof ModelNotFoundException) {
            $model = $exception->getModel();
            // $model_name = explode("\\", $model)[1];
            $model_name = strtolower(class_basename($model));

            return $this->errorResponse("Model $model_name Does not Exist", 404);
        }

        if($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request,$exception);
        }

        if($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessages(), 403);
        }

        if($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL Does not Exist", 404);
        }

        if($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("The specified Method is not Allowed", 405);
        }

        // Exception happen while Deleting related Foriegn keys Table that related to anothers
        if($exception instanceof QueryException) {

            $error_code = $exception->errorInfo[1];

            if($error_code == 1451) {
                return $this->errorResponse("Can not remove this resource because Its related to another", 409);
            }
        }

        // if we're in development
        if(config('app.debug')) {
            return parent::render($request, $exception);
        }
        // if Production release this Error
        return $this->errorResponse("Unexpected Exception Try Again Later", 500);
    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request) {

        $error = $e->validator->errors()->getMessages();
        return $this->errorResponse($error, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception) {
        return $this->errorResponse("UnAuthinticated", 401);
    }
}

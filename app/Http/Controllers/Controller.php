<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function jsonResponse($context = [], $status = 200, $message = null): JsonResponse {
        if ($context instanceof Model) {
            $context = $context->toArray();
        } else if ($context instanceof Validator) {
            $context = $context->errors()->toArray();
        }

        if ($status >= 500) {
            throw new \Exception($message);
        }

        return response()->json([
            'status' => ($status === true) ? 200 : (($status === false) ? 400 : $status),
            'message' => $message,
            'context' => $context
        ], ($status === true) ? 200 : (($status === false) ? 400 : $status));
    }
}

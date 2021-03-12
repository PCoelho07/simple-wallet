<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function responseSuccess(Model $resource)
    {
        return response()->json([
            'success' => true,
            'data' => $resource
        ]);
    }

    protected function responseFailed(string $action = '')
    {
        $errorMessage = __("errors.messages.{$action}");
        $errorCode = __("errors.status_code.{$action}");

        return response()->json([
            'success' => false,
            'error' => $errorMessage
        ], $errorCode);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
class BaseController extends Controller
{
    public function sendResponse($result, $errorCode = 0, $status = 200)
    {
        $response = [
            'ErrorCode' => $errorCode,
            'Data' => $result,
        ];
        return response()->json($response, $status);
    }

    public function sendError($errorMessage, $errorCode = 1, $status = 200)
    {
        $response = [
            'Message' => $errorMessage,
            'ErrorCode' => $errorCode,
        ];
        return response()->json($response, $status);
    }
    public function createdBy() {
        return Auth::user()->name;
    }
}

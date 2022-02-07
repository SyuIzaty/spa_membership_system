<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $total=null, $take=null, $skip=null, $orderBy=null, $order=null, $filterSearchBy=null, $filterSearchValue=null)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
            'total' => $total,
            'take' => $take,
            'skip' => $skip,
            'orderBy' => $orderBy,
            'order' => $order,
            'filterSearchBy' => $filterSearchBy,
            'filterSearchValue' => $filterSearchValue,
        ];

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}

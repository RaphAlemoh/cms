<?php

namespace App\Traits;

trait ApiResponser
{

    private function jsonReponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return $this->jsonReponse(['error' => $message], $code);
    }

    protected function showOne($model, $code = 200)
    {
        $response = (gettype($model) == 'string') ? ['message' => $model] : ['data' => $model];
        return $this->jsonReponse($response, $code);
    }
}

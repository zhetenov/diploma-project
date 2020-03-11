<?php

namespace App\Services\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RestExceptionTrait
{
    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api') !== false;
    }

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, \Throwable $e)
    {
        switch (true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound();
                break;
            default:
                $retval = $this->badRequest($e->getMessage());
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message='Bad request', $statusCode=400)
    {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message='Record not found', $statusCode=404)
    {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload=null, $statusCode=404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(\Throwable $e)
    {
        return $e instanceof ModelNotFoundException;
    }
}

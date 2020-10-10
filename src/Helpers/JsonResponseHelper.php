<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonResponseHelper
{
  public function internal(string $message): JsonResponse
  {
    return $this->base($message, 500);
  }

  public function badRequest(string $message): JsonResponse
  {
    return $this->base($message, 400);
  }

  public function unauthorized(string $message): JsonResponse
  {
    return $this->base($message, 403);
  }

  public function notFound(string $message): JsonResponse
  {
    return $this->base($message, 404);
  }

  public function success(string $message, array $data = []): JsonResponse
  {
    return $this->base($message, 200, $data);
  }

  public function created(string $message, array $data = []): JsonResponse
  {
    return $this->base($message, 201, $data);
  }

  private function base(string $message = '',  int $statusCode = 200, array $data = []): JsonResponse
  {

    $json = [
      'message' => $message,
      'statusCode' => $statusCode,
      'error' => ($statusCode === 400 || $statusCode === 404 || $statusCode === 500),
      'data' => $data
    ];
    return new JsonResponse($json, $statusCode);
  }
}

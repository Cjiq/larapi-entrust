<?php

namespace Infrastructure\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\HttpExceptionFormatter;

class AuthenticationExceptionFormatter extends HttpExceptionFormatter
{
  public function format(JsonResponse $response, Exception $e, array $reporterResponses)
  {
    //parent::format($response, $e, $reporterResponses);

    $response->setStatusCode(401);
    $response->setData([
      'code' => 2,
      'message' => 'Unauthenticated'
    ]);

    return $response;
  }
}

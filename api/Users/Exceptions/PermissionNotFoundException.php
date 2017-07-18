<?php

namespace Api\Users\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PermissionNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('The permission was not found.');
    }
}

<?php

namespace Application\Exception;

class BadRequestException extends \RuntimeException
{
    protected $code = 400;

    protected $message = 'Invalid parameter(s)';
}

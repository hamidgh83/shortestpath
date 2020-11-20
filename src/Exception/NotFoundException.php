<?php

namespace Application\Exception;

class NotFoundException extends \RuntimeException
{
    protected $code = 404;

    protected $message = 'Page not found';
}

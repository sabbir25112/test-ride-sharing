<?php namespace App\Exceptions;


use Throwable;

class UserNotFoundException extends \Exception
{
    public function __construct($message = "User Not Found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

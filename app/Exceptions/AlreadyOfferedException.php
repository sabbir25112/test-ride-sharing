<?php namespace App\Exceptions;


use Throwable;

class AlreadyOfferedException extends \Exception
{
    public function __construct($message = "This Vehicle is already Offered", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

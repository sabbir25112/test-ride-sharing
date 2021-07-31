<?php namespace App\Exceptions;


use Throwable;

class VehicleNotFoundException extends \Exception
{
    public function __construct($message = "Vehicle Not Found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

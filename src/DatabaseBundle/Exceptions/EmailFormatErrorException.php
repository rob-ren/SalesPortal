<?php

namespace DatabaseBundle\Exceptions;

class EmailFormatErrorException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Your input email format is incorrect.");
    }
}
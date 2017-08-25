<?php

namespace DatabaseBundle\Exceptions;

class LocationNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Have not found results for this address, please double check the address .", 422);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 21/8/17
 * Time: 11:34 AM
 */

namespace AppBundle\Exceptions;

class EmailMessageTooShortException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Input Message is too short. Please input more than 10 words.");
    }
}
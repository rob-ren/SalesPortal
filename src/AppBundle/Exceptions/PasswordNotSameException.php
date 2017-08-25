<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 23/8/17
 * Time: 12:33 PM
 */

namespace AppBundle\Exceptions;

class PasswordNotSameException extends \Exception
{
    /**
     * Do not use 400 error code, this is indentified by JSON Paser error on app side
     */
    public function __construct()
    {
        parent::__construct("Input Password not Same.", 403);
    }
}
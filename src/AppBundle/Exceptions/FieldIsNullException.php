<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:17 PM
 */

namespace AppBundle\Exceptions;

class FieldIsNullException extends \Exception
{
    protected $field;

    public function __construct($field = NULL)
    {
        $this->field = $field;

        parent::__construct("Sorry, some fields can not be null.", 403);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:22 PM
 */

namespace AppBundle\Exceptions;

class FailToMoveFileException extends \Exception
{
    /**
     * Do not use 400 error code, this is indentified by JSON Paser error on app side
     */
    public function __construct()
    {
        parent::__construct("fail_move_directory", 403);
    }
}
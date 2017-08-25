<?php

namespace DatabaseBundle\Exceptions;

use DatabaseBundle\Common\StringHelper;

class AccountTypeErrorException extends \Exception
{
    public function __construct()
    {
        $array = StringHelper::EnumToArray("DatabaseBundle\Enum\AccountType");
        parent::__construct("Your input account is incorrect, please input " . implode(",", $array));
    }
}

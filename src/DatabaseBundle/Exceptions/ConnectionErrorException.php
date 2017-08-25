<?php

namespace DatabaseBundle\Exceptions;

class ConnectionErrorException extends \Exception {
	public function __construct() {
		parent::__construct ( "Your internet may be disconnected, please check your internet.",500 );
	}
}

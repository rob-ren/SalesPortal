<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 3:37 PM
 */

namespace DatabaseBundle\Common;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class SHAEncoder implements PasswordEncoderInterface
{

    public function encodePassword($raw, $salt)
    {
        return hash('sha256', $salt . $raw); // Custom function for password encrypt
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded === $this->encodePassword($raw, $salt);
    }

}
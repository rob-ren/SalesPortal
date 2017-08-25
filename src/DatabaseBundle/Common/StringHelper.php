<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 3:36 PM
 */

namespace DatabaseBundle\Common;

class StringHelper
{
    /**
     * generate a random string
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters [rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * convert enum to array
     *
     * @param $class
     * @return array
     */
    public static function EnumToArray($class)
    {
        $reflect = new \ReflectionClass ($class);
        $constants = $reflect->getConstants();
        return $constants;
    }

    /**
     * convert unknown object to array
     *
     * @param $obj
     * @return array
     */
    public static function ObjToArray($obj)
    {
        if (is_object($obj))
            $obj = ( array )$obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $val) {
                $new [] = StringHelper::ObjToArray($val);
            }
        } else {
            $new = $obj;
        }
        return $new;
    }

}
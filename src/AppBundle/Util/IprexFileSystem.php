<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:32 PM
 */

namespace AppBundle\Util;


interface IprexFileSystem
{
    function saveFile($path, $file, $new_name = null);

}
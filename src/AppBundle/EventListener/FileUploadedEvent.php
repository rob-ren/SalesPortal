<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:55 PM
 */

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;

class FileUploadedEvent extends Event
{
    protected $filePath;

    protected $uploadedTo;

    public function __construct($fileFullPath, $uploadedTo)
    {
        $this->filePath = $fileFullPath;
        $this->uploadedTo = $uploadedTo;
    }

    public function getFileFullPath(){
        return $this->filePath;
    }

    public function getUploadedTo(){
        return $this->uploadedTo;
    }

}
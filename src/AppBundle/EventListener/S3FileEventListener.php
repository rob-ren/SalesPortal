<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:55 PM
 */

namespace AppBundle\EventListener;

use Gaufrette\Filesystem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class S3FileEventListener implements EventSubscriberInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public static function getSubscribedEvents()
    {
        return array(
            "iprex.file.uploaded" => "onFileUploaded"
        );
    }

    public function onFileUploaded(FileUploadedEvent $event){
        $fileRelativePath = $event->getUploadedTo();
        if(strpos($fileRelativePath, DIRECTORY_SEPARATOR) === 0){
            $fileRelativePath = preg_replace('/\//', '', $fileRelativePath, 1);
        }
        $this->filesystem->write($fileRelativePath, file_get_contents($event->getFileFullPath()), true);
    }

}
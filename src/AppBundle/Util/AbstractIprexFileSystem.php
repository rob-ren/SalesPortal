<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:31 PM
 */

namespace AppBundle\Util;


use Gaufrette\Filesystem;
use AppBundle\EventListener\FileUploadedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractIprexFileSystem implements IprexFileSystem
{
    protected $fileSystem;

    protected $dispatcher;

    public function __construct(Filesystem $filesystem, EventDispatcherInterface $dispatcher)
    {
        $this->fileSystem = $filesystem;
        $this->dispatcher = $dispatcher;
    }

    public static function getProjectUploadFolder($user, $type, $project_id, $absolute = true){
        $username = hash ( "md5", $user->getUsername() );
        $path = DIRECTORY_SEPARATOR . self::getUploadFolder() . "/" . $username . "/$project_id/$type/";
        return $path;
    }

    public function saveFile($path, $file, $new_name = null){
        $file_name = $file["name"];
        $full_path = $new_name ? $path.$new_name : $path.$file_name;
        $data = base64_decode($file["content"]);
        $this->fileSystem->write($full_path, $data, true);
        $this->dispatcher->dispatch("iprex.file.uploaded", new FileUploadedEvent(self::getFilePath($full_path), $full_path));
    }

    public static function getFilePath($key){
        if(strpos($key, DIRECTORY_SEPARATOR . self::getUploadFolder()) === 0 || (strpos($key, self::getUploadFolder()) === 0)){
            $separator = strpos($key, DIRECTORY_SEPARATOR) === 0 ? "" : DIRECTORY_SEPARATOR;
            return WEBROOT . "$separator$key";
        }
        return WEBROOT . self::getUploadFolder() . DIRECTORY_SEPARATOR . $key;
    }

    public static function getUploadFolder()
    {
        return "uploads";
    }

}
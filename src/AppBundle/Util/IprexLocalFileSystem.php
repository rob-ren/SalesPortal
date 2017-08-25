<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:33 PM
 */

namespace AppBundle\Util;

use Gaufrette\Filesystem;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class IprexLocalFileSystem extends AbstractIprexFileSystem
{
    public function __construct(Filesystem $filesystem, $folder, EventDispatcherInterface $dispatcher)
    {
        parent::__construct($filesystem, $dispatcher);
    }
}
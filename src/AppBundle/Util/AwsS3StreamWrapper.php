<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 14/8/17
 * Time: 12:31 PM
 */

namespace AppBundle\Util;

use Aws\S3\S3Client;

class AwsS3StreamWrapper
{
    protected $s3;

    public function __construct($key, $secret, $region) {

        $aws = array(
            'credentials' => array(
                'key'    => $key,
                'secret' => $secret,
            ),
            'region' => $region,
            'version' => 'latest'
        );

        $this->s3 = new S3Client($aws);
    }

    public function registerStreamWrapper() {
        $this->s3->registerStreamWrapper();
    }

}
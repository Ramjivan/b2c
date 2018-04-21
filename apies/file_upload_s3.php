<?php

use Aws\S3\S3Client;

require '/../vendor/autoload.php';

$config = require('awsconfig.php');


$bucket = $config['s3']['bucket'];
//filename must be unique otherwise s3 is gonna rewrite previous file
$keyname = 'assets/images/test-img-file';
// $filepath should be absolute path to a file on disk						
$filepath = 'C:/xampp/htdocs/b2c/images/4bb592d50486e278e0a73d975f57dec2.jpg';
						
// Instantiate the client.
$s3 = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => 'ap-south-1',
    'credentials' => [
        'key'    => $config['s3']['key'],
        'secret' => $config['s3']['secret']
    ]
]);

// Upload a file.
$result = $s3->putObject(array(
    'Bucket'       => $bucket,
    'Key'          => $keyname,
    'SourceFile'   => $filepath,
    'ACL'          => 'private',
    'StorageClass' => 'STANDARD',
    'Metadata'     => array(    
        'param1' => 'value 1',
        'param2' => 'value 2'
    )
));

echo $result['ObjectURL'];

?>
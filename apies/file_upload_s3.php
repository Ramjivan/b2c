<?php
ini_set("display_errors", 1);

use Aws\S3\S3Client;

require dirname(__DIR__).'/vendor/autoload.php';

$config = require('awsconfig.php');


$bucket = $config['s3']['bucket'];
//filename must be unique otherwise s3 is gonna rewrite previous file
$keyname = 'assets/images/test-img-file';
// $filepath should be absolute path to a file on disk						
$filepath = dirname(__DIR__).'/images/8fe784ff93fc5819342242003ee700a6.jpg';
						
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

print_r($result['ObjectURL']);

?>
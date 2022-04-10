<?php
// since large buckets may take lots of time we remove any time limits
set_time_limit(0);
// set a default time zone in case it's not set
date_default_timezone_set('America/Chicago');

require sprintf('%s/../vendor/autoload.php', __DIR__);

use Aws\S3\Exception\S3Exception;
use DNL\S3BucketStreamZip\Exception\InvalidParameterException;
use DNL\S3BucketStreamZip\S3BucketStreamZip;

$auth = [
    'key'     => '*****',
    'secret'  => '*****',
    'region'  => 'us-east-1', // optional. defaults to us-east-1
    'version' => 'latest' // optional. defaults to latest
];

$stream = new S3BucketStreamZip($auth);

try {
    $stream->bucket('trashtest')
        ->prefix('trashfolder')
        ->send('name-of-zipfile-to-send.zip');
} catch (InvalidParameterException $e) {
    echo $e->getMessage();
} catch (S3Exception $e) {
    echo $e->getMessage();
}


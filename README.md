# S3BucketStreamZip

Forked from `jmathai/s3-bucket-stream-zip-php`

## Overview
This library lets you efficiently stream the contents of an S3 bucket/folder as a zip file to the client.

Uses v3 of AWS SDK to stream files directly from S3.

## Installation
Installation is done via composer by adding the a dependency on .

```
composer require dlintin/s3-stream-zip-php
composer install
```

## Usage
```php
// taken from examples/simple.php
// since large buckets may take lots of time we remove any time limits
set_time_limit(0);
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
    $stream->bucket('testbucket')
           ->prefix('testfolder') // prefix method adds a trailing '/'
           ->send('name-of-zipfile-to-send.zip');
} catch (InvalidParameterException $e) {
    // handle the exception
    echo $e->getMessage();
} catch (S3Exception $e) {
    // handle the exception
    echo $e->getMessage();
}
```


```php
$stream->bucket('another-test-bucket')
       ->prefix('test/')
       ->addParams([
           'MaxKeys' => 1, // array of other parameters
       ])
       ->send('zipfile-to-send.zip');
```

```php

// if prefix is not supplied, entire bucket contents are streamed
$stream->bucket('another-test-bucket')
       ->send('zipfile-to-send.zip');
```

## Laravel 5.4
- `pa make:provider AWSZipStreamServiceProvider` and copy the contents `examples/AwsZipStreamServiceProvider.php`. 
- Make sure your config values are all set.
- Register the provider in `config/app.php`.

### OR in `config/app.php`
```php
'providers' => [
    ...
    DNL\S3BucketStreamZip\AWSZipStreamServiceProvider::class,
    ...
]
```

in `config/services.php`, set:
```php
's3' => [
    'key'     => '', 
    'secret'  => '', 
    'region'  => '',
    'version' => '',
];
```

## Authors
* Jaisen Mathai <jaisen@jmathai.com> - http://jaisenmathai.com

## Dependencies
* Paul Duncan <pabs@pablotron.org> - http://pablotron.org/
* Jonatan Männchen <jonatan@maennchen.ch> - http://commanders.ch
* Jesse G. Donat <donatj@gmail.com> - https://donatstudios.com

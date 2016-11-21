# signed-s3-filesystem

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This package extends Laravel's S3 filesystem driver to return signed URLs via the Storage::url() command.

## Install

Via Composer

``` bash
$ composer require jdavidbakr/signed-s3-filesystem
```

Once installed, add the following to your providers array in cofig/app.php:

```
jdavidbakr\SignedS3Filesystem\SignedS3FilesystemServiceProvider::class,
```

This package makes use of the AWS facade, so be sure you have the following set in your providers array:

```
Aws\Laravel\AwsServiceProvider::class,
```

as well as in your alias array:

```
'AWS' => Aws\Laravel\AwsFacade::class,
```

You will also need to add the driver information to your config/filesystems.php file.  This driver uses the same info as the S3 driver, with an additional parameter for the length of time until the signed URL will expire.  If you do not specify an expiration time, URLs will default to expire 2 hours after being generated.

```
's3-signed' => [
    'driver' => 's3-signed',
    'key'    => 'your-key',
    'secret' => 'your-secret',
    'region' => 'your-region',
    'bucket' => 'your-bucket',
    'options' => [
    	'expiration'=>'time-to-expire-urls-in-seconds',
    ],
],
```

Because the expirtation option is optional, and everything else acts the same as the standard S3 driver, you can alternatively just change the driver value of the existing s3 section to 's3-signed'.

## Usage

Use this driver in the same manner as you would any other Laravel filesystem driver.  The Storage::url() command will return a signed URL.

``` php
$signed_url = Storage::disk('s3-signed')->url('path-to-file');
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email me@jdavidbaker.com instead of using the issue tracker.

## Credits

- [J David Baker][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jdavidbakr/signed-s3-filesystem.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jdavidbakr/signed-s3-filesystem/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jdavidbakr/signed-s3-filesystem.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jdavidbakr/signed-s3-filesystem.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jdavidbakr/signed-s3-filesystem.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jdavidbakr/signed-s3-filesystem
[link-travis]: https://travis-ci.org/jdavidbakr/signed-s3-filesystem
[link-scrutinizer]: https://scrutinizer-ci.com/g/jdavidbakr/signed-s3-filesystem/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/jdavidbakr/signed-s3-filesystem
[link-downloads]: https://packagist.org/packages/jdavidbakr/signed-s3-filesystem
[link-author]: https://github.com/jdavidbakr
[link-contributors]: ../../contributors

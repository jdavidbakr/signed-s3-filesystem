<?php

namespace jdavidbakr\SignedS3Filesystem;

use Illuminate\Support\ServiceProvider;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use Storage;
use Illuminate\Support\Arr;

class SignedS3FilesystemServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('s3-signed', function($app, $config) {
            // This is more or less a duplicate of what exists in
            // \Illuminate\Filesystem\FilesystemManager::createS3Driver
            // but pointing the adapter to our adapter
            $config += ['version' => 'latest'];

            if ($config['key'] && $config['secret']) {
                $config['credentials'] = Arr::only($config, ['key', 'secret']);
            }

            $root = isset($config['root']) ? $config['root'] : null;

            $options = isset($config['options']) ? $config['options'] : [];

            return new Filesystem(
                new SignedS3FilesystemAdapter(
                    new S3Client($config),
                    $config['bucket'],
                    $root,
                    $options
                ), $config
            );

            return $this->adapt($this->createFlysystem(
                new S3Adapter(new S3Client($config), $config['bucket'], $root, $options), $config
            ));
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
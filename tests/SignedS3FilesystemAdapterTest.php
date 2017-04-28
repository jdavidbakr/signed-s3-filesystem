<?php 

use Orchestra\Testbench\BrowserKit\TestCase;

class SignedS3FilesystemAdapterTest extends TestCase {

	protected function getPackageProviders($app)
	{
		return [
			'jdavidbakr\SignedS3Filesystem\SignedS3FilesystemServiceProvider',
			'Aws\Laravel\AwsServiceProvider',
		];
	}

	public function getPackageAliases($app)
	{
		return [
			'AWS'=>Aws\Laravel\AwsFacade::class
		];
	}

	public function getEnvironmentSetUp($app)
	{
		$app['config']->set('filesystems.disks.s3-signed',[
			'driver' => 's3-signed',
			'key'    => 'your-key',
			'secret' => 'your-secret',
			'region' => 'your-region',
			'bucket' => 'your-bucket',
			'options' => [
				'expiration'=>'time-to-expire-urls-in-seconds',
			],
		]);
	}

	/**
	 * @test
	 */
	public function it_returns_a_signed_url()
	{
		$url = Storage::disk('s3-signed')->url('test-url');
		$this->assertEquals(1,preg_match("/X-Amz-Content-Sha256/",$url));
	}
}
<?php 

class SignedS3FilesystemAdapterTest extends TestCase {

	/**
	 * @test
	 */
	public function it_returns_a_signed_url()
	{
		$url = Storage::disk('s3-signed')->url('test-url');
		$this->assertEquals(1,preg_match("/X-Amz-Content-Sha256/",$url));
	}
}
<?php 

namespace jdavidbakr\SignedS3Filesystem;

use League\Flysystem\AwsS3v3\AwsS3Adapter;
use AWS;

class SignedS3FilesystemAdapter extends AwsS3Adapter {

	public function getUrl($path)
	{
		if(!empty($this->options['expires'])) {
			$expire = \Carbon\Carbon::now()->addDays(2)->startOfDay()->timestamp;
		} else {
			$expire = \Carbon\Carbon::now()->addHours(2)->timestamp;
		}
        $path = $this->getPathPrefix().$path;
        $s3 = AWS::createClient('s3');
        $opt = [];
        $opt['Bucket'] = $this->bucket;
        $opt['Key'] = $path;
        $cmd = $s3->getCommand('GetObject', $opt);
        $request = $s3->createPresignedRequest($cmd, $expire);
        return (string) $request->getUri();
	}

}
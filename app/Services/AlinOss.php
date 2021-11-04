<?php

namespace App\Services;

use App\Exceptions\ApiException;
use OSS\Core\OssException;
use OSS\OssClient;

/**
 * 阿里云oss
 */
class AlinOss extends OssService
{
    /**
     * @throws ApiException
     */
    public function __construct()
    {
        $this->ossClient = $this->ossClient();
    }

    /**
     * @throws ApiException
     */
    public function uploadImage($path, $file)
    {
        try {
            $this->ossClient->uploadFile(env('ALI_BUCKET'), $path, $file);
        } catch (OssException $exception) {
            throw new ApiException($exception->getMessage());
        }
    }

    /**
     * @throws ApiException
     */
    protected function ossClient(): OssClient
    {
        try {
            return new OssClient(env('ALI_KEY'), env('ALI_SECRET'), env('ALI_ENDPOINT'));
        } catch (OssException $exception) {
            throw new ApiException($exception->getMessage());
        }
    }
}

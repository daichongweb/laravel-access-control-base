<?php

namespace App\Services;

abstract class OssService
{
    protected $ossClient;

    abstract public function uploadImage(string $path, $file);

    abstract protected function ossClient();
}

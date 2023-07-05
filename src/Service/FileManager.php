<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileManager
{

    public function getFileContent(string $path): array
    {
        if (!is_file($path)) throw new FileException('There is no file at : ' . $path);
        return file($path);
    }

}
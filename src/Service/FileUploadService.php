<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class FileUploadService {

    /**
     * @param File $file
     * @param string $destination
     * @throws FileException
     */
    public function doUpload(File $file, $destination) {

        $fileName = md5(uniqid()) . "." . $file->guessExtension();
        if ($file->move($destination, $fileName)) {
            return $fileName;
        }

        throw new FileException("Cannot upload file");
    }
}
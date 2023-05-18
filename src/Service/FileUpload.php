<?php

namespace App\Service;

use App\Entity\Entity;
use App\Exception\FileExsists;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUpload
{
    private string $destination;
    private UploadedFile $uploadedFile;

    public function __construct(
        UploadedFile $uploadedFile
    )
    {
        $this->uploadedFile = $uploadedFile;
        $this->destination = '/var/www/resources/files';
    }

    public function upload()
    {
        $originalFilename = pathinfo($this->uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $this->uploadedFile->guessExtension();
        FileExsists::check($originalFilename);

        return $this->uploadedFile->move(
            $this->destination,
            $newFilename
        );
    }
}
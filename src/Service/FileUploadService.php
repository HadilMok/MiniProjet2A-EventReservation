<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService
{
    public function __construct(
        private string $uploadDir,
        private SluggerInterface $slugger
    ) {}

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $filename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        $file->move($this->uploadDir, $filename);
        return $filename;
    }

    public function delete(string $filename): void
    {
        $path = $this->uploadDir . '/' . $filename;
        if (file_exists($path)) unlink($path);
    }
}

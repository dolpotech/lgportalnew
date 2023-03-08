<?php

namespace App\HelperClasses\Traits;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait StorageHelper
{

    public function storeToInformation($file, $directory)
    {
        $fileName = $file->getClientOriginalName();

        $extension = $file->getClientOriginalExtension();

        $this->createInformationStoragePathIfNotExist();

        $storagePath = getInformationStoragePath($directory);

        $this->checkAndCreateDirectory($storagePath);

        $filePath = Storage::disk('local')->putFileAs(getInformationStorageRelativePath($directory), $file, $fileName);

        return [
            'path' => $filePath,
            'name' => $fileName,
            'type' => $extension
        ];
    }

    public function checkAndCreateDirectory($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path,0755,true);
        }
    }

    public function createInformationStoragePathIfNotExist()
    {
        if (!File::exists(getInformationStoragePath())) {
            File::makeDirectory(getInformationStoragePath());
        }
    }

    public function storeToDocument($file, $directory)
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $this->createDocumentStoragePathIfNotExist();

        $storagePath = getDocumentStoragePath($directory);

        $this->checkAndCreateDirectoryDocument($storagePath);

        $path = Storage::disk('local')->put(getDocumentStorageRelativePath($directory), $file);

        return [
            'path' => $path,
            'name' => $fileName,
            'type' => $extension
        ];
    }

    public function checkAndCreateDirectoryDocument($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path,0755,true);
        }
    }

    public function createDocumentStoragePathIfNotExist()
    {
        if (!File::exists(getDocumentStoragePath())) {
            File::makeDirectory(getDocumentStoragePath());
        }
    }

}

<?php

use Illuminate\Support\Facades\Storage;

function deleteDir($dir)
{
    if (Storage::exists($dir)) {
        Storage::deleteDirectory($dir);
    }
}

function upload_as($dir, $file, $name)
{
    if ($file != null) {
        deleteDir($dir);
        if (is_file($file)) {
            $upload = $file->storeAs($dir, $name . '.' . $file->extension());
            return $upload;
        }
        return null;
    }
    return null;
}

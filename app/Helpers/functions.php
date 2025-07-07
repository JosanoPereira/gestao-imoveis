<?php

use Illuminate\Support\Facades\Storage;

function deleteDir($dir)
{
    if (Storage::disk('public')->exists($dir)) {
        Storage::disk('public')->deleteDirectory($dir);
    }
}

function upload_as($dir, $file, $name)
{
    if ($file != null && is_file($file)) {
        deleteDir($dir);
        $filename = $name . '.' . $file->extension();

        // Salva no disco 'public' => storage/app/public/
        $upload = $file->storeAs($dir, $filename, 'public');

        return $upload; // retorna "documentos/arquivo.pdf"
    }
    return null;
}

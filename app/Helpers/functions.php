<?php

use Illuminate\Support\Facades\DB;
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

function verificar_documento($numero, $tipo)
{
    $documento = \App\Models\Documento::all()->where('numero', $numero)
        ->where('tipo_documentos_id', $tipo)->first();
    if ($documento)
        return true;
    return false;
}

function verificar_contacto($telefone, $email)
{
    $contacto = DB::table('contactos')
        ->where('telefone', $telefone)
        ->orWhere('email', $email)->get()->first();
    if ($contacto)
        return true;
    return false;
}

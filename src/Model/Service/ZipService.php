<?php

namespace Model\Service;


class ZipService
{
    public function createZip($file_name,array $files)
    {

        $zip = new \ZipArchive();
        $filename = "$file_name" . "_" . uniqid() . '.zip';
        $filenamePath = ROOT . "../TEMP/{$filename}";

        if ($zip->open($filenamePath, \ZipArchive::CREATE) !== true) {
            throw new \Exception("Failed to open file {$filename}");
        }

        foreach ($files as $name => $file)
        {
            $zip->addFile(ROOT . "{$file}", "{$name}");
        }

        $zip->close();
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        readfile($filenamePath);
    }
}
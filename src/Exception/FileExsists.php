<?php

namespace App\Exception;

class FileExsists
{
    public static function check(string $originalFilename)
    {
        if (!empty($files = glob(('../resources/files/' . $originalFilename . '*')))) {
            self::throw($files);
        }
    }

    private static function throw(array $files)
    {
        echo json_encode([
            'status' => 'declined',
            'message' => 'Вы уже загружали эту фотографию'
        ]);

        array_map('unlink', $files);
        die();
    }
}
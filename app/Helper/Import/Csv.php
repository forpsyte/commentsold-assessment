<?php

namespace App\Helper\Import;

use Illuminate\Support\Facades\Storage;

class Csv implements ImportInterface
{

    /**
     * @inheritDoc
     */
    public static function import($filename, $delimiter = ',')
    {
        $data = [];
        $header = null;
        $path = database_path($filename);
        if (!file_exists($path) || !is_readable($path)) {
            return false;
        }

        if (($handle = fopen($path, 'r')) == false) {
            return false;
        }

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if(!$header) {
                $header = $row;
            } else {
                $data[] = array_combine($header, $row);
            }
        }

        fclose($handle);
        return $data;
    }
}

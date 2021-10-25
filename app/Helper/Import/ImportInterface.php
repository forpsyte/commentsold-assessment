<?php
/**
 * Copyright © Visiture, LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace App\Helper\Import;


interface ImportInterface
{
    /**
     * Reads the CSV file and returns data as an array.
     *
     * @param string $filename
     * @param string $delimiter
     * @return array
     */
    public static function import($filename, $delimiter = ',');
}

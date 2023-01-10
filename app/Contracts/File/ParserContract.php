<?php

namespace App\Contracts\File;

interface ParserContract {

    /**
     * Parse
     *
     * @param string $pathName
     * @param string $fileName
     * @param string $folderKey
     * @return mixed
     */
    public function parse(string $pathName, string $fileName, string $folderKey);
}

<?php

namespace App\Contracts\Json;

interface ParserContract {

    /**
     * Parse and translate params
     *
     * @param array $params
     * @return mixed
     */
    public function parse(array $params);
}

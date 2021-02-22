<?php

if (! function_exists('lambda')) {

    function lambda($key = "")
    {
        static $lambda;

        $rootPath = $_SERVER['DOCUMENT_ROOT'];

        $rootPath = str_replace('/public', '', $rootPath);
        if (! $lambda) {
            if (! file_exists($manifestPath = ($rootPath . '/lambda.json') )) {
                throw new Exception('The Lambda config oes not exist.'.$rootPath . '/lambda.json');
            }
            $lambda = json_decode(file_get_contents($manifestPath), true);
        }

        if($key != ""){
            if (! array_key_exists($key, $lambda)) {
                throw new Exception(
                    "Unable to : {$key}. "
                );
            }
            if($key == "static_words"){
                return $lambda["static_words"][$lambda["default_language"]];
            }
            return $lambda[$key];
        } else {
            return $lambda;
        }

    }
}

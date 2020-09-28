<?php

function get($dir)
{
    $result = [];
    $sDir = scandir($dir);
    var_dump($sDir);

    foreach ($sDir as $key => $value) {
        if (!in_array($value,array(".",".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                get($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                echo $value . PHP_EOL;
            }
        }
    }

    return $result;
}

var_dump(get('./start'));

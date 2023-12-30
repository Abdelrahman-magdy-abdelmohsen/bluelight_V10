<?php

namespace MVC\core;

class helper {
    public static function redirect($path) {
        $fullURL = "http://bluelight.com/" . $path;
        header("Location: " . $fullURL);
        exit(); // It's a good practice to add exit() after redirection to ensure no further code execution
    }
}

?>
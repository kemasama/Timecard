<?php 

// ***************
//   ClassLoader
// ***************

class ClassLoaderXProvide {
    private static $dirs;

    public static function loadFunc($class)
    {
        foreach (self::directories() as $directory) {
            $file_name = $directory . DIRECTORY_SEPARATOR . $class . ".php";
            if (is_file($file_name) && is_readable($file_name)) {
                require_once $file_name;
                return true;
            }
        }

        return false;
    }

    public static function loadClass($class) {
        $classPath = ltrim($class, '\\');
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);
        foreach (self::directories() as $directory) {
            $file_name = $directory . DIRECTORY_SEPARATOR . $classPath . ".php";

            if (is_file($file_name) && is_readable($file_name)) {
                require_once $file_name;

                return true;
            }
        }

        return false;
    }

    public static function regLibrary($dir) {
        self::$dirs[] = $dir;
    }

    private static function directories() {
        if (empty(self::$dirs)) {
            $base = __DIR__;
            self::$dirs = array(
                $base . "/classes",
            );

            if (defined("CLASS_DIR")) {
                self::$dirs[] = CLASS_DIR;
            }
        }

        return self::$dirs;
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb4602ea391f882afd763d03ff3f964c5
{
    public static $files = array (
        'e4588551e386dbaa223e5aaa020435da' => __DIR__ . '/../..' . '/inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WdRestApi\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WdRestApi\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb4602ea391f882afd763d03ff3f964c5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb4602ea391f882afd763d03ff3f964c5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

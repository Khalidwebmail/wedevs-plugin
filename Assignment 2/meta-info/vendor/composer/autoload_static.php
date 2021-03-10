<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8733b311fc236a9a2cb7d794d2c1c0c1
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Meta\\Info\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Meta\\Info\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8733b311fc236a9a2cb7d794d2c1c0c1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8733b311fc236a9a2cb7d794d2c1c0c1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
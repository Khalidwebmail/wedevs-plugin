<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5978228b33224de7c7fd3d51a4360e38
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Send\\Email\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Send\\Email\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5978228b33224de7c7fd3d51a4360e38::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5978228b33224de7c7fd3d51a4360e38::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

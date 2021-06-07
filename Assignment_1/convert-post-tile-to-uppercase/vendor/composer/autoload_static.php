<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd4019cdc94983c5ac89eb4b09c6576ea
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Post\\Title\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Post\\Title\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd4019cdc94983c5ac89eb4b09c6576ea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd4019cdc94983c5ac89eb4b09c6576ea::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd4019cdc94983c5ac89eb4b09c6576ea::$classMap;

        }, null, ClassLoader::class);
    }
}

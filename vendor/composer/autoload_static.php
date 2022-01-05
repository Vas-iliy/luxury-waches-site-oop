<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit85728ff1b69e1c75c83233bfd232aa6c
{
    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'luxury\\' => 7,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'V' => 
        array (
            'Valitron\\' => 9,
        ),
        'R' => 
        array (
            'RedBeanPHP\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'luxury\\' => 
        array (
            0 => __DIR__ . '/..' . '/luxury/core',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Valitron\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/valitron/src/Valitron',
        ),
        'RedBeanPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/gabordemooij/redbean/RedBeanPHP',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit85728ff1b69e1c75c83233bfd232aa6c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit85728ff1b69e1c75c83233bfd232aa6c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit85728ff1b69e1c75c83233bfd232aa6c::$classMap;

        }, null, ClassLoader::class);
    }
}

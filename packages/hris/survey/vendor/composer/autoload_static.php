<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit688b2da8d158a7ccd39b16711cc69c7c
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hris\\Survey\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hris\\Survey\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit688b2da8d158a7ccd39b16711cc69c7c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit688b2da8d158a7ccd39b16711cc69c7c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit688b2da8d158a7ccd39b16711cc69c7c::$classMap;

        }, null, ClassLoader::class);
    }
}

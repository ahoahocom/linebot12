<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

<<<<<<< HEAD
class ComposerStaticInit12def4b09334b461c8a3f5ac990a2e02
=======
class ComposerStaticInit19913e7bc0b911af4e15360f5b14e992
>>>>>>> 2dccfb7d247bc8cea34bc3f7f31928c2a3a6b2b2
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'L' => 
        array (
            'LINE\\' => 5,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
<<<<<<< HEAD
            $loader->prefixLengthsPsr4 = ComposerStaticInit12def4b09334b461c8a3f5ac990a2e02::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit12def4b09334b461c8a3f5ac990a2e02::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit12def4b09334b461c8a3f5ac990a2e02::$prefixesPsr0;
=======
            $loader->prefixLengthsPsr4 = ComposerStaticInit19913e7bc0b911af4e15360f5b14e992::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit19913e7bc0b911af4e15360f5b14e992::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit19913e7bc0b911af4e15360f5b14e992::$prefixesPsr0;
>>>>>>> 2dccfb7d247bc8cea34bc3f7f31928c2a3a6b2b2

        }, null, ClassLoader::class);
    }
}

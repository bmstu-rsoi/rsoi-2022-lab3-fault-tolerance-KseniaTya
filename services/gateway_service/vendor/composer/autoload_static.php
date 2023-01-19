<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc2fc441150f5d1dd25bb7dabb9edaa86
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'L' => 
        array (
            'LeoCarmo\\CircuitBreaker\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'LeoCarmo\\CircuitBreaker\\' => 
        array (
            0 => __DIR__ . '/..' . '/leocarmo/circuit-breaker-php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc2fc441150f5d1dd25bb7dabb9edaa86::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc2fc441150f5d1dd25bb7dabb9edaa86::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc2fc441150f5d1dd25bb7dabb9edaa86::$classMap;

        }, null, ClassLoader::class);
    }
}

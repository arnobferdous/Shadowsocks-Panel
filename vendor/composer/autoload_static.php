<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6de4c286ffbf2a51fc3824a0f17d8f94
{
    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'prodigyview\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'prodigyview\\' => 
        array (
            0 => __DIR__ . '/..' . '/prodigyview/prodigyview/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6de4c286ffbf2a51fc3824a0f17d8f94::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6de4c286ffbf2a51fc3824a0f17d8f94::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

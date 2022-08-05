<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit72c42aac3a340961eff006ade5007ba9
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit72c42aac3a340961eff006ade5007ba9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit72c42aac3a340961eff006ade5007ba9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit72c42aac3a340961eff006ade5007ba9::$classMap;

        }, null, ClassLoader::class);
    }
}
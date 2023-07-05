<?php

function testDocumentRoot()
{
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
    if (__DIR__ !== $documentRoot) {
        echo 'DocumentRoot:KO : Le serveur pointe sur '.__DIR__.' au lieu de '.$documentRoot;
    } else {
        echo 'DocumentRoot:OK';
    }
    echo PHP_EOL;
}

function onOff($setting)
{
    return "${setting}=".(ini_get($setting) ? 'on' : 'off');
}

function greaterThan($setting, $min)
{
    return $setting.'='.(ini_get($setting) >= $min ? 'ok' : 'ko').' ('.ini_get($setting).'>= '.$min.')'.PHP_EOL;
}
function lesserThan($setting, $max)
{
    return $setting.'='.(ini_get($setting) <= $max ? 'ok' : 'ko').' ('.ini_get($setting).'<= '.$max.')'.PHP_EOL;
}

function printStringSizeSettings()
{
    $scalarSettings = [
        'min' => [
        ],
        'max' => [
            'upload_max_filesize' => '32M',
            'post_max_size' => '33M',
        ],
    ];
    $extractMegabytes = function ($string) {
        if (preg_match('/.*M/i', $string)) {
            return (int) str_replace('M', '', $string);
        }
        if (preg_match('/.*G/i', $string)) {
            return (int) str_replace('G', '', $string) / 10;
        }
        return 0;
    };
    foreach ($scalarSettings['min'] as $setting => $min) {
        echo greaterThan($setting, $extractMegabytes($min));
    }
    foreach ($scalarSettings['max'] as $setting => $max) {
        echo lesserThan($setting, $extractMegabytes($max));
    }
}
function printScalarSettings()
{
    $scalarSettings = [
        'min' => [
            'memcached.sess_lock_wait_min' => 150,
        ],
        'max' => [
            'upload_max_filesize' => '32M',
            'post_max_size' => '33M',
            'memcached.sess_lock_wait_max' => 150,
            'memcached.sess_lock_retries' => 800,
            'opcache.revalidate_freq' => 0,
            'opcache.max_accelerated_files' => 7963,
            'opcache.memory_consumption' => 192,
            'opcache.interned_strings_buffer' => 16,
        ],
    ];
    foreach ($scalarSettings['min'] as $setting => $min) {
        echo greaterThan($setting, $min);
    }
    foreach ($scalarSettings['max'] as $setting => $max) {
        echo lesserThan($setting, $max);
    }
}

function printOnOffSetting($setting)
{
    echo onOff($setting).PHP_EOL;
}

function printSetting($setting)
{
    echo "${setting}=".ini_get($setting).PHP_EOL;
}

function printPhpConfiguration()
{
    $onOffSettings = [
        'short_open_tag',
        'magic_quotes_gpc',
        'register_globals',
        'session.autostart',
    ];
    $settings = [
        'date.timezone',
        'session.save_handler',
        'session.save_path',
        'opcache.validate_timestamps',
        'opcache.fast_shutdown',
    ];
    foreach ($onOffSettings as $setting) {
        printOnOffSetting($setting);
    }
    foreach ($settings as $setting) {
        printSetting($setting);
    }
    printScalarSettings();
    printStringSizeSettings();
}

function printLoadedExtensions()
{
    $required = [
        'ctype',
        'iconv',
        'json',
        'pcre',
        'session',
        'SimpleXML',
        'tokenizer',
        'curl',
        'gd',
        'intl',
        'mbstring',
        'pdo',
        'pdo-pgsql',
        'pgsql',
        'posix',
        'xml',
        'opcache',
        'memcached',
        'imagick',
        'apcu',
        'exif',
        'zip',
        'soap',
    ];
    foreach ($required as $item) {
        if (extension_loaded($item)) {
            echo $item.PHP_EOL;
        }
    }
}

echo '<pre>';
testDocumentRoot();
echo 'PHP extensions:'.PHP_EOL;

echo 'PHP configuration'.PHP_EOL;
printPhpConfiguration();
echo 'Apache modules:'.PHP_EOL;
echo 'PHP version:'.phpversion().PHP_EOL;
echo 'Extensions:'.PHP_EOL;
printLoadedExtensions();

echo '</pre>';

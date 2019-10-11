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
        'upload_max_filesize',
        'post_max_size',
        'sys_temp_dir',
        'upload_dir',
        'session.save_handler',
        'session.save_path',
        'memcached.sess_lock_wait_min',
        'memcached.sess_lock_wait_max',
        'memcached.sess_lock_retries',
        'opcache.revalidate_freq',
        'opcache.validate_timestamps',
        'opcache.max_accelerated_files',
        'opcache.memory_consumption',
        'opcache.interned_strings_buffer',
        'opcache.fast_shutdown',
    ];
    foreach ($onOffSettings as $setting) {
        printOnOffSetting($setting);
    }
    foreach ($settings as $setting) {
        printSetting($setting);
    }
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
        'apcu-bc',
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

<?php

// DEBUT ZONE A EDITER *************************************************************************************************

$FAROS_VERSION = '2023.04'; //0.6
$URL = 'https://acme.fr';

// htaccess
$USERNAME = 'EDIT_ME';
$PASSWORD = 'EDIT_ME';

// FIN DE ZONE A EDITER *******************************************************************************************

$PHP_VERSION = '8.2';

// TODO: KO
function get_ssl_http2_check(string $url, ?string $username, ?string $password): array
{
    $check = false;
    $ch = curl_init();
    curl_setopt_array($ch, [
        \CURLOPT_URL => $url,
        \CURLOPT_RETURNTRANSFER => true,
        \CURLOPT_MAXREDIRS => 10,
        \CURLOPT_FOLLOWLOCATION => true,
        \CURLOPT_CUSTOMREQUEST => 'HEAD',
        \CURLOPT_TIMEOUT => 0,
        \CURLOPT_HTTPHEADER => [
            'Authorization: Basic '.base64_encode(sprintf('%s:%s', $username, $password)),
        ],
        \CURLOPT_HTTP_VERSION => 3, // https://stackoverflow.com/a/34609756
    ]);
    //curl_setopt($ch, \CURLOPT_HTTP_VERSION, \CURL_HTTP_VERSION_2TLS);
    $httpCode = curl_getinfo($ch, \CURLINFO_RESPONSE_CODE);
    //var_dump(curl_getinfo($ch));
    curl_close($ch);
    if (200 === $httpCode) {
        $check = true;
    }

    return [
        'prerequis' => '<a href="https://faros.lephare.com/configuration#ssl--http2">SSL & HTTP/2</a>',
        'check' => $check,
        'bsClass' => get_bs_class($check),
        'checkLabel' => true === $check ? 'OK' : 'KO',
        'errorMessage' => true === $check ? '' : $httpCode,
    ];
}

// for OpCache
function get_call_itself_check(string $url, ?string $username, ?string $password): array
{
    $check = false;
    $curl = curl_init();

    curl_setopt_array($curl, [
        \CURLOPT_URL => $url,
        \CURLOPT_RETURNTRANSFER => true,
        \CURLOPT_MAXREDIRS => 10,
        \CURLOPT_FOLLOWLOCATION => true,
        \CURLOPT_CUSTOMREQUEST => 'HEAD',
        \CURLOPT_TIMEOUT => 0,
        \CURLOPT_HTTPHEADER => [
            'Authorization: Basic '.base64_encode(sprintf('%s:%s', $username, $password)),
        ],
    ]);

    $response = curl_exec($curl);

    $httpCode = curl_getinfo($curl, \CURLINFO_HTTP_CODE);
    $response = curl_exec($curl);
    curl_close($curl);
    if (200 === $httpCode) {
        $check = true;
    }

    return [
        'prerequis' => 'Peut appeler '.$url,
        'check' => $check,
        'bsClass' => get_bs_class($check),
        'checkLabel' => true === $check ? 'OK' : 'KO',
        'errorMessage' => true === $check ? '' : $httpCode,
    ];
}

function get_bs_class(bool $check): string
{
    return true === $check ? 'success' : 'danger';
}

function get_binaries_check(): array
{
    $checks = [];
    $binaries = ['/usr/bin/git', '/usr/bin/curl'];
    foreach ($binaries as $binary) {
        $check = is_executable($binary);
        $checks[] = [
            'prerequis' => 'Binaire '.$binary,
            'check' => $check,
            'bsClass' => get_bs_class($check),
            'checkLabel' => true === $check ? 'OK' : 'KO',
        ];
    }

    return $checks;
}

// TODO: KO car le user du script n'a pas les droits de lecture sur le fichier
function get_lephare_keys_check(): array
{
    $check = false;
    $curl = curl_init();
    curl_setopt($curl, \CURLOPT_URL, 'https://faros.lephare.com/lephare.keys');
    curl_setopt($curl, \CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, \CURLOPT_HEADER, false);
    $data = curl_exec($curl);
    $httpCode = curl_getinfo($curl, \CURLINFO_HTTP_CODE);
    curl_close($curl);
    if (200 === $httpCode) {
        $check = $data === file_get_contents('/home/acme/.ssh/authorized_keys');
    }

    return [
        'prerequis' => '<a href="https://faros.lephare.com/configuration#authentification-ssh" target="_blank">Authentification SSH</a>',
        'check' => $check,
        'errorMessage' => true === $check ? '' : 'Contenus différents',
        'bsClass' => true === $check ? 'success' : 'danger',
        'checkLabel' => true === $check ? 'OK' : 'KO',
    ];
}

function get_php_version_check(string $PHP_VERSION): array
{
    $check = version_compare(\PHP_VERSION, $PHP_VERSION, 'gt') && 0 === strpos(\PHP_VERSION, $PHP_VERSION[0]);

    return [
        'prerequis' => 'PHP_VERSION',
        'check' => $check,
        'errorMessage' => $check ? '' : 'Valeur détectée: '.\PHP_VERSION.'. Valeur attendue: '.$PHP_VERSION,
        'bsClass' => true === $check ? 'success' : 'danger',
        'checkLabel' => true === $check ? 'OK' : 'KO',
    ];
}

function get_document_root_check(): array
{
    $check = false;
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
    if (__DIR__ !== $documentRoot) {
        $errorMessage = 'DocumentRoot:KO : Le serveur pointe sur '.__DIR__.' au lieu de '.$documentRoot;
    } else {
        $check = true;
    }

    return [
        'prerequis' => 'DocumentRoot',
        'check' => $check,
        'errorMessage' => $errorMessage ?? '',
        'bsClass' => true === $check ? 'success' : 'danger',
        'checkLabel' => true === $check ? 'OK' : 'KO',
    ];
}

function get_php_configuration_checks(): array
{
    $checks = [];
    $settings = [
        // 'short_open_tag' => 'off', PHP_INI_PERDIR https://www.php.net/manual/en/ini.core.php
        // 'magic_quotes_gpc' => 'off', removed in PHP 5.4 https://www.php.net/manual/en/info.configuration.php#ini.magic-quotes-runtime
        // 'register_globals' => 'off', removed in PHP 5.4 https://www.php.net/manual/en/info.configuration.php#ini.magic-quotes-runtime
        'display_errors' => 'off',
        'display_startup_errors' => 'off',
        'session.auto_start' => 'off',
        'date.timezone' => 'Europe/Paris',
        'upload_max_filesize' => '32M',
        'post_max_size' => '33M',
        'sys_temp_dir' => '/var/tmp',
        'upload_tmp_dir' => '/var/tmp',
        'session.save_handler' => 'memcached',
        'session.save_path' => 'localhost:11211',
        'memcached.sess_lock_wait_min' => '150',
        'memcached.sess_lock_wait_max' => '150',
        'memcached.sess_lock_retries' => '800',
        'opcache.revalidate_freq' => '0',
        'opcache.validate_timestamps' => '0',
        'opcache.max_accelerated_files' => '20000',
        'opcache.memory_consumption' => '256',
        'opcache.interned_strings_buffer' => '16',
        'memory_limit' => '128M',
        'opcache.enable' => '1',
        'realpath_cache_size' => '4096K',
        'realpath_cache_ttl' => '60',
    ];
    foreach ($settings as $key => $expected) {
        $check = strtolower($expected) === strtolower(ini_get($key));
        $checks[] = [
            'prerequis' => $key.' = '.$expected,
            'check' => $check,
            'bsClass' => true === $check ? 'success' : 'danger',
            'checkLabel' => true === $check ? 'OK' : 'KO',
            'errorMessage' => true === $check ? '' : ini_get($key),
        ];
    }

    return $checks;
}

function get_loaded_extensions_symfony_checks(): array
{
    $checks = [];
    $symfonyRequirements = [
        'ctype',
        'iconv',
        'json',
        'pcre',
        'session',
        'SimpleXML',
        'tokenizer',
    ];

    foreach ($symfonyRequirements as $item) {
        $check = extension_loaded($item);
        $checks[] = [
            'prerequis' => $item,
            'check' => $check,
            'bsClass' => true === $check ? 'success' : 'danger',
            'checkLabel' => true === $check ? 'OK' : 'KO',
        ];
    }

    return $checks;
}

function get_loaded_extensions_faros_checks(): array
{
    $checks = [];
    $farosRequirements = [
        'curl',
        'gd',
        'intl',
        'mbstring',
        'pdo',
        'pdo_pgsql',
        'pgsql',
        'posix',
        'xml',
        //'opcache',
        'memcached',
        'imagick',
        'apcu',
        // TODO: ne marche pas 'apcu_bc',
        'exif',
        'zip',
        'soap',
    ];
    foreach ($farosRequirements as $item) {
        $check = extension_loaded($item);
        $checks[] = [
            'prerequis' => $item,
            'check' => $check,
            'bsClass' => true === $check ? 'success' : 'danger',
            'checkLabel' => true === $check ? 'OK' : 'KO',
        ];
    }

    return $checks;
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test compatibilité faros {$FAROS_VERSION}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <main>
        <div class="container" style="padding: 16px">
            <div class="row">
                <div class="col-sm">
        <h1>Test compatibilité Faros {$FAROS_VERSION}</h1>
        <div style="padding: 8px"><a href="https://faros.lephare.com/docs/versions/{$FAROS_VERSION}.html" target="_blank">Lien vers les prérequis</a></div>
HTML;
$mainChecks = <<<HTML
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Prérequis</th>
                    <th>OK ?</th>
                </tr>
            </thead>
            <tbody>
HTML;

/*
$lephareKeysCheck = getLephareKeysCheck();
$mainChecks .= <<<HTML
<tr>
    <td>{$lephareKeysCheck['prerequis']}</td>
    <td class="table-{$lephareKeysCheck['bsClass']}">{$lephareKeysCheck['checkLabel']} {$lephareKeysCheck['errorMessage']}</td>
</tr>
HTML;
 */

$callItselfCheck = get_call_itself_check($URL, $USERNAME, $PASSWORD);
$mainChecks .= <<<HTML
<tr>
    <td>{$callItselfCheck['prerequis']}</td>
    <td class="table-{$callItselfCheck['bsClass']}">{$callItselfCheck['checkLabel']} {$callItselfCheck['errorMessage']}</td>
</tr>
HTML;

$phpVersionCheck = get_php_version_check($PHP_VERSION);
$mainChecks .= <<<HTML
<tr>
    <td>{$phpVersionCheck['prerequis']}</td>
    <td class="table-{$phpVersionCheck['bsClass']}">{$phpVersionCheck['checkLabel']} {$phpVersionCheck['errorMessage']}</td>
</tr>
HTML;

$mainChecks .= <<<HTML
</tbody>
        </table>
HTML;

$html .= $mainChecks;

$binariesChecksTable = <<<HTML
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Binaires</th>
                    <th>OK ?</th>
                </tr>
            </thead>
            <tbody>
HTML;
$binariesChecks = get_binaries_check();
foreach ($binariesChecks as $binaryCheck) {
    $binariesChecksTable .= <<<HTML
<tr>
    <td>{$binaryCheck['prerequis']}</td>
    <td class="table-{$binaryCheck['bsClass']}">{$binaryCheck['checkLabel']}</td>
</tr>
HTML;
}
$binariesChecksTable .= <<<HTML
</tbody>
        </table>
HTML;

$html .= $binariesChecksTable;

$html .= <<<HTML
<h2 style="margin-top: 32px">Configuration PHP</h2>
<h3>Extensions <a href="https://faros.lephare.com/configuration#extensions" target="_blank">#</a></h3>
HTML;

$symfonyExtensionsTable = <<<HTML
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Pré-requis pour Symfony</th>
                    <th>OK ?</th>
                </tr>
            </thead>
            <tbody>
HTML;
$loadedExtensionsSymfonyChecks = get_loaded_extensions_symfony_checks();
foreach ($loadedExtensionsSymfonyChecks as $loadedExtensionsCheck) {
    $symfonyExtensionsTable .= <<<HTML
<tr>
    <td>{$loadedExtensionsCheck['prerequis']}</td>
    <td class="table-{$loadedExtensionsCheck['bsClass']}">{$loadedExtensionsCheck['checkLabel']}</td>
</tr>
HTML;
}
$symfonyExtensionsTable .= <<<HTML
</tbody>
        </table>
HTML;

$html .= $symfonyExtensionsTable;

$farosExtensionsTable = <<<HTML
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Extensions supplémentaires pour nos applications</th>
                    <th>OK ?</th>
                </tr>
            </thead>
            <tbody>
HTML;
$loadedExtensionsFarosChecks = get_loaded_extensions_faros_checks();
foreach ($loadedExtensionsFarosChecks as $loadedExtensionsCheck) {
    $farosExtensionsTable .= <<<HTML
<tr>
    <td>{$loadedExtensionsCheck['prerequis']}</td>
    <td class="table-{$loadedExtensionsCheck['bsClass']}">{$loadedExtensionsCheck['checkLabel']}</td>
</tr>
HTML;
}
$farosExtensionsTable .= <<<HTML
</tbody>
        </table>
HTML;

$html .= $farosExtensionsTable;

$html .= <<<HTML
<h3 style="margin-top: 24px">php.ini <a href="https://faros.lephare.com/configuration#phpini" target="_blank">#</a></h3>
HTML;

$phpConfigurationCheckTable = <<<HTML
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Setting</th>
                    <th>OK ?</th>
                </tr>
            </thead>
            <tbody>
HTML;
$phpConfigurationChecks = get_php_configuration_checks();
foreach ($phpConfigurationChecks as $check) {
    $phpConfigurationCheckTable .= <<<HTML
<tr>
    <td>{$check['prerequis']}</td>
    <td class="table-{$check['bsClass']}">{$check['checkLabel']} {$check['errorMessage']}</td>
</tr>
HTML;
}
$phpConfigurationCheckTable .= <<<HTML
</tbody>
        </table>
HTML;

$html .= $phpConfigurationCheckTable;

$html .= <<<HTML
<h2 style="margin-top: 32px">Configuration Apache <a href="https://faros.lephare.com/configuration#configuration-apache" target="_blank">#</a></h2>
HTML;

$documentRootCheck = get_document_root_check();
$sslHttp2Check = get_ssl_http2_check($URL, $USERNAME, $PASSWORD);
$apacheChecks = <<<HTML
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Setting</th>
                    <th>OK ?</th>
                </tr>
            </thead>
            <tbody>

HTML;

$apacheChecks .= <<<HTML
<tr>
    <td>{$documentRootCheck['prerequis']}</td>
    <td class="table-{$documentRootCheck['bsClass']}">{$documentRootCheck['checkLabel']} {$documentRootCheck['errorMessage']}</td>
</tr>
HTML;

/*
<tr>
    <td>{$sslHttp2Check['prerequis']}</td>
    <td class="table-{$sslHttp2Check['bsClass']}">{$sslHttp2Check['checkLabel']} {$sslHttp2Check['errorMessage']}</td>
</tr>
*/

$apacheChecks .= <<<HTML

HTML;

$html .= $apacheChecks;

$html .= <<<HTML
                </div>
            </div>
        </div>
    </main>
</body>
</html>
HTML;

echo $html;

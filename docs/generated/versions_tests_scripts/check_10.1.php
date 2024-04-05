<?php

$versionData = json_decode('{"commonConfigLoaded":true,"expected_vcpus":2,"expected_ram_go":4,"ip_to_authorize":["37.59.114.65","193.39.2.4","80.15.143.1"],"binaries":["/usr/bin/curl","/usr/bin/git"],"binaries_to_display":["Python 3.5 - 3.11, pr\u00e9-requis pour [managed node Ansible](https://docs.ansible.com/ansible/latest/installation_guide/intro_installation.html#managed-node-requirements)","curl","git","git-lfs","pg_dump (utilis\u00e9 par lephare/ansible-deploy)","rsync"],"version":"10.1","fullVersionName":"10.1 (2021.03)","apache_version":2.4,"debian_version":10,"faros_requirements":["_opcache - not tested by check_script","_pcntl - not tested by check_script","apcu","curl","exif","gd","imagick","intl","mbstring","memcached","pdo","pdo_pgsql","pgsql","posix","soap","xml","zip"],"ht_access_password":"EDIT_ME","ht_access_username":"EDIT_ME","order_in_list":5,"pgsql_version":11,"php_version":7.4,"settings":{"display_errors":"Off","display_startup_errors":"Off","session.auto_start":"off","date.timezone":"Europe/Paris","upload_max_filesize":"32M","post_max_size":"33M","sys_temp_dir":"/var/tmp","upload_tmp_dir":"/var/tmp","_comment1":"\n\n\t# Les sessions sont stock\u00e9es dans memcached -->","session.save_handler":"memcached","session.save_path":"localhost:11211","memcached.sess_lock_wait_min":"150","memcached.sess_lock_wait_max":"150","memcached.sess_lock_retries":"800","_comment2":"\n\n\t# Optimisation opcache -->","opcache.revalidate_freq":"0","opcache.validate_timestamps":"0","opcache.max_accelerated_files":"20000","opcache.memory_consumption":"<=256","opcache.interned_strings_buffer":"16","short_open_tag":"Off","memory_limit":"128M","opcache.enable":"1","_comment3":"\n\n\t# Realpath cache -->","realpath_cache_size":"4096K","realpath_cache_ttl":"60"},"symfony_requirements":["SimpleXML","ctype","iconv","json","pcre","session","tokenizer"],"URL":"https://acme.fr"}'); // injected by the generator php script, homemade php template manager
// DEBUT ZONE A EDITER *************************************************************************************************
if (null === $versionData) {
    echo 'injected json read is null';
    exit(84);
}
$FAROS_VERSION = $versionData->version; // 0.6 // @phpstan-ignore-line
$URL = $versionData->URL;

// htaccess
$USERNAME = $versionData->ht_access_username;
$PASSWORD = $versionData->ht_access_password;

// FIN DE ZONE A EDITER *******************************************************************************************

$PHP_VERSION = $versionData->php_version;

// TODO: KO
// function get_ssl_http2_check(string $url, ?string $username, ?string $password): array
// {
//     $check = false;
//     $ch = curl_init();
//     curl_setopt_array($ch, [
//         \CURLOPT_URL => $url,
//         \CURLOPT_RETURNTRANSFER => true,
//         \CURLOPT_MAXREDIRS => 10,
//         \CURLOPT_FOLLOWLOCATION => true,
//         \CURLOPT_CUSTOMREQUEST => 'HEAD',
//         \CURLOPT_TIMEOUT => 0,
//         \CURLOPT_HTTPHEADER => [
//             'Authorization: Basic '.base64_encode(sprintf('%s:%s', $username, $password)),
//         ],
//         \CURLOPT_HTTP_VERSION => 3, // https://stackoverflow.com/a/34609756
//     ]);
//     //curl_setopt($ch, \CURLOPT_HTTP_VERSION, \CURL_HTTP_VERSION_2TLS);
//     $httpCode = curl_getinfo($ch, \CURLINFO_RESPONSE_CODE);
//     //var_dump(curl_getinfo($ch));
//     curl_close($ch);
//     if (200 === $httpCode) {
//         $check = true;
//     }

//     return [
//         'prerequis' => '<a href="https://faros.lephare.com/configuration#ssl--http2">SSL & HTTP/2</a>',
//         'check' => $check,
//         'bsClass' => get_bs_class($check),
//         'checkLabel' => true === $check ? 'OK' : 'KO',
//         'errorMessage' => true === $check ? '' : $httpCode,
//     ];
// }

// for OpCache
function get_call_itself_check(string $url, ?string $username, ?string $password): array
{
    $check = false;

    $context = stream_context_create([
        'http' => [
            'method' => 'HEAD',
            'header' => 'Authorization: Basic '.base64_encode(sprintf('%s:%s', $username, $password)),
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    $httpCode = 0;
    if (false !== $response) {
        // Successfully retrieved the resource
        $http_response_header = $http_response_header ?? [];

        foreach ($http_response_header as $header) {
            if (0 === strpos($header, 'HTTP/')) {
                $parts = explode(' ', $header);
                $httpCode = (int) $parts[1];
                break;
            }
        }

        if (200 === $httpCode) {
            $check = true;
        }
    }

    return [
        'prerequis' => 'Peut appeler '.$url,
        'check' => $check,
        'bsClass' => get_bs_class($check),
        'checkLabel' => $check ? 'OK' : 'KO',
        'errorMessage' => $check ? '' : $httpCode,
    ];
}

function get_bs_class(bool $check): string
{
    return true === $check ? 'success' : 'danger';
}

function get_binaries_check(): array
{
    global $versionData;
    $checks = [];
    $binaries = $versionData->binaries;
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
// function get_lephare_keys_check(): array
// {
//     $check = false;
//     $curl = curl_init();
//     curl_setopt($curl, \CURLOPT_URL, 'https://faros.lephare.com/lephare.keys');
//     curl_setopt($curl, \CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($curl, \CURLOPT_HEADER, false);
//     $data = curl_exec($curl);
//     $httpCode = curl_getinfo($curl, \CURLINFO_HTTP_CODE);
//     curl_close($curl);
//     if (200 === $httpCode) {
//         $check = $data === file_get_contents('/home/acme/.ssh/authorized_keys');
//     }

//     return [
//         'prerequis' => '<a href="https://faros.lephare.com/configuration#authentification-ssh" target="_blank">Authentification SSH</a>',
//         'check' => $check,
//         'errorMessage' => true === $check ? '' : 'Contenus différents',
//         'bsClass' => true === $check ? 'success' : 'danger',
//         'checkLabel' => true === $check ? 'OK' : 'KO',
//     ];
// }

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

function check_comparator_int_phpini($keyValue, $expected): bool
{
    $check = false;
    $biggerAuthorized = ('>' == $expected[0]); // so if false it authorizes under.
    $equalAuthorized = ('=' == $expected[1]);
    $integerPartExpected = $equalAuthorized ? substr($expected, 2) : substr($expected, 1);
    $extractedIntegerExpected = intval($integerPartExpected);
    $extractedIntegerKeyValue = intval($keyValue);

    if ($biggerAuthorized && $equalAuthorized) {
        $check = ($extractedIntegerKeyValue >= $extractedIntegerExpected);
    } elseif (!$biggerAuthorized && $equalAuthorized) {
        $check = ($extractedIntegerKeyValue <= $extractedIntegerExpected);
    } elseif ($biggerAuthorized && !$equalAuthorized) {
        $check = ($extractedIntegerKeyValue > $extractedIntegerExpected);
    } elseif (!$biggerAuthorized && !$equalAuthorized) {
        $check = ($extractedIntegerKeyValue < $extractedIntegerExpected);
    }

    return $check;
}

function check_value_phpini(string $keyValue, string $expected): bool
{
    $check = false;

    if ('off' == strtolower($expected)) {
        $check = ('' == $keyValue or '0' == $keyValue or 'off' == $keyValue or 'Off' == $keyValue);
    } elseif ('on' == strtolower($expected)) {
        $check = ('1' == $keyValue or 'on' == $keyValue or 'On' == $keyValue);
    } elseif ('<' == $expected[0] or '>' == $expected[0]) {
        $check = check_comparator_int_phpini($keyValue, $expected);
    } else {
        $check = strtolower($expected) === strtolower($keyValue);
    }

    return $check;
}

function get_php_configuration_checks(): array
{
    global $versionData;
    $checks = [];
    $settings = $versionData->settings;

    foreach ($settings as $key => $expected) {
        $keyValue = ini_get($key);
        if ('_' == substr($key, 0, 1)) {
            continue;
        }
        $check = check_value_phpini($keyValue, $expected);
        $errMessage = $keyValue;
        if ('' == $keyValue) {
            $errMessage = 'Value is null.';
        }
        if (false === $keyValue) {
            $errMessage = 'Option do not exist.';
        }
        $checks[] = [
            'prerequis' => $key.' = '.$expected,
            'check' => $check,
            'bsClass' => true === $check ? 'success' : 'danger',
            'checkLabel' => true === $check ? 'OK' : 'KO',
            'errorMessage' => true === $check ? '' : $errMessage,
        ];
    }

    return $checks;
}

function get_loaded_extensions_symfony_checks(): array
{
    global $versionData;
    $checks = [];
    $symfonyRequirements = $versionData->symfony_requirements;

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
    global $versionData;
    $checks = [];
    $farosRequirements = $versionData->faros_requirements;
    foreach ($farosRequirements as $item) {
        if ('_' === substr($item, 0, 1)) {
            continue;
        } // if begin by _, then we don't want it to be tested.
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
$mainChecks = <<<'HTML'

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

$mainChecks .= <<<'HTML'
</tbody>
        </table>
HTML;

$html .= $mainChecks;

$binariesChecksTable = <<<'HTML'
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
$binariesChecksTable .= <<<'HTML'
</tbody>
        </table>
HTML;

$html .= $binariesChecksTable;

$html .= <<<'HTML'
<h2 style="margin-top: 32px">Configuration PHP</h2>
<h3>Extensions <a href="https://faros.lephare.com/configuration#extensions" target="_blank">#</a></h3>
HTML;

$symfonyExtensionsTable = <<<'HTML'
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
$symfonyExtensionsTable .= <<<'HTML'
</tbody>
        </table>
HTML;

$html .= $symfonyExtensionsTable;

$farosExtensionsTable = <<<'HTML'
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
$farosExtensionsTable .= <<<'HTML'
</tbody>
        </table>
HTML;

$html .= $farosExtensionsTable;

$html .= <<<'HTML'
<h3 style="margin-top: 24px">php.ini <a href="https://faros.lephare.com/configuration#phpini" target="_blank">#</a></h3>
HTML;

$phpConfigurationCheckTable = <<<'HTML'
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
$phpConfigurationCheckTable .= <<<'HTML'
</tbody>
        </table>
HTML;

$html .= $phpConfigurationCheckTable;

$html .= <<<'HTML'
<h2 style="margin-top: 32px">Configuration Apache <a href="https://faros.lephare.com/configuration#configuration-apache" target="_blank">#</a></h2>
HTML;

$documentRootCheck = get_document_root_check();
// $sslHttp2Check = get_ssl_http2_check($URL, $USERNAME, $PASSWORD);
$apacheChecks = <<<'HTML'
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

$apacheChecks .= <<<'HTML'

HTML;

$html .= $apacheChecks;

$html .= <<<'HTML'
                </div>
            </div>
        </div>
    </main>
</body>
</html>
HTML;

echo $html;

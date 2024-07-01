<?php

define('FOLDER_VERSIONS_PATH', realpath(__DIR__.'/../versions_data'));
define('VERSIONS_PAGES_SITE_FOLDER', realpath(__DIR__.'/../docs/generated/versions_pages'));
define('VERSIONS_SCRIPTS_FOLDER', realpath(__DIR__.'/../docs/generated/versions_tests_scripts'));
define('TEMPLATES_FOLDER', realpath(__DIR__.'/templates'));

if ((false === FOLDER_VERSIONS_PATH) || (false === VERSIONS_PAGES_SITE_FOLDER) || (false === VERSIONS_SCRIPTS_FOLDER) || (false === TEMPLATES_FOLDER)) {
    echo 'Could not find required folders. Check that you are running this PHP script from the root folder of the project (not inside `tools/`).';
    exit(84);
}

function templateManage(string $templateContent, array $json): string
{
    $search = [];
    $fill = [];

    foreach ($json as $key => $value) {
        $search[] = '{{'.$key.'}}';
        $fill[] = $value;
    }

    return str_replace($search, $fill, $templateContent);
}

function getDataFromVersionfile(string $filePath, bool $directPath): array
{
    if (!$directPath) {
        $filePath = FOLDER_VERSIONS_PATH.'/'.$filePath;
    }
    $fileContent = file_get_contents($filePath);
    if (!$fileContent) {
        exit(84);
    }

    return json_decode($fileContent, true);
}

function handleVersionfileJson(array $versionJson): void
{
    $fullJson = array_merge_recursive(getDataFromVersionfile('shared.json', false), $versionJson);

    generateNewVersionsFiles($fullJson);
}

function generateMarkdownFile(array $json, string $newfilePath): void
{
    echo ' * Generating markdown file : '.$newfilePath."\n";
    $versionData = (object) $json;
    ob_start();
    require TEMPLATES_FOLDER.'/template.md.php';
    $content = ob_get_clean();
    file_put_contents($newfilePath, $content);
}

function generatePhpcheckFile(array $json, string $newfilePath): void
{
    echo ' * Generating php check script : '.$newfilePath."\n";
    $template = file_get_contents(TEMPLATES_FOLDER.'/check_version_script_template.php');
    if (false === $template) {
        return;
    }
    $filledContent = templateManage($template, ['jsontoinject' => json_encode($json, \JSON_UNESCAPED_SLASHES | \JSON_PRETTY_PRINT)]);
    file_put_contents($newfilePath, $filledContent);
}

function generateNewVersionsFiles(array $fullJson): void // .md & php
{
    $phpscriptFilepath = VERSIONS_SCRIPTS_FOLDER.'/check_'.$fullJson['version'].'.php';
    $markdownFilepath = VERSIONS_PAGES_SITE_FOLDER.'/'.$fullJson['version'].'.md';

    echo "\033[92mFAROS VERSION ".$fullJson['version']." --> Generating files....\033[0m\n";
    generateMarkdownFile($fullJson, $markdownFilepath);
    generatePhpcheckFile($fullJson, $phpscriptFilepath);
    echo "\n";
}

function generateAllVersions(): void
{
    $folder = opendir(FOLDER_VERSIONS_PATH);

    if ($folder) {
        while (false !== ($entry = readdir($folder))) {
            if ('.' != $entry && '..' != $entry) {
                if ('shared.json' == $entry) {
                    continue;
                }
                $json = getDataFromVersionfile($entry, false);
                handleVersionfileJson($json);
            }
        }
        closedir($folder);
    }
}

function generateOneVersion(string $filePath): void
{
    $json = getDataFromVersionfile($filePath, true);
    handleVersionfileJson($json);
}

function main(): void
{
    global $argv;

    if (2 == count($argv)) {
        generateOneVersion($argv[1]);
    } else {
        generateAllVersions();
    }
}

main();

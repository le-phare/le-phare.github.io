<?php

const FOLDER_VERSIONS_PATH = '../versions_data/';
const VERSIONS_PAGES_SITE_FOLDER = '../docs/generated/versions_pages/';
const VERSIONS_SCRIPTS_FOLDER = '../docs/generated/versions_tests_scripts/';
const TEMPLATES_FOLDER = './templates/';

/**
 * @param array<mixed, mixed> $json
 */
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

/**
 * @return array<mixed, mixed>
 */
function getDataFromVersionfile(string $filePath, bool $directPath): array
{
    if (!$directPath) {
        $filePath = FOLDER_VERSIONS_PATH.$filePath;
    }
    $fileContent = file_get_contents($filePath);
    if (!$fileContent) {
        exit(84);
    }

    return json_decode($fileContent, true);
}

/**
 * @param array<mixed, mixed> $versionJson
 */
function handleVersionfileJson(array $versionJson, string $entry): void
{
    $fullJson = array_merge_recursive(getDataFromVersionfile('shared.json', false), $versionJson);

    generateNewVersionsFiles($fullJson, $entry);
}

/**
 * @param array<mixed, mixed> $json
 */
function generateMarkdownFile(array $json, string $newfilePath, string $entry): void
{
    echo ' * Generating markdown file : '.$newfilePath."\n";
    $status = exec('php '.TEMPLATES_FOLDER.'template.md.php "'.FOLDER_VERSIONS_PATH.$entry.'" > '.$newfilePath, $output, $return);
    if ($return) {
        echo "\033[0;31mGenerating markdown file via exec() failed\033[0m\n";
    }
}

/**
 * @param array<mixed, mixed> $json
 */
function generatePhpcheckFile(array $json, string $newfilePath): void
{
    echo ' * Generating php check script : '.$newfilePath."\n";
    $template = file_get_contents(TEMPLATES_FOLDER.'check_version_script_template.php');
    if (false === $template) {
        return;
    }
    $filledContent = templateManage($template, ['jsontoinject' => json_encode($json)]);
    file_put_contents($newfilePath, $filledContent);
}

/**
 * @param array<mixed, mixed> $fullJson
 */
function generateNewVersionsFiles(mixed $fullJson, string $entry): void // .md & php
{
    $phpscriptFilepath = VERSIONS_SCRIPTS_FOLDER.'check_'.$fullJson['version'].'.php';
    $markdownFilepath = VERSIONS_PAGES_SITE_FOLDER.$fullJson['version'].'.md';

    echo "\033[92mFAROS VERSION ".$fullJson['version']." --> Generating files....\033[0m\n";
    generateMarkdownFile($fullJson, $markdownFilepath, $entry);
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
                handleVersionfileJson($json, $entry);
            }
        }
        closedir($folder);
    }
}

function generateOneVersion(string $filePath): void
{
    $json = getDataFromVersionfile($filePath, true);
    handleVersionfileJson($json, basename($filePath));
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

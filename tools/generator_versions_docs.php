<?php

const FOLDER_VERSIONS_PATH = '../versions_data/';
const VERSIONS_PAGES_SITE_FOLDER = '../docs/generated/versions_pages/';
const VERSIONS_SCRIPTS_FOLDER = '../docs/generated/versions_tests_scripts/';

function cleanOperatorValue(string $value): string
{
    if ('<' == $value[0] or '>' == $value[0]) {
        if ('=' == $value[1]) {
            $value = substr($value, 2);
        } else {
            $value = substr($value, 1);
        }
    }

    return $value;
}

/**
 * @param array<mixed, mixed> $array
 */
function arrayToMarkdownList(array $array): string // arrays are automatically markdown list str in template.
{
    $markdownList = '';

    foreach ($array as $key => $value) {
        if (is_string($key)) { // mostly php.ini
            if ('_' != substr($key, 0, 1)) { // not a array comment _comment1 like.
                $markdownList .= "\t".$key.' = '.cleanOperatorValue($value)."\n";
            } else {
                $markdownList .= "\t".$value."\n";
            }
        } else {
            if ('_' === substr($value, 0, 1)) {
                $value = substr($value, 1);
            }
            $markdownList .= '* '.$value."\n"; // normal list
        }
    }

    return $markdownList;
}

/**
 * @param array<mixed, mixed> $json
 */
function templateManage(string $templateContent, array $json): string
{
    $search = [];
    $fill = [];

    foreach ($json as $key => $value) {
        $search[] = '{{'.$key.'}}';
        if (is_array($value)) {
            $fill[] = arrayToMarkdownList($value);
            continue;
        }
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
function handleVersionfileJson(array $versionJson): void
{
    $fullJson = array_merge_recursive(getDataFromVersionfile('shared.json', false), $versionJson);

    generateNewVersionsFiles($fullJson);
}

/**
 * @param array<mixed, mixed> $json
 */
function generateMarkdownFile(array $json, string $newfilePath): void
{
    echo ' * Generating markdown file : '.$newfilePath."\n";
    $template = file_get_contents('./templates/template.md');
    if (false === $template) {
        return;
    }
    $filledContent = templateManage($template, $json);
    file_put_contents($newfilePath, $filledContent);
}

/**
 * @param array<mixed, mixed> $json
 */
function generatePhpcheckFile(array $json, string $newfilePath): void
{
    echo ' * Generating php check script : '.$newfilePath."\n";
    $template = file_get_contents('./templates/check_version_script_template.php');
    if (false === $template) {
        return;
    }
    $filledContent = templateManage($template, ['jsontoinject' => json_encode($json)]);
    file_put_contents($newfilePath, $filledContent);
}

/**
 * @param array<mixed, mixed> $fullJson
 */
function generateNewVersionsFiles(mixed $fullJson): void // .md & php
{
    $phpscriptFilepath = VERSIONS_SCRIPTS_FOLDER.'check_'.$fullJson['version'].'.php';
    $markdownFilepath = VERSIONS_PAGES_SITE_FOLDER.$fullJson['version'].'.md';

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

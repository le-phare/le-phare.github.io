<?php 
const FOLDER_VERSIONS_PATH = '../versions_data/';
const VERSIONS_PAGES_SITE_FOLDER = '../docs/generated/versions_pages/';
const VERSIONS_SCRIPTS_FOLDER = '../docs/generated/versions_tests_scripts/';


function arrayToMarkdownList($array) { //arrays are automatically markdown list str in template.
    $markdownList = "";

    foreach ($array as $key => $value) {
        if (substr($value,0,1) === '#') {
            $markdownList .= "\n\t" . $value . "\n"; # comment with newline
        } else if (is_string($key)) {
            $markdownList .= "\t" . $key . " = " . $value . "\n"; #mostly php.ini
        } else {
            if (substr($value,0,1) === '_') {
                $value = substr($value, 1);
            }
            $markdownList .= "* " . $value . "\n"; #normal list
        }
    }
    return $markdownList;
}

function templateManage($templateContent, $json) {
    $search = [];
    $fill = [];

    foreach ($json as $key => $value) {
        $search[] = "{{" . $key . "}}";
        if (is_array($value)) {
            $fill[] = arrayToMarkdownList($value);
            continue;
        }
        $fill[] = $value;
    }
    return str_replace($search, $fill, $templateContent);
}

function getDataFromVersionfile($filename) {
    $filePath = FOLDER_VERSIONS_PATH . $filename;
    $fileContent = file_get_contents($filePath);
    $jsonData = json_decode($fileContent, true);

    return $jsonData;
}

function handleVersionfileJson($versionJson) {
    $fullJson = array_merge(getDataFromVersionfile("shared.json"), $versionJson);

    generateNewVersionsFiles($fullJson);
}

function generateMarkdownFile($json, $newfilePath) {
    print(" * Generating markdown file : " . $newfilePath . "\n");
    $template = file_get_contents("./templates/template.md.lepharetemplate");
    $filledContent = templateManage($template, $json);

    file_put_contents($newfilePath, $filledContent);
}

function generatePhpcheckFile($json, $newfilePath) {
    print(" * Generating php check script : " . $newfilePath . "\n");
    $template = file_get_contents("./templates/check_version_script_template.php");
    $filledContent = templateManage($template, array("jsontoinject" => json_encode($json)));

    file_put_contents($newfilePath, $filledContent);
}

function generateNewVersionsFiles($fullJson) { //.md & php
    $phpscriptFilepath = VERSIONS_SCRIPTS_FOLDER . "check_" . $fullJson["version"] . ".php";
    $markdownFilepath = VERSIONS_PAGES_SITE_FOLDER . $fullJson["version"] . ".md";

    print("\033[92mFAROS VERSION " . $fullJson["version"] . " --> Generating files....\033[0m\n");
    generateMarkdownFile($fullJson, $markdownFilepath);
    generatePhpcheckFile($fullJson, $phpscriptFilepath);
    print("\n");
}

function main() {
    $folder = opendir(FOLDER_VERSIONS_PATH);
    $entry = "";
    $json = "";

    if ($folder) {
        while (false !== ($entry = readdir($folder))) {
            if ($entry != "." && $entry != "..") {
                if ($entry == "shared.json") continue;
                $json = getDataFromVersionfile($entry);
                handleVersionfileJson($json);
            }
        }
        closedir($folder);
    }
}

main();
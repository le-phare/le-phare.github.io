 <?php 
const FOLDER_VERSIONS_PATH = '../versions_data/';
const VERSIONS_PAGES_SITE_FOLDER = '../docs/generated/versions_pages/';
const VERSIONS_SCRIPTS_FOLDER = '../docs/generated/versions_tests_scripts/';


function arrayToMarkdownList($array) { //arrays are automatically markdown list str in template.
    $markdownList = "";
    foreach ($array as $element) {
        $markdownList .= "* " . $element . "\n";
    }
    return $markdownList;
}

function templateManage($templateContent, $json) {
    $search = [];
    $fill = [];

    foreach ($json as $key => $value) {
        array_push($search, "{{" . $key . "}}");
        if (is_array($value)) {
            array_push($fill, arrayToMarkdownList($value));
            continue;
        }
        array_push($fill, $value);
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
    $fullJson = array_merge(getDataFromVersionfile("common.json"), $versionJson);

    generateNewVersionsFiles($fullJson);
}

function generateMarkdownFile($json, $newfilePath) {
    $template = file_get_contents("./templates/template.md.lepharetemplate");
    $filledContent = templateManage($template, $json);

    file_put_contents($newfilePath, $filledContent);
}

function generatePhpcheckFile($json, $newfilePath) {
    $template = file_get_contents("./templates/check_version_script_template.php");
    $filledContent = templateManage($template, array("jsontoinject" => json_encode($json)));

    file_put_contents($newfilePath, $filledContent);
}

function generateNewVersionsFiles($fullJson) { //.md & php
    $phpscriptFilepath = VERSIONS_SCRIPTS_FOLDER . "check_" . $fullJson["version"] . ".php";
    $markdownFilepath = VERSIONS_PAGES_SITE_FOLDER . $fullJson["version"] . ".md";

    generateMarkdownFile($fullJson, $markdownFilepath);
    generatePhpcheckFile($fullJson, $phpscriptFilepath);
}

function main() {
    $folder = opendir(FOLDER_VERSIONS_PATH);
    $entry = "";
    $json = "";

    if ($folder) {
        while (false !== ($entry = readdir($folder))) {
            if ($entry != "." && $entry != "..") {
                if ($entry == "common.json") continue;
                $json = getDataFromVersionfile($entry);
                handleVersionfileJson($json);
            }
        }
        closedir($folder);
    }
}

main();
?>
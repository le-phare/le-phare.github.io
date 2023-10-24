<?php 
$folder_versions_path = '../versions_data/';
$versions_pages_site_folder = '../docs/generated/versions_pages/';
$versions_scripts_folder = '../docs/generated/versions_tests_scripts/';
$common_config = get_version_file_json("common.json");

function get_version_file_json($filename) {
    global $folder_versions_path;
    $file_path = $folder_versions_path . $filename;
    $file_content = file_get_contents($file_path);
    $jsonData = json_decode($file_content, true);

    return $jsonData;
}

function handle_versionfile_json($versionjson) {
    global $common_config;
    $fulljson = array_merge($common_config, $versionjson);

    generate_version_files($fulljson);
}

function generate_md_file($json, $newfilepath) {
    
}

function generate_php_file($json, $newfilepath) {

}

function generate_version_files($fulljson) { //.md & php
    global $versions_pages_site_folder, $versions_scripts_folder;
    $phpscript_filepath = $versions_scripts_folder . "check_" . $fulljson["version"] . ".php";
    $docfile_mdpath = $versions_pages_site_folder . $fulljson["version"] . ".md";
    generate_md_file($fulljson, $docfile_mdpath);
    generate_php_file($fulljson, $phpscript_filepath);
}

function main() {
    global $folder_versions_path;
    $folder = opendir($folder_versions_path);
    $entry = "";
    $json = "";

    if ($folder) {
        while (false !== ($entry = readdir($folder))) {
            if ($entry != "." && $entry != "..") {
                if ($entry == "common.json") continue;
                $json = get_version_file_json($entry);
                handle_versionfile_json($json);
            }
        }
        closedir($folder);
    }
}

main();
?>
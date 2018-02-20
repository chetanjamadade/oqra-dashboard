<?php

function remoteFileExists($url){
    $curl = curl_init($url);
    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);
    //do request
    $result = curl_exec($curl);
    $ret = false;
    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

        if ($statusCode == 200) {
            $ret = true;   
        }
    }
    curl_close($curl);
    return $ret;
}

$remove = array('..','./','/','//');

if (isset($_GET['name']) && $_GET['name'] != '') {
    $name = str_replace($remove,'',$_GET['name']);
    if (empty($name) || $name == '.') exit; 
    $fileName = 'http://fluohead.com/oqra-dashboard/mobile-oqra/done/' . $name;
    if (remoteFileExists($fileName)) {
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$name."\""); 
        readfile($fileName);
    } else {
        echo 'File is not processed yet, allow 2 minutes to process';
    }
}
<?php 
/*
    $_SERVER["DOCUMENT_ROOT"] === /home/user/public_html;
    $_SERVER["SERVER_ADDR"]   === 143.34.112.23
    $_SERVER['HTTP_HOST']     === example.com (or with WWW)
    $_SERVER["REQUEST_URI"]   === /folder1/folder2/yourfile.php?var=blabla
    __FILE__                  === /home/user/public_html/folder1/folder2/yourfile.php
    basename(__FILE__)        === yourfile.php
    __DIR__                   === /home/user/public_html/folder1/folder2 [same: dirname(__FILE__)]
    $_SERVER["QUERY_STRING"]  === var=blabla

    $_SERVER["REQUEST_URI"]   === /folder1/folder2/yourfile.php?var=blabla
    parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)  === /folder1/folder2/yourfile.php
    $_SERVER["PHP_SELF"]      === /folder1/folder2/yourfile.php

    //if "YOURFILE.php" is included in "PARENTFILE.php" , and "PARENTFILE.PHP?abc"   is opened:
    $_SERVER["PHP_SELF"]       === /parentfile.php
    $_SERVER["REQUEST_URI"]    === /parentfile.php?abc
    $_SERVER["SCRIPT_FILENAME"]=== /home/user/public_html/parentfile.php
    str_replace($_SERVER["DOCUMENT_ROOT"],'', str_replace('\\','/',__FILE__ ) )  === /folder1/folder2/yourfile.php

 */
?>
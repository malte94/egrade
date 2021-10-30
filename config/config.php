<?php

const ROOT_PATH = "/var/www/vhosts/hosting144656.a2e8e.netcup.net/httpdocs/zeugnis";
const APP_URL = "https://zeugnis.webjects.de";
const APP_NAME = "Grundschul Zeugnis";
const VIEW_NAME = "";
const MAIL = "///";
const IGNORE_WARNINGS = false;

function debug($content){
    //mail(MAIL, "Debug", print_r($content,1));
}

function alert($content)
{
    //mail(MAIL, "Alert", print_r($content,1));
}

function myErrorHandler($errno, $errstr, $errfile, $errline) {

    switch($errno)
    {
        case E_NOTICE:
        case E_WARNING:
            if(!IGNORE_WARNINGS)
            {
                //mail(MAIL, "PHP WARNING/NOTICE", "<b></b> [$errno] $errstr<br> Find on line $errline in $errfile<br>");
            }
            break;

        case E_ERROR:
            //mail(MAIL, "PHP ERRORO", "<b></b> [$errno] $errstr<br> Error on line $errline in $errfile<br>");
            break;
    }

}

// Set user-defined error handler function
//set_error_handler("myErrorHandler");
?>
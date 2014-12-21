<?php

/*
 * Configuration for examples.
 */

// Credentials to connect to your Splunk instance.
$SplunkExamples_connectArguments = array(
    'host' => 'localhost',
    'port' => 8000,
    'username' => 'admin',
    'password' => '12qwaszx'
);

// Enable for better error reporting
if (FALSE)
{
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
}

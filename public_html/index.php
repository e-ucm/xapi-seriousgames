<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use es\eucm\xapi\Profile2Html;

define('MIME_TYPE_HTML', 'text/html');
define('MIME_TYPE_JSON_LD', 'application/ld+json');
define('PROFILE_FILE', 'seriousgames.jsonld');

function isCommandLine() {
    return (php_sapi_name() === 'cli');
}


$mimeType = MIME_TYPE_HTML;
if ( isCommandLine() ) {
    /*
     * -c <content-type> (e.g. application/ld+json, text/html)
     */
    $options = getopt("c:");
    $mimeType = isset($options['c']) ? $options['c'] : MIME_TYPE_HTML;
} else {
    $headers = getallheaders();
    $mimeType = isset($headers['Accept']) ? $headers['Accept'] : MIME_TYPE_HTML;
}

if (strcmp($mimeType, MIME_TYPE_JSON_LD) == 0) {
    if (! isCommandLine()) {
        header('Content-Type: '.MIME_TYPE_JSON_LD);
    }
    $fp = fopen(PROFILE_FILE, 'rb');
    fpassthru($fp);
    exit;
}

$generator = new Profile2Html();
echo $generator->generate(PROFILE_FILE);

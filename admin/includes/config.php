<?php
    define('DB_SERVER',          'localhost'); //hostname
    define('DB_SERVER_USERNAME', 'root'); //database username
    define('DB_SERVER_PASSWORD', ''); //database password
    define('DB_DATABASE',        'postascholarship_db'); //database name
    define('SITE_URL',           'http://localhost/PostAScholarship'); // site url
    define('SITE_URL_TITLE',     'My Website'); //sire URL title (used at few places, e.g in emails)

    $RES=@$_GET['res']; // to get various errors/success messages using query string


    $conn = new mysqli(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD,DB_DATABASE);
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $conn->connect_error);
        exit();
    }

?>
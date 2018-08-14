<?php
include "database/connection.php";
include "classes/User.php";
include "classes/Tweet.php";
include "classes/Follow.php";
include "classes/Message.php";


global $pdo;
session_start();

$getFromUsers =new User($pdo);

$getFromMsgs =new Message($pdo);
$getFromTweets =new Tweet($pdo,$getFromMsgs);
$getFromFollows =new Follow($pdo,$getFromMsgs);



define('BASE_URL','http://localhost:8080/twitter/');

<?php
include "database/connection.php";
include "classes/User.php";
include "classes/Tweet.php";
include "classes/Follow.php";
include "classes/Message.php";


global $pdo;
session_start();

$getFromUsers =new User($pdo);
$getFromTweets =new Tweet($pdo);
$getFromFollows =new Follow($pdo);
$getFromMsgs =new Message($pdo);


define('BASE_URL','http://localhost:8080/twitter/');

<?php


include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


if(isset($_POST['fetchPosts']) && !empty($_POST['fetchPosts'])) {

    $limit = (int) trim($_POST['fetchPosts']);
    $user_id = $_SESSION['user_id'];

    $getFromTweets->tweets($user_id,$limit);
}
?>
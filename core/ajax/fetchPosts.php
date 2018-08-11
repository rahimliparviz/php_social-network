<?php


include '../init.php';


if(isset($_POST['fetchPosts']) && !empty($_POST['fetchPosts'])) {

    $limit = (int) trim($_POST['fetchPosts']);
    $user_id = $_SESSION['user_id'];

    $getFromTweets->tweets($user_id,$limit);
}
?>
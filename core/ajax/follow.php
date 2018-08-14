<?php

include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


if(isset($_POST['unfollow']) && !empty($_POST['unfollow'])) {
    $user_id = $_SESSION['user_id'];
    $f_id = $_POST['unfollow'];
    $p_id = $_POST['profile'];

    $getFromFollows->unfollow($f_id,$user_id,$p_id);

}

if(isset($_POST['follow']) && !empty($_POST['follow'])) {
    $user_id = $_SESSION['user_id'];
    $f_id = $_POST['follow'];
    $p_id = $_POST['profile'];

    $getFromFollows->follow($f_id,$user_id,$p_id);

}

?>
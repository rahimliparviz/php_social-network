<?php


include '../init.php';

$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if(isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])) {

    $cm_id = $_POST['deleteComment'];
    $user_id = $_SESSION['user_id'];

$getFromUsers->delete('comments',array('comment_id'=>$cm_id,'commentBy'=>$user_id));
}
?>
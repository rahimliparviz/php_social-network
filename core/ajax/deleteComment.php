<?php


include '../init.php';


if(isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])) {

    $cm_id = $_POST['deleteComment'];
    $user_id = $_SESSION['user_id'];

$getFromUsers->delete('comments',array('comment_id'=>$cm_id,'commentBy'=>$user_id));
}
?>
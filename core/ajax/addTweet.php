<?php

include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if(isset($_POST) && !empty($_POST)) {
    $status = $getFromUsers->checkInput($_POST['status']);

    $user_id = $_SESSION['user_id'];
    $twImg="";

    if (!empty($status) or !empty($_FILES['file']['name'][0])) {
        if (!empty($_FILES['file']['name'][0])) {
            $twImg=$getFromUsers->uploadImage($_FILES['file']);
        } if (strlen($status) > 140) {
            $error = 'Text is too long';
        }
     $tw_id = $getFromUsers->create('tweets',array('status'=>$status,'tweetBy'=> $user_id,'tweetImage'=>$twImg,'postedOn'=>date('Y-m-d H:i:s')));

        preg_match_all("/#+([a-zA-Z0-9])+/i",$status,$hashtag);


       // unset($_POST['tweet']);

        if(!empty($hashtag)){
            $getFromTweets->addtrend($status);
        }

        $getFromTweets->addMention($status,$user_id,$tw_id);


        $result['success'] = "Your tweet has been posted";
        echo  json_encode($result);
    } else {
        $error['fields'] = 'Type or choose image to tweet';
    }


    if(isset($error)){
        $result['error'] = $error;
        echo  json_encode($result);
    }


}
?>
<?php



    include '../init.php';

$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


    if(isset($_GET['showNoti']) && !empty($_GET['showNoti'])) {

        $user_id = $_SESSION['user_id'];
        $data = $getFromMsgs->getNotiCount($user_id);



        echo json_encode(array('noti'=>$data->totalN,'msg'=>$data->totalM));
    }else{
        header('Location:'.BASE_URL.'index.php');
    }

?>
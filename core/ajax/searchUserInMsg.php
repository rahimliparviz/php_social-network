<?php



include '../init.php';



if(isset($_POST['search']) && !empty($_POST['search'])) {

    $search = $getFromUsers->checkInput($_POST['search']);
    $user_id = $_SESSION['user_id'];
    $result = $getFromUsers->search($search);

    echo '<h4>People</h4>
<div class="message-recent"> 
';

    foreach ($result as $u){
        if ($u->user_id != $user_id){
            echo '<div class="people-message" data-user="'.$u->user_id.'">
                    <div class="people-inner">
                        <div class="people-img">
                            <img src="'.BASE_URL.$u->profile_photo.'"/>
                        </div>
                        <div class="name-right">
                            <span><a>'.$u->nick_name.'</a></span><span>@'.$u->username.'</span>
                        </div>
                    </div>
                 </div>
 ';
        }
    }

    echo '</div>';
}


?>
<?php
include '../init.php';



if(isset($_POST['search']) && !empty($_POST['search'])){

    $search =$getFromUsers->checkInput($_POST['search']);
    $result= $getFromUsers->search($search);
    
   
if(!empty($result)){

    echo '<div class="nav-right-down-wrap"><ul>';
    
    
    foreach($result as $user){
    echo '<li>
    <div class="nav-right-down-inner">
      <div class="nav-right-down-left">
          <a href="'.BASE_URL.$user->username.'"><img src="'.BASE_URL.$user->profile_photo.'"></a>
      </div>
      <div class="nav-right-down-right">
          <div class="nav-right-down-right-headline">
              <a href="'.BASE_URL.$user->username.'">'.$user->nick_name.'</a><span>@'.$user->username.'</span>
          </div>
          <div class="nav-right-down-right-body">
           
          </div>
      </div>
    </div> 
    </li> ';
    }
    
    echo '</ul></div>';
}
}


?>
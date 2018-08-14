<?php
class Follow extends User
{
    function __construct($pdo,$msg)
    {
        $this->pdo =$pdo;
        $this->msg=$msg;
    }

public function checkFollow($follower_id,$user_id){
    $st=$this->pdo->prepare("select * from `follow` where `sender` =:u_id and `receiver`= :f_id ");
    $st->bindParam(":u_id",$user_id);
    $st->bindParam(":f_id",$follower_id);
    $st->execute();

    return $st->fetch(PDO::FETCH_ASSOC);

}

    public function followBtn($profile_id,$user_id,$f_id){

        $data =$this->checkFollow($profile_id,$user_id);
    
  
        if($this->loggedIn() === true){
            if($profile_id != $user_id){
                    if($data['receiver'] == $profile_id){
                        return " <button class='f-btn following-btn follow-btn' data-follow='".$profile_id."' data-profile='".$f_id."'>Following</button>";

                    }else{
                        return "<button class='f-btn  follow-btn'  data-follow='".$profile_id."' data-profile='".$f_id."'><i class='fa fa-user-plus'></i>Follow</button>";

                    }
            }else{
                return " <button class='f-btn' onclick=location.href='".BASE_URL."profileEdit.php' >Edit Profile</button>";

            }
        }else{
            return " <button class='f-btn' onclick=location.href='index.php' ><i class'fa fa-user-plus'></i>Follow</button>";
        }

    }

    public function follow($f_id,$u_d,$p_id){
      
        $this->create('follow',array('sender'=>$u_d,'receiver'=>$f_id,'followOn'=>date("Y-M-D H:i:s")));
        $this->addFollowCount($f_id,$u_d);
        $st=$this->pdo->prepare("select `user_id`,`following`,`followers` from `user` left join `follow` on `sender` = :u_id and case when `receiver` = :u_id then `sender`= `user_id` end where `user_id` = :p_id ");
        $st->execute(array("u_id"=>$u_d,"p_id"=>$p_id));
        $data=$st->fetch(PDO::FETCH_ASSOC);

        echo json_encode($data);


        $this->msg->sendNoti($f_id,$u_d,$f_id,'follow');


    }

    public function unfollow($f_id,$u_d,$p_id){

        $this->delete('follow',array('sender'=>$u_d,'receiver'=>$f_id));
        $this->removeFollowCount($f_id,$u_d);
        $st=$this->pdo->prepare("select `user_id`,`following`,`followers` from `user` left join `follow` on `sender` = :u_id and case when `receiver` = :u_id then `sender`= `user_id` end where `user_id` = :p_id ");
        $st->execute(array("u_id"=>$u_d,"p_id"=>$p_id));
        $data=$st->fetch(PDO::FETCH_ASSOC);

        echo json_encode($data);

    }



    public function addFollowCount($f_id,$u_d){
        $st=$this->pdo->prepare("update `user` set `following`=`following` + 1 where `user_id`= :u_id;update `user` set `followers`=`followers`+1 where `user_id` = :f_id");
        $st->execute(array(":u_id"=>$u_d,":f_id"=>$f_id));
    }

    public function removeFollowCount($f_id,$u_d){
        $st=$this->pdo->prepare("update `user` set `following`=`following` - 1 where `user_id`= :u_id;update `user` set `followers`=`followers` - 1 where `user_id` = :f_id");
        $st->execute(array("u_id"=>$u_d,"f_id"=>$f_id));
    }



    public function followingList($prof_id,$u_id,$f_id)
    {
        $stmt = $this->pdo->prepare("Select * from  `user` left join `follow` on `receiver` = `user_id` and case when `sender` =:u_id then `receiver`=`user_id` end where `sender` is not null ");

        $stmt->bindParam(":u_id", $prof_id, PDO::PARAM_INT);

        $stmt->execute();
        $followings=$stmt->fetchAll(PDO::FETCH_OBJ);


foreach($followings as $f){

echo '<div class="follow-unfollow-box">
<div class="follow-unfollow-inner">
    <div class="follow-background">
        <img src="'.BASE_URL.$f->profile_cover.'"/>
    </div>
    <div class="follow-person-button-img">
        <div class="follow-person-img"> 
             <img src="'.BASE_URL.$f->profile_photo.'"/>
        </div>
        <div class="follow-person-button">
             <!-- FOLLOW BUTTON -->
             '.$this->followBtn($f->user_id,$u_id,$f_id).'
        </div>
    </div>
    <div class="follow-person-bio">
        <div class="follow-person-name">
            <a href="'.BASE_URL.$f->username.'">'.$f->nick_name.'</a>
        </div>
        <div class="follow-person-tname">
            <a href="'.BASE_URL.$f->username.'">'.$f->username.'</a>
        </div>
        <div class="follow-person-dis">
        '.Tweet::getTweetLinks($f->bio).'
        </div>
    </div>
</div>
</div>';
}

    }



    public function followersList($prof_id,$u_id,$f_id)
    {
        $stmt = $this->pdo->prepare("Select * from  `user` left join `follow` on `sender` = `user_id` and case when `receiver` =:u_id then `sender`=`user_id` end where `receiver` is not null ");

        $stmt->bindParam(":u_id", $prof_id, PDO::PARAM_INT);

        $stmt->execute();
        $followings=$stmt->fetchAll(PDO::FETCH_OBJ);


foreach($followings as $f){

echo '<div class="follow-unfollow-box">
<div class="follow-unfollow-inner">
    <div class="follow-background">
        <img src="'.BASE_URL.$f->profile_cover.'"/>
    </div>
    <div class="follow-person-button-img">
        <div class="follow-person-img"> 
             <img src="'.BASE_URL.$f->profile_photo.'"/>
        </div>
        <div class="follow-person-button">
             <!-- FOLLOW BUTTON -->
             '.$this->followBtn($f->user_id,$u_id,$f_id).'
             
        </div>
    </div>
    <div class="follow-person-bio">
        <div class="follow-person-name">
            <a href="'.BASE_URL.$f->username.'">'.$f->nick_name.'</a>
        </div>
        <div class="follow-person-tname">
            <a href="'.BASE_URL.$f->username.'">'.$f->username.'</a>
        </div>
        <div class="follow-person-dis">
        '.Tweet::getTweetLinks($f->bio).'
        </div>
    </div>
</div>
</div>';
}

    }


    public function whoToFollow($u_id,$p_id){
        $stmt = $this->pdo->prepare("Select * from  `user` where `user_id` !=:u_id and `user_id` not in (select `receiver` from `follow` where `sender` = :u_id)  order by rand() limit 3");
        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);


        echo  '  <div class="follow-wrap"><div class="follow-inner"><div class="follow-title"><h3>Who to follow</h3></div>';


        foreach ($data as $user){

            echo '
            
            <div class="follow-body">
	            <div class="follow-img">

                <img src="'.BASE_URL.$user->profile_photo.'" alt="">
                    </div>
                    <div class="follow-content">
                        <div class="fo-co-head">
                            <a href="'.$user->username.'">'.$user->nick_name.'</a> <span>@'.$user->username.'</span>
                        </div>
                        <!-- FOLLOW BUTTON -->
                        '.$this->followBtn($user->user_id,$u_id,$p_id).'
                    </div>
                </div>   
            ';
        }
        echo '</div></div>';
                        































    }


}
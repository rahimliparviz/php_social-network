<?php
/**
 * Created by PhpStorm.
 * User: Parviz
 * Date: 08.08.2018
 * Time: 21:30
 */

class Message extends User
{
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function getNotiCount($user_id){
        $st= $this->pdo->prepare("Select Count(`msg_id`) as `totalM`,(Select Count(`id`) from `notification` where `noti_for` = :u_id and `status`='0') as `totalN` from `message` where `msg_to`=:u_id and `status` = '0'");
        $st->bindParam(':u_id',$user_id,PDO::PARAM_INT);
        $st->execute();

        return $st->fetch(PDO::FETCH_OBJ);

    }




    public function deleteMsg($msg,$user){
        $st= $this->pdo->prepare("delete from `messages`  where `msg_id` = :msg_id and `msg_from` =:u_id  or `msg_id` = :msg_id and `msg_to` =:u_id");
        $st->bindParam(':u_id',$user,PDO::PARAM_INT);
        $st->bindParam(':msg_id',$msg,PDO::PARAM_INT);
        $st->execute();

    }


    public function recentMsgs($u_id){
        $st= $this->pdo->prepare('select * from `messages` left join `user` on `msg_from`=`user_id` where `msg_to` =:u_id');
        $st->bindParam(':u_id',$u_id,PDO::PARAM_INT);
        $st->execute();


        return $st->fetchAll(PDO::FETCH_OBJ);
    }


    public function getMsgs($msgFrom,$u_id){
        $st= $this->pdo->prepare('select * from `messages` left join `user` on `msg_from`=`user_id` where `msg_from`=:msg_from and `msg_to` =:u_id or `msg_from`=:u_id and `msg_to` =:msg_from');
        $st->bindParam(':u_id',$u_id,PDO::PARAM_INT);
        $st->bindParam(':msg_from',$msgFrom,PDO::PARAM_INT);
        $st->execute();



        $msgs = $st->fetchAll(PDO::FETCH_OBJ);

        foreach ($msgs as $m){

            if ($m->msg_from === $u_id){
                 echo '
                    <!-- Main message BODY RIGHT START -->
                    <div class="main-msg-body-right">
                            <div class="main-msg">
                                <div class="msg-img">
                                    <a href="#"><img src="'.BASE_URL.$m->profile_photo.'"/></a>
                                </div>
                                <div class="msg">'.$m->msg.'
                                    <div class="msg-time">
                                     '.$this->timeAgo($m->msg_on).'
                                    </div>
                                </div>
                                <div class="msg-btn">
                                    <a><i class="fa fa-ban" aria-hidden="true"></i></a>
                                    <a class="deleteMsg" data-msg="'.$m->msg_id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    <!--Main message BODY RIGHT END-->  ';
            }
            else{
                        echo '
                        <!--Main message BODY LEFT START-->
		<div class="main-msg-body-left">
			<div class="main-msg-l">
				<div class="msg-img-l">
           <a href="#"><img src="'.BASE_URL.$m->profile_photo.'"/></a>
				</div>
				<div class="msg-l">
				'.$m->msg.'
					<div class="msg-time-l">
					   '.$this->timeAgo($m->msg_on).'
					</div>	
				</div>
				<div class="msg-btn-l">	
					<a><i class="fa fa-ban" aria-hidden="true"></i></a>
					<a class="deleteMsg" data-msg="'.$m->msg_id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</div>
			</div>
		</div> 
	<!--Main message BODY LEFT END-->';
            }
        }
    }



}
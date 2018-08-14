<?php


class Tweet extends User
{


    function __construct($pdo,$msg)
    {
        $this->pdo = $pdo;
        $this->msg =$msg;
    }





    public function tweets($user_id,$limit)
    {//Do not show retweets
        $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `user` ON `tweetBy` = `user_id` WHERE `tweetBy` = :u_id  and `retweetId` = '0' or `tweetBy` =`user_id` and `retweetBy` != :u_id  and `tweetBy` IN (select `receiver` from `follow` where `sender` = :u_id) order by `tweet_id` desc LIMIT :limit");

        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);

        $stmt->bindParam(':u_id',$user_id,PDO::PARAM_INT);

        $stmt->execute();
        $tweets = $stmt->fetchAll(PDO::FETCH_OBJ);


        foreach ($tweets as $t) {


            $likes = $this->likes($user_id, $t->tweet_id);
            $retweet = $this->checkRetweet($t->tweet_id, $user_id);
            $user = $this->userData($t->retweetBy);

            echo '
<div class="all-tweet">
<div class="t-show-wrap">	
 <div class="t-show-inner">
 
 
' . (($retweet['retweetId'] === $t->retweetId or $t->retweetId > 0) ? '
	<div class="t-show-banner">
		<div class="t-show-banner-inner">
			<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>' . $user->nick_name . ' Retweeted</span>
		</div>
	</div>
	' : '') . '


' . ((!empty($t->retweetMsg) and $t->tweet_id === $retweet['tweet_id'] or $t->retweetId > 0) ? ' 
     <div class="t-show-popup" data-tweet = "'. $t->tweet_id .'" data-user="' . $t->tweetBy . '"">
     <div class="t-show-head">
	<div class="t-show-img">
	<img src="' . BASE_URL . $user->profile_photo . '"/></div>
	<div class="t-s-head-content">
		<div class="t-h-c-name">
			 <span><a href="' . BASE_URL . $user->username . '">' . $user->nick_name . '</a></span>
					<span>@' . $user->username . '</span>
					<span>' . $this->timeAgo($retweet['postedOn']) . '</span>
		</div>
		<div class="t-h-c-dis">
			' . $this->getTweetLinks($t->retweetMsg) . '
		</div>
	</div>
</div>

		
		' . ((!empty($t->tweetImage)) ? '
			<div class="retweet-t-s-b-inner-left">
				<img src="' . BASE_URL . $t->tweetImage . '" class="imagePopup" data-tweet ="'.$t->tweet_id.'"/>
			</div>
			
		' : '') . '
			<div >
				<div class="t-h-c-name">
				    <span><a href="' . $t->username . '">' . $t->nick_name . '</a></span>
					<span>@' . $t->username . '</span>
					<span>' . $this->timeAgo($t->postedOn) . '</span>
				</div>
				<div class="retweet-t-s-b-inner-right-text">		
					' . $this->getTweetLinks($t->status) . '
				</div>
			</div>
			</div>
	

' : '
	
	<div class="t-show-popup" data-tweet = "'. $t->tweet_id .'" data-user="' . $t->tweetBy . '"">
		<div class="t-show-head">
			<div class="t-show-img">
				<img src="' . $t->profile_photo . '"/>
			</div>
			<div class="t-s-head-content">
				<div class="t-h-c-name">
					<span><a href="' . $t->username . '">' . $t->nick_name . '</a></span>
					<span>@' . $t->username . '</span>
					<span>' . $this->timeAgo($t->postedOn) . '</span>
				</div>
				<div class="t-h-c-dis">
					' . $this->getTweetLinks($t->status) . '
				</div>
			</div>
		</div>' .
                    ((!empty($t->tweetImage)) ?
                        ' <div class="t-show-body">
                  <div class="t-s-b-inner">
                   <div class="t-s-b-inner-in">
                     <img src="' . $t->tweetImage . '"  class="imagePopup" data-tweet ="'.$t->tweet_id.'"/>
                   </div>
                  </div>
                </div>
            ' : '')

                    . '
		') . '

             </div>
	<div class="t-show-footer">
		<div class="t-s-f-right">
			<ul> 
				<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
				<li>' . (($t->tweet_id === $retweet['retweetId']) ? '<button class="retweeted" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . $t->retweetCount . '</span> </a></button></li>' : '<button class="retweet" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . (($t->retweetCount > 0) ? $t->retweetCount : "") . '</span> </a></button></li>') . '
				<li>' . (($likes['likeOn'] === $t->tweet_id) ? '<button class="unlike-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a> <span class="likesCount" >' . $t->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a> <span class="likesCount" >' . (($t->likesCount > 0) ? $t->likesCount : '') . '</span></button>') . '
					
					'.(($t->tweetBy === $user_id ) ? '
					<li>
					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
					<ul> 
					  <li><label class="deleteTweet" data-tweet="' . $t->tweet_id . '"  >Delete Tweet</label></li>
					</ul>
				</li>' : '').'
			</ul>
		</div>
	</div>
</div>
</div>
</div>';
        }


    }


    public function trendsByHash($hash)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
        $stmt->bindValue(":hashtag", $hash . '%');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMention($mention)
    {
        $stmt = $this->pdo->prepare("SELECT `user_id`,`username`,`nick_name`,`profile_photo` FROM `user` WHERE `username` LIKE :mention or `nick_name` LIKE :mention LIMIT 5");
        $stmt->bindValue(":mention", $mention . '%');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function addtrend($hash)
    {

        preg_match_all("/#+([a-zA-Z0-9]+)/i", $hash, $matches);


        if ($matches) {
            $result = array_values($matches[1]);
        }

        $sql = "insert into `trends` (`hashtag`,`createdOn`) values (:hash,CURRENT_TIMESTAMP )";


        foreach ($result as $h) {
            if ($smtm = $this->pdo->prepare($sql)) {
                $smtm->execute(array(':hash' => $h));
            }
        }

    }





    public function addMention($status,$user_id,$tw_id)
    {

        preg_match_all("/@+([a-zA-Z0-9]+)/i", $status, $matches);


        if ($matches) {
            $result = array_values($matches[1]);
        }

        $sql = "select * from `user` where `username`= :mention";


        foreach ($result as $t) {
            if ($smtm = $this->pdo->prepare($sql)) {
                $smtm->execute(array(':mention' => $t));
                $data= $smtm->fetch(PDO::FETCH_OBJ);

            }
        }
        if($data->user_id != $user_id){



            $this->msg->sendNoti($data->user_id,$user_id,$tw_id,'mention');

        }

    }


    public function getTweetLinks($tw)
    {

        $tw = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $tw);
        $tw = preg_replace("/#([\w]+)/", "<a href='" . BASE_URL . "hashtag/$1'>$0</a>", $tw);
        $tw = preg_replace("/@([\w]+)/", "<a href='" . BASE_URL . "$1'>$0</a>", $tw);

        return $tw;
    }


    public function getPopupTw($t_id)
    {


        $stmt = $this->pdo->prepare("Select * FROM `tweets`,`user` where `tweet_id`= :t_id and `tweetBy`= `user_id`");
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->execute();


        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    public function checkRetweet($t_id, $u_id)
    {


        $stmt = $this->pdo->prepare("Select * FROM `tweets` where `retweetId`= :t_id and `retweetBy`= :u_id or `tweet_Id`= :t_id and `retweetBy`= :u_id");
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);
        $stmt->execute();

        //echo print_r($stmt->fetch(PDO::FETCH_ASSOC));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function retweet($t_id, $u_id, $get_id, $comment)
    {


        $stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount` + 1 where `tweet_id`= :t_id");
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->execute();


        $stmt = $this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetBy`,`tweetImage`,`retweetId`,`retweetBy`,`postedOn`,`likesCount`,`retweetCount`,`retweetMsg`) SELECT  `status`,`tweetBy`,`tweetImage`,`tweet_id`,:u_id, CURRENT_TIMESTAMP ,`likesCount`,`retweetCount`,:retweetMsg FROM `tweets` WHERE `tweet_id`=:t_id");


        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);
        $stmt->bindParam(":retweetMsg", $comment, PDO::PARAM_STR);
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->execute();


        $this->msg->sendNoti($get_id,$u_id,$t_id,'retweet');




    }

    public function addLike($u_id, $t_id, $get_id)
    {

        $stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount` + 1 where `tweet_id`= :t_id");
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->create('likes', array('likeBy' => $u_id, 'likeOn' => $t_id,));

       //oz likelari ucun notification gelmemesi ucun
        if ($get_id != $u_id){
            $this->msg->sendNoti($get_id,$u_id,$t_id,'like');
        }






    }
    public function getUserTweets($u_id)
    {

        $stmt = $this->pdo->prepare("select * from `tweets` LEFT JOIN `user` on `tweetBy` = `user_id` where `tweetBy`= :u_id and `retweetId` = '0' or `retweetBy`=:u_id");


        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function unlike($u_id, $t_id, $get_id)
    {
        $stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount` - 1 where `tweet_id`= :t_id");
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);

        $stmt->execute();

        $stmt = $this->pdo->prepare("Delete from `likes` where `likeBy`=:u_id  and `likeOn` = :t_id");
        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function likes($u_id, $t_id)
    {
        $stmt = $this->pdo->prepare("Select * FROM `likes`  where `likeBy`= :u_id and `likeOn`= :t_id");
        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function comments($t_id)
    {
        $stmt = $this->pdo->prepare("Select * FROM `comments` Left join `user` on `commentBy`= `user_id`   where `commentOn`= :t_id ");
        $stmt->bindParam(":t_id", $t_id, PDO::PARAM_INT);

        $stmt->execute();
       //var_dump($stmt->fetchAll(PDO::FETCH_OBJ));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function countTweets($u_id)
    {
        $stmt = $this->pdo->prepare("Select COUNT('tweet_id') AS 'totalTweets' FROM `tweets`  where `tweetBy`= :u_id  and `retweetId`= '0' or `retweetBy`=:u_id");
        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);

        $stmt->execute();
        $count=$stmt->fetch(PDO::FETCH_OBJ);
        echo $count->totalTweets;
    }







    public function countLikes($u_id)
    {
        $stmt = $this->pdo->prepare("Select COUNT('like_id') AS 'totalLikes' FROM `likes`  where `likeBy`= :u_id  ");

        $stmt->bindParam(":u_id", $u_id, PDO::PARAM_INT);

        $stmt->execute();
        $count=$stmt->fetch(PDO::FETCH_OBJ);
        echo $count->totalLikes;
    }




    public function trends()
    {
        $stmt = $this->pdo->prepare("Select *,COUNT('tweet_id') AS 'tweetsCount' FROM `trends` INNER JOIN `tweets` ON `status` LIKE CONCAT('%#',`hashtag`,'%') or `retweetMsg` LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` order by `tweet_id`");
        $stmt->execute();
        $trends=$stmt->fetchAll(PDO::FETCH_OBJ);

echo '<div class="trend-wrapper"><div class="trend-inner"><div class="trend-title"><h3>Trends</h3></div><!-- trend title end-->
';
        foreach ($trends as $t) {

            echo '
            
            <div class="trend-body">
                <div class="trend-body-content">
                    <div class="trend-link">
                        <a href="'.BASE_URL.'hashtag/'.$t->hashtag.'">#'.$t->hashtag.'</a>
                    </div>
                    <div class="trend-tweets">
                        '.$t->tweetsCount.' <span>tweets</span>
                    </div>
                </div>
            </div>
            
            
            
            
            
            ';
        }
echo '</div></div>';
    }


    public function getTweetsByHash($hashtag){
        $stmt = $this->pdo->prepare("Select * from `tweets` left join`user` on `tweetBy`=`user_id` where `status` like :hashtag or `retweetMsg` like :hashtag ");
        $stmt->bindValue(":hashtag",'%#'.$hashtag.'%',PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    public function getUsersByHash($hashtag){
        $stmt = $this->pdo->prepare("Select DISTINCT * from `tweets` inner join`user` on `tweetBy`=`user_id` where `status` like :hashtag or `retweetMsg` like :hashtag group by  `user_id` ");
        $stmt->bindValue(":hashtag",'%#'.$hashtag.'%',PDO::PARAM_STR);
        $stmt->execute();

       // print_r($stmt->fetchAll(PDO::FETCH_OBJ));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }




}

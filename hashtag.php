<?php

include 'core/init.php';



if (isset($_GET['hashtag']) && !empty($_GET['hashtag'])) {

    $hastag =$getFromUsers->checkInput($_GET['hashtag']);
    $user_id =@$_SESSION['user_id'];
    $user = $getFromUsers->userData($user_id);
    $tweets =$getFromTweets->getTweetsByHash($hastag);
    $accaunts =$getFromTweets->getUsersByHash($hastag);
    $notify = $getFromMsgs->getNotiCount($user_id);





}else{

    header('Location:index.php');
}
?>

<?php include 'includes/header.inc.php'?>



    <!--#hash-header-->
    <div class="hash-header">
        <div class="hash-inner">
            <h1>#<?php echo $hastag?></h1>
        </div>
    </div>
    <!--#hash-header end-->

    <!--hash-menu-->
    <div class="hash-menu">
        <div class="hash-menu-inner">
            <ul>
                <li><a href="<?php echo  BASE_URL.'hashtag/'.$hastag;?>">Latest</a></li>
                <li><a href="<?php echo  BASE_URL.'hashtag/'.$hastag.'?f=users';?>">Accounts</a></li>
                <li><a href="<?php echo  BASE_URL.'hashtag/'.$hastag.'?f=photos';?>">Photos</a></li>
            </ul>
        </div>
    </div>
    <!--hash-menu-->
    <!---Inner wrapper-->

    <div class="in-wrapper">
        <div class="in-full-wrap">

            <div class="in-left">
                <div class="in-left-wrap">

                    <?php $getFromFollows->whoToFollow($user_id,$user_id) ?>

                   <?php $getFromTweets->trends() ?>


                </div>
                <!-- in left wrap-->
            </div>
            <!-- in left end-->
<?php if(strpos($_SERVER['REQUEST_URI'],'?f=photos')) :?>
            <!-- TWEETS IMAGES  -->
             <div class="hash-img-wrapper">
                 <div class="hash-img-inner">




                     <?php foreach ($tweets as $t){




                         $likes = $getFromTweets->likes($user_id, $t->tweet_id);
                         $retweet = $getFromTweets->checkRetweet($t->tweet_id, $user_id);
                         $user = $getFromTweets->userData($t->retweetBy);

                         if (!empty($t->tweetImage)){
                                echo '
                                
                     <div class="hash-img-flex">
                         <img src="'.BASE_URL.$t->tweetImage.'" class="imagePopup" data-tweet="'.$t->tweet_id.'/>
                         <div class="hash-img-flex-footer">
                             <ul>
                                '.(($getFromUsers->loggedIn() === true) ? '
                                    <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                                    <li>' . (($t->tweet_id === $retweet['retweetId'] or $user_id ==$retweet['retweetBy']) ? '<button class="retweeted" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . $t->retweetCount . '</span> </a></button></li>' : '<button class="retweet" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . (($t->retweetCount > 0) ? $t->retweetCount : "") . '</span> </a></button></li>') . '
                                    <li>' . (($likes['likeOn'] === $t->tweet_id) ? '<button class="unlike-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a> <span class="likesCount" >' . $t->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a> <span class="likesCount" >' . (($t->likesCount > 0) ? $t->likesCount : '') . '</span></button>') . '
                                        
                                        '.(($t->tweetBy === $user_id ) ? '
                                        <li>
                                        <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                        <ul> 
                                          <li><label class="deleteTweet" data-tweet="' . $t->tweet_id . '"  >Delete Tweet</label></li>
                                        </ul>
                                    </li>' : '').'
                                        ' : '
                                    <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
                                    <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>	
                                    <li><button><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a></button></li>	
                                 ').'
                             </ul>
                       </div>
                           </div>;
                                
                                
                                
                                
                                ';
                         }
                     }?>


                </div>
            </div>
            <!-- TWEETS IMAGES -->
<?php elseif (strpos($_SERVER['REQUEST_URI'],'?f=users')) :?>
            <!--TWEETS ACCOUTS-->
            <div class="wrapper-following">
            <div class="wrap-follow-inner">

                <?php foreach ($accaunts as $u) :?>

             <div class="follow-unfollow-box">
                <div class="follow-unfollow-inner">
                    <div class="follow-background">
                        <img src="<?php echo BASE_URL.$u->profile_cover ?>"/>
                    </div>
                    <div class="follow-person-button-img">
                        <div class="follow-person-img">
                             <img src="<?php echo BASE_URL.$u->profile_photo ?>"/>
                        </div>
                        <div class="follow-person-button">
                            <?php echo $getFromFollows->followBtn($u->user_id,$user_id,$user_id) ?>
                        </div>
                    </div>
                    <div class="follow-person-bio">
                        <div class="follow-person-name">
                            <a href="<?php echo BASE_URL.$u->username ?>"><?php echo $u->nick_name ?></a>
                        </div>
                        <div class="follow-person-tname">
                            <a href="<?php echo BASE_URL.$u->username ?>">@<?php echo $u->username ?></a>
                        </div>
                        <div class="follow-person-dis">
                            <?php echo $getFromTweets->getTweetLinks($u->bio)?>
                        </div>
                    </div>
                </div>
            </div>

                <?php endforeach;?>
            </div>
            </div>
            <!-- TWEETS ACCOUNTS

            <?php else :?>

            <div class="in-center">
                <div class="in-center-wrap">
                    <?php


                    foreach ($tweets as $t) {


                        $likes = $getFromTweets->likes($user_id, $t->tweet_id);
                        $retweet = $getFromTweets->checkRetweet($t->tweet_id, $user_id);
                        $user = $getFromTweets->userData($t->retweetBy);

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
	<img src="' . BASE_URL . $profData->profile_photo . '"/></div>
	<div class="t-s-head-content">
		<div class="t-h-c-name">
			 <span><a href="' . BASE_URL . $profData->username . '">' . $profData->nick_name . '</a></span>
					<span>@' . $user->username . '</span>
					<span>' . $getFromTweets->timeAgo($retweet['postedOn']) . '</span>
		</div>
		<div class="t-h-c-dis">
			' . $getFromTweets->getTweetLinks($t->retweetMsg) . '
		</div>
	</div>
</div>

		
		' . ((!empty($t->tweetImage)) ? '
			<div class="retweet-t-s-b-inner-left">
				<img src="' . BASE_URL . $t->tweetImage . '" class="imagePopup" data-tweet ="'.$t->tweet_id.'"/>
			</div>
			
		' : '') . '
			<div class="retweet-t-s-b-inner-right">
				<div class="t-h-c-name">
				    <span><a href="' . $t->username . '">' . $t->nick_name . '</a></span>
					<span>@' . $t->username . '</span>
					<span>' . $getFromTweets->timeAgo($t->postedOn) . '</span>
				</div>
				<div class="retweet-t-s-b-inner-right-text">		
					' . $getFromTweets->getTweetLinks($t->status) . '
				</div>
			</div>
			</div>
	

' : '
	
	<div class="t-show-popup" data-tweet = "'. $t->tweet_id .'" data-user="' . $t->tweetBy . '"">
		<div class="t-show-head">
			<div class="t-show-img">
				<img src="' . BASE_URL.$t->profile_photo . '"/>
			</div>
			<div class="t-s-head-content">
				<div class="t-h-c-name">
					<span><a href="' . $t->username . '">' . $t->nick_name . '</a></span>
					<span>@' . $t->username . '</span>
					<span>' . $getFromTweets->timeAgo($t->postedOn) . '</span>
				</div>
				<div class="t-h-c-dis">
					' . $getFromTweets->getTweetLinks($t->status) . '
				</div>
			</div>
		</div>' .
                                ((!empty($t->tweetImage)) ?
                                    ' <div class="t-show-body">
                  <div class="t-s-b-inner">
                   <div class="t-s-b-inner-in">
                     <img src="' .BASE_URL.$t->tweetImage . '"  class="imagePopup" data-tweet ="'.$t->tweet_id.'"/>
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
			'.(($getFromUsers->loggedIn() === true) ? '
				<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
				<li>' . (($t->tweet_id === $retweet['retweetId'] or $user_id ==$retweet['retweetBy']) ? '<button class="retweeted" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . $t->retweetCount . '</span> </a></button></li>' : '<button class="retweet" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . (($t->retweetCount > 0) ? $t->retweetCount : "") . '</span> </a></button></li>') . '
				<li>' . (($likes['likeOn'] === $t->tweet_id) ? '<button class="unlike-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a> <span class="likesCount" >' . $t->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a> <span class="likesCount" >' . (($t->likesCount > 0) ? $t->likesCount : '') . '</span></button>') . '
					
					'.(($t->tweetBy === $user_id ) ? '
					<li>
					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
					<ul> 
					  <li><label class="deleteTweet" data-tweet="' . $t->tweet_id . '"  >Delete Tweet</label></li>
					</ul>
				</li>' : '').'
					' : '
				<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
				<li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>	
				<li><button><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a></button></li>	
                 ').'
			</ul>
		</div>
	</div>
</div>
</div>
</div>';}?>
                </div>
            </div>
<?php endif; ?>

        </div><!--in full wrap end-->
    </div><!-- in wrappper ends-->
<div class="popupTweet"></div>
        <script src="<?php echo BASE_URL?>assets/js/follow.js"></script>
        <script type="text/javascript" src='<?php echo BASE_URL?>assets/js/search.js'></script>
        <script type="text/javascript" src='<?php echo BASE_URL?>assets/js/hashtag.js'></script>
        <script type="text/javascript" src='<?php echo BASE_URL?>assets/js/delete.js'></script>

        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/retweet.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/like.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/popup.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/comment.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/popupForm.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/messages.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/postMsg.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/noti.js"></script>





    </div><!-- ends wrapper -->

</body>
</html>

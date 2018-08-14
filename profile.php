<?php

include 'core/init.php';


if(isset($_GET['username'])== true && empty($_GET['username'])==false)
{



    $uName=$getFromUsers->checkInput($_GET['username']);
    $profId=$getFromUsers->IdByUsername($uName);
    $profData=$getFromUsers->userData($profId);
    $user_id=@$_SESSION['user_id'];
    $user= $getFromUsers->userData($user_id);
    $notify =$getFromMsgs->getNotiCount($user_id);


    if (!$profData){
        header('Location:'.BASE_URL.'index.php');
    }


}
?>


<?php include 'includes/header.inc.php'?>

    <!--Profile cover-->
    <div class="profile-cover-wrap">
        <div class="profile-cover-inner">
            <div class="profile-cover-img">
                <!-- PROFILE-COVER -->
                <img src="<?php echo BASE_URL.$profData->profile_cover?>"/>
            </div>
        </div>
        <div class="profile-nav">
            <div class="profile-navigation">
                <ul>
                    <li>
                        <div class="n-head">
                            TWEETS
                        </div>
                        <div class="n-bottom">
                            <?php $getFromTweets->countTweets($profId)?>
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL.$profData->username?>/following">
                            <div class="n-head"> 
                                <a href="<?php echo BASE_URL.$profData->username?>/following">FOLLOWING</a>
                            </div>
                            <div class="n-bottom">
                                <span class="count-following"><?php echo $profData->following?></span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL.$profData->username?>/followers">
                            <div class="n-head">
                                FOLLOWERS
                            </div>
                            <div class="n-bottom">
                                <span class="count-followers"><?php echo $profData->followers?></span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="n-head">
                                LIKES
                            </div>
                            <div class="n-bottom">
                                <?php $getFromTweets->countLikes($profId)?>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="edit-button">
		<span>
<?php echo $getFromFollows->followBtn($profId,$user_id,$profData->user_id);?></span>
                </div>
            </div>
        </div>
    </div><!--Profile Cover End-->

    <!---Inner wrapper-->
    <div class="in-wrapper">
        <div class="in-full-wrap">
            <div class="in-left">
                <div class="in-left-wrap">
                    <!--PROFILE INFO WRAPPER END-->
                    <div class="profile-info-wrap">
                        <div class="profile-info-inner">
                            <!-- PROFILE-IMAGE -->
                            <div class="profile-img">
                                <img src="<?php echo BASE_URL.$profData->profile_photo ?>"/>
                            </div>

                            <div class="profile-name-wrap">
                                <div class="profile-name">
                                    <a href="<?php echo BASE_URL.$profData->profile_photo?>"><?php echo $profData->nick_name?></a>
                                </div>
                                <div class="profile-tname">
                                    <?php echo $profData->username?>                                   @<span class="username">                                    <a href="<?php echo $profData->nick_name?>"><?php echo $profData->nick_name?></a>
</span>
                                </div>
                            </div>

                            <div class="profile-bio-wrap">
                                <div class="profile-bio-inner">
                                    <?php echo $profData->bio?>
                                </div>
                            </div>

                            <div class="profile-extra-info">
                                <div class="profile-extra-inner">
                                    <ul>
                                        <li>
                                            <div class="profile-ex-location-i">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            </div>
                                            <div class="profile-ex-location">
                                                <?php echo $profData->country?>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="profile-ex-location-i">
                                                <i class="fa fa-link" aria-hidden="true"></i>
                                            </div>
                                            <div class="profile-ex-location">
                                                <a href="<?php echo $profData->website?>">PROFILE-WEBSITE;</a>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="profile-ex-location-i">
                                                <!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
                                            </div>
                                            <div class="profile-ex-location">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="profile-ex-location-i">
                                                <!-- <i class="fa fa-tint" aria-hidden="true"></i> -->
                                            </div>
                                            <div class="profile-ex-location">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="profile-extra-footer">
                                <div class="profile-extra-footer-head">
                                    <div class="profile-extra-info">
                                        <ul>
                                            <li>
                                                <div class="profile-ex-location-i">
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                </div>
                                                <div class="profile-ex-location">
                                                    <a href="#">0 Photos and videos </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="profile-extra-footer-body">
                                    <ul>
                                        <!-- <li><img src="#"/></li> -->
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!--PROFILE INFO INNER END-->

                    </div>
                    <!--PROFILE INFO WRAPPER END-->

                </div>
                <!-- in left wrap-->

            </div>
            <!-- in left end-->

            <div class="in-center">
                <div class="in-center-wrap">
                    <!--Tweet SHOW WRAPER-->


<?php


$tweets =$getFromTweets->getUserTweets($profId);

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
</div>';
}

?>

                    <!--Tweet SHOW WRAPER END-->
                </div><!-- in left wrap-->
                <div class="popupTweet"></div>
            </div>
            <!-- in center end -->

            <div class="in-right">
                <div class="in-right-wrap">

                    <!--==WHO TO FOLLOW==-->
                    <?php $getFromFollows->whoToFollow($user_id,$profId) ?>
                    <!--==WHO TO FOLLOW==-->

                    <!--==TRENDS==-->
                    <?php $getFromTweets->trends()?>

                    <!--==TRENDS==-->

                </div><!-- in right wrap-->
            </div>
            <!-- in right end -->

        </div>
        <!--in full wrap end-->
    </div>
    <!-- in wrappper ends-->
</div>
<!-- ends wrapper -->
<script type="text/javascript" src='assets/js/search.js'></script>
<script type="text/javascript" src='assets/js/hashtag.js'></script>
<script type="text/javascript" src="assets/js/retweet.js"></script>
<script type="text/javascript" src="assets/js/like.js"></script>
<script type="text/javascript" src="assets/js/popup.js"></script>
<script type="text/javascript" src="assets/js/comment.js"></script>
<script type="text/javascript" src="assets/js/delete.js"></script>
<script type="text/javascript" src="assets/js/popupForm.js"></script>
<script type="text/javascript" src="assets/js/follow.js"></script>
<script type="text/javascript" src="assets/js/messages.js"></script>
<script type="text/javascript" src="assets/js/postMsg.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/noti.js"></script>



</body>
</html>


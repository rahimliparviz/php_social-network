<?php

include 'core/init.php';


if(isset($_GET['username'])== true && empty($_GET['username'])==false)
{



    $uName=$getFromUsers->checkInput($_GET['username']);
    $profId=$getFromUsers->IdByUsername($uName);
    $profData=$getFromUsers->userData($profId);
    $user_id=$_SESSION['user_id'];
    $user= $getFromUsers->userData($user_id);
    $notify =$getFromMsgs->getNotiCount($user_id);


    if ($getFromUsers->loggedIn() === false){
        header('Location:'.BASE_URL.'index.php');
    }

    if (!$profData){
        header('Location:'.BASE_URL.'index.php');
    }


}else{
    header('Location:'.BASE_URL.'index.php');

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
                            <?php $getFromTweets->countTweets($user_id)?>
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
<?php echo $getFromFollows->followBtn($profId,$user_id,$profData->user_id);?>		</span>
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
                                <img src="<?php echo BASE_URL.$profData->profile_photo?>"/>
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

                                <?php $getFromFollows->whoToFollow($user_id,$user_id) ?>

                            </div>

                        </div>
                        <!--PROFILE INFO INNER END-->

	</div>
	<!--PROFILE INFO WRAPPER END-->

	<div class="popupTweet"></div>
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->
		<!--FOLLOWING OR FOLLOWER FULL WRAPPER-->
		<div class="wrapper-following">
			<div class="wrap-follow-inner">
            <?php $getFromFollows->followersList($profId,$user_id,$profData->user_id)?>

			</div>
		<!-- wrap follo inner end-->
            <script src="<?php echo BASE_URL?>assets/js/follow.js"></script>
            <script type="text/javascript" src='<?php echo BASE_URL?>assets/js/search.js'></script>
            <script type="text/javascript" src='<?php echo BASE_URL?>assets/js/hashtag.js'></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/retweet.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/like.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/popup.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/comment.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/popupForm.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/messages.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/postMsg.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/noti.js"></script>




        </div>
		<!--FOLLOWING OR FOLLOWER FULL WRAPPER END-->	
	</div><!--in full wrap end-->
</div>
<!-- in wrappper ends-->
</div><!-- ends wrapper -->
</body>

</html>

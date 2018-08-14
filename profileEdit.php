<?php

include 'core/init.php';

if ($getFromUsers->loggedIn() === false) {

    header('Location:index.php');
}

$user_id = $_SESSION['user_id'];
$user = $getFromUsers->userData($user_id);
$notify =$getFromMsgs->getNotiCount($user_id);


if (isset($_POST['screenName'])) {
    if (!empty($_POST['screenName'])) {
        $nickName = $getFromUsers->checkInput($_POST['screenName']);
        $bio = $getFromUsers->checkInput($_POST['bio']);
        $country = $getFromUsers->checkInput($_POST['country']);
        $website = $getFromUsers->checkInput($_POST['website']);

        if (strlen($screenName) > 20) {
            $error = "Name must be between in 6-20 characters";

        } else if (strlen($bio) > 120) {
            $error = "Description is too long";
        } else if (strlen($country) > 80) {
            $error = "Country name is too long";
        } else {
            $getFromUsers->update('user',$user_id,array('nick_name'=>$nickName,'bio'=>$bio,'country'=>$country,'website'=>$website));
            header('Location:'.$user->username);
        }

    }
    else {
        $error = 'Name field can not be empty';
    }

}
if (isset($_FILES['profileImage'])){
    if (!empty($_FILES['profileImage']['name'][0])){
        $fileRoot=$getFromUsers->uploadImage($_FILES['profileImage']);

        $getFromUsers->update('user',$user_id,array('profile_photo'=>$fileRoot));

        header('Location:'.$user->username);
    }

}


if (isset($_FILES['profileCover'])){
    if (!empty($_FILES['profileCover']['name'][0])){
        $fileRoot=$getFromUsers->uploadImage($_FILES['profileCover']);

        $getFromUsers->update('user',$user_id,array('profile_cover'=>$fileRoot));
        header('Location:'.$user->username);
    }

}

?>

<?php include 'includes/header.inc.php'?>


    <!--Profile cover-->
    <div class="profile-cover-wrap">
        <div class="profile-cover-inner">
            <div class="profile-cover-img">
                <!-- PROFILE-COVER -->
                <img src="<?php echo $user->profile_cover; ?>"/>

                <div class="img-upload-button-wrap">
                    <div class="img-upload-button1">
                        <label for="cover-upload-btn">
                            <i class="fa fa-camera" aria-hidden="true"></i>
                        </label>
                        <span class="span-text1">
					Change your profile photo
				</span>
                        <input id="cover-upload-btn" type="checkbox"/>
                        <div class="img-upload-menu1">
                            <span class="img-upload-arrow"></span>
                            <form method="post" enctype="multipart/form-data">
                                <ul>
                                    <li>
                                        <label for="file-up">
                                            Upload photo
                                        </label>
                                        <input type="file" name="profileCover" onchange="this.form.submit()" id="file-up"/>
                                    </li>
                                    <li>
                                        <label for="cover-upload-btn">
                                            Cancel
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-nav">
            <div class="profile-navigation">
                <ul>
                    <li>
                        <a href="#">
                            <div class="n-head">
                                TWEETS
                            </div>
                            <div class="n-bottom">
                              <?php $getFromTweets->countTweets($user_id)?>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL.$user->username.'/following'?>">
                            <div class="n-head">
                               FOLLOWING
                            </div>
                            <div class="n-bottom">
                                <?php echo $user->following; ?>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL.$user->username.'/followers'?>">
                            <div class="n-head">
                                FOLLOWERS
                            </div>
                            <div class="n-bottom">
                                <?php echo $user->followers; ?>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="n-head">
                                LIKES
                            </div>
                            <div class="n-bottom">
                                <?php $getFromTweets->countLikes($user_id)?>
                            </div>
                        </a>
                    </li>

                </ul>
                <div class="edit-button">
			<span>
				<button class="f-btn" type="button" onclick="window.location.href='<?php echo $user->username?>'" value="Cancel">Cancel</button>
			</span>
                    <span>
				<input type="submit" id="save" value="Save Changes">
			</span>

                </div>
            </div>
        </div>
    </div><!--Profile Cover End-->

    <div class="in-wrapper">
        <div class="in-full-wrap">
            <div class="in-left">
                <div class="in-left-wrap">
                    <!--PROFILE INFO WRAPPER END-->
                    <div class="profile-info-wrap">
                        <div class="profile-info-inner">
                            <div class="profile-img">
                                <!-- PROFILE-IMAGE -->
                                <img src="<?php echo $user->profile_photo; ?>"/>
                                <div class="img-upload-button-wrap1">
                                    <div class="img-upload-button">
                                        <label for="img-upload-btn">
                                            <i class="fa fa-camera" aria-hidden="true"></i>
                                        </label>
                                        <span class="span-text">
                                                Change your profile photo
                                            </span>
                                                                    <input id="img-upload-btn" type="checkbox"/>
                                        <div class="img-upload-menu">
                                            <span class="img-upload-arrow"></span>
                                            <form method="post" enctype="multipart/form-data">
                                                <ul>
                                                    <li>
                                                        <label for="profileImage">
                                                            Upload photo
                                                        </label>
                                                        <input id="profileImage" type="file" onchange="this.form.submit()" name="profileImage"/>

                                                    </li>
                                                    <li><a href="#">Remove</a></li>
                                                    <li>
                                                        <label for="img-upload-btn">
                                                            Cancel
                                                        </label>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- img upload end-->
                                </div>
                            </div>

                            <form id="editForm" method="post" enctype="multipart/Form-data">
                                <div class="profile-name-wrap">
                                    <?php
                                    if (isset($imageError)){

                                        echo '<ul>
                                                  <li class="error-li">
                                                      <div class="span-pe-error">'.$imageError.'</div>
                                                 </li>
                                             </ul>';
                                    }?>


                                    <div class="profile-name">
                                        <input type="text" name="screenName" value="<?php echo $user->nick_name; ?>"/>
                                    </div>
                                    <div class="profile-tname">
                                        @<?php echo $user->username; ?>
                                    </div>
                                </div>
                                <div class="profile-bio-wrap">
                                    <div class="profile-bio-inner">
                                        <textarea class="status" name="bio"><?php echo $user->bio; ?></textarea>
                                        <div class="hash-box">
                                            <ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-extra-info">
                                    <div class="profile-extra-inner">
                                        <ul>
                                            <li>
                                                <div class="profile-ex-location">
                                                    <input id="cn" type="text" name="country" placeholder="Country"
                                                           value="<?php echo $user->country; ?>"/>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="profile-ex-location">
                                                    <input type="text" name="website" placeholder="Website"
                                                           value="<?php echo $user->website; ?>"/>
                                                </div>
                                            </li>

                                            <?php
                                            if (isset($error)){

                                                echo '
                                                  <li class="error-li">
                                                      <div class="span-pe-error">'.$error.'</div>
                                                 </li>
                                             ';
                                            }?>

                            </form>


                            <script type="text/javascript">


                                $('#save').click(function () {
                                    $('#editForm').submit();
                                })


                            </script>


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
                                <!-- <li><img src="#"></li> -->
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

            <?php $tweets = $getFromTweets->getUserTweets($user_id);

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
	<img src="' . BASE_URL . $user->profile_photo . '"/></div>
	<div class="t-s-head-content">
		<div class="t-h-c-name">
			 <span><a href="' . BASE_URL . $user->username . '">' . $user->nick_name . '</a></span>
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
			</ul>
		</div>
	</div>
</div>
</div>
</div>';
            }

            ?>


        </div>
        <!-- in left wrap-->
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
        </div>
        <!-- in left wrap-->
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
<script type="text/javascript" src="assets/js/messages.js"></script>
<script type="text/javascript" src="assets/js/postMsg.js"></script>


</body>
</html>

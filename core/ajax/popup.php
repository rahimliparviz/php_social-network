<?php


include '../init.php';


if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])) {
    $user_id = $_SESSION['user_id'];
    $tw_id = $_POST['showPopup'];

    $tw = $getFromTweets->getPopupTw($tw_id);
    $user= $getFromUsers->userData($user_id);
    $likes=$getFromTweets->likes($user_id,$tw_id);
    $retweet =$getFromTweets->checkRetweet($tw_id,$user_id);
    $comments = $getFromTweets->comments($tw_id);


   ?>


    <div class="tweet-show-popup-wrap">
        <input type="checkbox" id="tweet-show-popup-wrap">
        <div class="wrap4">
            <label for="tweet-show-popup-wrap">
                <div class="tweet-show-popup-box-cut">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </label>
            <div class="tweet-show-popup-box">
                <div class="tweet-show-popup-inner">
                    <div class="tweet-show-popup-head">
                        <div class="tweet-show-popup-head-left">
                            <div class="tweet-show-popup-img">
                                <img src="<?php echo BASE_URL.$tw->profile_photo ?>"/>
                            </div>
                            <div class="tweet-show-popup-name">
                                <div class="t-s-p-n">
                                    <a href=" <?php echo BASE_URL.$tw->username ?>">
                                       <?php echo $tw->nick_name ?>
                                    </a>
                                </div>
                                <div class="t-s-p-n-b">
                                    <a href="PROFILE-LINK">
                                        @ <?php echo $tw->username ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tweet-show-popup-head-right">
                            <button class="f-btn"><i class="fa fa-user-plus"></i> Follow </button>
                        </div>
                    </div>
                    <div class="tweet-show-popup-tweet-wrap">
                        <div class="tweet-show-popup-tweet">
                            <?php echo $getFromTweets->getTweetLinks($tw->status) ?>
                        </div>

                        <?php if(!empty($tw->tweetImage)){?>

                        <div class="tweet-show-popup-tweet-ifram">
                            <img src=" <?php echo BASE_URL.$tw->tweetImage ?>"/>
                        </div>

                        <?php }?>

                    </div>
                    <div class="tweet-show-popup-footer-wrap">
                        <div class="tweet-show-popup-retweet-like">
                            <div class="tweet-show-popup-retweet-left">
                                <div class="tweet-retweet-count-wrap">
                                    <div class="tweet-retweet-count-head">
                                        RETWEET
                                    </div>
                                    <div class="tweet-retweet-count-body">
                                        <?php echo $tw->retweetCount ?>
                                    </div>
                                </div>
                                <div class="tweet-like-count-wrap">
                                    <div class="tweet-like-count-head">
                                        LIKES
                                    </div>
                                    <div class="tweet-like-count-body">
                                        <?php echo $tw->likesCount ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tweet-show-popup-retweet-right">

                            </div>
                        </div>
                        <div class="tweet-show-popup-time">
                            <span> <?php echo $tw->postedOn ?></span>
                        </div>
                        <div class="tweet-show-popup-footer-menu">
                            <ul>

                                <?php if($getFromUsers->loggedIn() === true){
                                    echo '<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
                                    <li>' . (($tw->tweet_id === $retweet['retweetId']) ? '<button class="retweeted" data-tweet="' . $tw->tweet_id . '" data-user="' . $tw->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . $tw->retweetCount . '</span> </a></button></li>' : '<button class="retweet" data-tweet="' . $tw->tweet_id . '" data-user="' . $tw->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . (($tw->retweetCount > 0) ? $tw->retweetCount : "") . '</span> </a></button></li>') . '
                                    <li>' . (($likes['likeOn'] === $tw->tweet_id) ? '<button class="unlike-btn" data-tweet="' . $tw->tweet_id . '" data-user="' . $tw->tweetBy . '" ><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a> <span class="likesCount" >' . $tw->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $tw->tweet_id . '" data-user="' . $tw->tweetBy . '" ><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a> <span class="likesCount" >' . (($tw->likesCount > 0) ? $tw->likesCount : '') . '</span></button>') . '
                                    
                                    '.(($tw->tweetBy === $user_id) ? '
                                    <li>
                                        <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                        <ul>
                                            <li><label class="deleteTweet" data-tweet = "'.$tw->tweet_id.'" >Delete Tweet</label></li>
                                        </ul>
                                    </li>' : '');
                                }else {?>


                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div><!--tweet-show-popup-inner end-->
                <div class="tweet-show-popup-footer-input-wrap">
                    <?php if($getFromUsers->loggedIn() === true) {?>

                    <div class="tweet-show-popup-footer-input-inner">
                        <div class="tweet-show-popup-footer-input-left">
                            <img src="<?php echo BASE_URL.$user->profile_photo ?>"/>
                        </div>
                        <div class="tweet-show-popup-footer-input-right">
                            <input id="commentField" type="text"  data-tweet = "<?php echo $tw->tweet_id?>" name="comment"  placeholder="Reply to @<?php echo $tw->username; ?>">
                        </div>
                    </div>
                    <div class="tweet-footer">
                        <div class="t-fo-left">
                            <ul>
                                <li>
                                    <!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                    <input type="file" id="t-show-file"> -->
                                </li>
                                <li class="error-li">
                                </li>
                            </ul>
                        </div>
                        <div class="t-fo-right">
                            <input type="submit" id="postComment">

                            <script type="text/javascript" src='<?php echo BASE_URL?>/assets/js/follow.js'></script>

                        </div>
                    </div>
                </div><!--tweet-show-popup-footer-input-wrap end-->
                                    <?php }?>
                <div class="tweet-show-popup-comment-wrap">
                    <div id="comments">
                        <?php foreach ($comments as $c) {
                                echo '<div class="tweet-show-popup-comment-box">
<div class="tweet-show-popup-comment-inner">
	<div class="tweet-show-popup-comment-head">
		<div class="tweet-show-popup-comment-head-left">
			 <div class="tweet-show-popup-comment-img">
			 	<img src="'.BASE_URL.$c->profile_photo .'">
			 </div>
		</div>
		<div class="tweet-show-popup-comment-head-right">
			  <div class="tweet-show-popup-comment-name-box">
			 	<div class="tweet-show-popup-comment-name-box-name"> 
			 		<a href="'.BASE_URL.$c->username .'">'.$c->nick_name .'</a>
			 	</div>
			 	<div class="tweet-show-popup-comment-name-box-tname">
			 		<a href="'.BASE_URL.$c->username.'">@'.$c->username.' - '.$c->commentAt.'</a>
			 	</div>
			 </div>
			 <div class="tweet-show-popup-comment-right-tweet">
			 		<p><a href="'.BASE_URL.$tw->username .'">@'.$tw->username .'</a>'.$c->comment.'</p>
			 </div>
		 	<div class="tweet-show-popup-footer-menu">
				<ul>
					<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
					<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
					<li>
					'.(($c->commentBy === $user_id) ? '
					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
					<ul> 
					  <li><label class="deleteComment" data-tweet = "'.$tw->tweet_id.'" data-comment = "'.$c->comment_id.'">Delete Comment</label></li>
					</ul>
					</li>' : '').'
				</ul>
			</div>
		</div>
	</div>
</div>
<!--TWEET SHOW POPUP COMMENT inner END-->
</div>
';
                        }?>
                    </div>

                </div>
                <!--tweet-show-popup-box ends-->
            </div>
        </div>

    <?php }

    ?>
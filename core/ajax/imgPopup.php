<?php
include '../init.php';

if(isset($_POST['showImg']) && !empty($_POST['showImg'])) {
    $user_id = $_SESSION['user_id'];

    $tw_id = $getFromUsers->$_POST['tw_id'];
    $tw =$getFromTweets->getPopupTw($tw_id);
    $likes=$getFromTweets->likes($user_id,$tw_id);
    $retweet =$getFromTweets->checkRetweet($tw_id,$user_id);

    ?>

    <div class="img-popup">
        <div class="wrap6">
<span class="colose">
	<button class="close-imagePopup"><i class="fa fa-times" aria-hidden="true"></i></button>
</span>
            <div class="img-popup-wrap">
                <div class="img-popup-body">
                    <img src="<?php echo BASE_URL.$tw->tweetImage?>"/>
                </div>
                <div class="img-popup-footer">
                    <div class="img-popup-tweet-wrap">
                        <div class="img-popup-tweet-wrap-inner">
                            <div class="img-popup-tweet-left">
                                <img src="<?php echo BASE_URL.$tw->profile_photo?>"/>
                            </div>
                            <div class="img-popup-tweet-right">
                                <div class="img-popup-tweet-right-headline">
                                    <a href="<?php echo BASE_URL.$tw->username?>"><?php echo $tw->nick_name?></a><span>@<?php echo $tw->username?> -<?php echo $tw->postedOn?></span>
                                </div>
                                <div class="img-popup-tweet-right-body">
                                    <?php echo $getFromTweets->getTweetLinks($tw->status)?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="img-popup-tweet-menu">
                        <div class="img-popup-tweet-menu-inner">
                            <ul>
                                <?php if($getFromUsers->loggedIn() === true){
                                    echo '<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
				<li>' . (($t->tweet_id === $retweet['retweetId']) ? '<button class="retweeted" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . $t->retweetCount . '</span> </a></button></li>' : '<button class="retweet" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="retweetsCount">' . (($t->retweetCount > 0) ? $t->retweetCount : "") . '</span> </a></button></li>') . '
				<li>' . (($likes['likeOn'] === $t->tweet_id) ? '<button class="unlike-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a> <span class="likesCount" >' . $t->likesCount . '</span></button>' : '<button class="like-btn" data-tweet="' . $t->tweet_id . '" data-user="' . $t->tweetBy . '" ><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a> <span class="likesCount" >' . (($t->likesCount > 0) ? $t->likesCount : '') . '</span></button>') . '
				
				'.(($tw->tweetBy === $user_id) ? '
				
				<li><label for="img-popup-menu"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></label>
                                    <input id="img-popup-menu" type="checkbox"/>
                                    <div class="img-popup-footer-menu">
                                        <ul>
                                            <li><label data-tweet="' . $tw->tweet_id . '" class="deleteTweet" >Delete Tweet</label></li>
                                        </ul>
                                    </div>
                                </li>': '');
                                }else{
                                    echo ' <li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
                                <li><button class="retweet"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount"></span></button></li>
                                <li><button class="like-btn"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter"></span></button></li>';
                                }?>




                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Image PopUp ends-->



    <?php


}
?>
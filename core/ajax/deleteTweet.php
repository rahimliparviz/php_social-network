<?php


include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if(isset($_POST['deleteTweet']) && !empty($_POST['deleteTweet'])) {
    $user_id = $_SESSION['user_id'];
    $tw_id = $_POST['deleteTweet'];
    $getFromTweets->delete('tweets',array('tweet_id'=>$tw_id,'tweetBy'=>$user_id));
}

if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])) {

    $tw_id = $_POST['showPopup'];
    $tw = $getFromTweets->getPopupTw($tw_id);
    $user_id = $_SESSION['user_id'];
    ?>


    <div class="retweet-popup">
        <div class="wrap5">
            <div class="retweet-popup-body-wrap">
                <div class="retweet-popup-heading">
                    <h3>Are you sure you want to delete this Tweet?</h3>
                    <span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
                </div>
                <div class="retweet-popup-inner-body">
                    <div class="retweet-popup-inner-body-inner">
                        <div class="retweet-popup-comment-wrap">
                            <div class="retweet-popup-comment-head">
                                <img src="<?php echo BASE_URL.$tw->profile_photo?>"/>
                            </div>
                            <div class="retweet-popup-comment-right-wrap">
                                <div class="retweet-popup-comment-headline">
                                    <a><?php echo $tw->nick_name?> </a><span>‏@<?php echo $tw->username ?> <?php echo $tw->postedOn ?></span>
                                </div>
                                <div class="retweet-popup-comment-body">
                                    <?php echo  $getFromTweets->getTweetLinks($tw->status).''. $tw->tweetImage?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="retweet-popup-footer">
                    <div class="retweet-popup-footer-right">
                        <button class="cancel-it f-btn">Cancel</button><button class="delete-it" type="submit">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>






<?php

}
?>
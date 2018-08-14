<?php

include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


if(isset($_POST['retweet']) && !empty($_POST['retweet'])) {
    $user_id = $_SESSION['user_id'];
    $tw_id = $_POST['retweet'];
    $get_id = $_POST['user_id'];
    $comment=$getFromTweets->checkInput($_POST['comment']);
    $getFromTweets->retweet($tw_id,$user_id,$get_id,$comment);
}

if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])) {



    $tw_id = $_POST['showPopup'];
    $get_id = $_POST['user_id'];

    $tw =  $getFromTweets->getPopupTw($tw_id);

    ?>

    <div class="retweet-popup">
        <div class="wrap5">
	<div class="retweet-popup-body-wrap">
		<div class="retweet-popup-heading">
			<h3>Retweet this to followers?</h3>
			<span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
		</div>
		<div class="retweet-popup-input">
			<div class="retweet-popup-input-inner">
				<input type="text" class="retweetMsg" placeholder="Add a comment.."/>
			</div>
		</div>
		<div class="retweet-popup-inner-body">
			<div class="retweet-popup-inner-body-inner">
				<div class="retweet-popup-comment-wrap">
					 <div class="retweet-popup-comment-head">
					 	<img src="<?php echo BASE_URL.$tw->profile_photo ?>"/>
					 </div>
					 <div class="retweet-popup-comment-right-wrap">
						 <div class="retweet-popup-comment-headline">
						 	<a><?php echo $tw->nick_name ?></a><span>‏@<?php echo $tw->username ?> - <?php echo $tw->postedOn?></span>
						 </div>
						 <div class="retweet-popup-comment-body">
                             <?php echo $getFromTweets->getTweetLinks($tw->status); ?>   - <?php echo $tw->tweetImage;?>
						 </div>
					 </div>
				</div>
			</div>
		</div>
		<div class="retweet-popup-footer"> 
			<div class="retweet-popup-footer-right">
				<button class="retweet-it" type="submit"><i class="fa fa-retweet" aria-hidden="true"></i>Retweet</button>
			</div>
		</div>
	</div>
</div>
</div><!-- Retweet PopUp ends-->

    
    <?php
}



?>
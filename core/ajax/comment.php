<?php


include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


if(isset($_POST['comment']) && !empty($_POST['comment'])) {
    $user_id = $_SESSION['user_id'];
    $tw_id = $getFromUsers->checkInput($_POST['tw_id']);
    $cm = $_POST['comment'];



    if (!empty($cm)){

        $getFromUsers->create('comments',array('comment'=>$cm,'commentOn'=>$tw_id,'commentBy'=>$user_id, 'commentAt'=>date('Y-m-d H:i:s')));
        $comments = $getFromTweets->comments($tw_id);
        $tw = $getFromTweets->getPopupTw($tw_id);




        foreach ($comments as $c) {
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
			 		<a href="'.BASE_URL.$c->username.'">@'. $c->username .' - '. $c->commentAt .'</a>
			 	</div>
			 </div>
			 <div class="tweet-show-popup-comment-right-tweet">
			 		<p><a href="'.BASE_URL.$tw->username .'">@'.$tw->username .'</a>'.$c->comment.'</p>
			 </div>
		 	<div class="tweet-show-popup-footer-menu">
				<ul>
					<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
					<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
					'.(($c->commentBy === $user_id) ? '
					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
					<ul> 
					  <li><label class="deleteTweet" data-tweet = "'.$tw->tweet_id.'" data-comment = "'.$c->comment_id.'">Delete Tweet</label></li>
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
        }
    };




}

?>

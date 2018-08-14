<?php
include 'core/init.php';

$user_id = $_SESSION['user_id'];
$user=$getFromUsers->userData($user_id);
$getFromMsgs->notiViewed($user_id);
$notify =$getFromMsgs->getNotiCount($user_id);
$notifications = $getFromMsgs->noti($user_id);



if ($getFromUsers->loggedIn() ===false){
    header('Location:index.php');
}





if (isset($_POST['tweet'])) {
    $status = $getFromUsers->checkInput($_POST['status']);
    $tweetImg = '';

    if (!empty($status) or !empty($_FILES['file']['name'][0])) {
        if (!empty($_FILES['file']['name'][0])) {
            $tweetImg=$getFromUsers->uploadImage($_FILES['file']);
        } if (strlen($status) > 140) {
            $error = 'Text is too long';
        }
        $getFromUsers->create('tweets',array('status'=>$status,'tweetBy'=> $user_id,'tweetImage'=>$tweetImg,'postedOn'=>date('Y-m-d H:i:s')));

        preg_match_all("/#+([a-zA-Z0-9])+/i",$status,$hashtag);


        unset($_POST['tweet']);

        header('Location:home.php');

        if(!empty($hashtag)){
            $getFromTweets->addtrend($status);
        }
    } else {
        $error['fields'] = 'Type or choose image to tweet';
    }
}

?>



<?php include 'includes/header.inc.php'?>






<!---Inner wrapper-->
<div class="inner-wrapper">
    <div class="in-wrapper">
        <div class="in-full-wrap">
            <div class="in-left">
                <div class="in-left-wrap">
                    <div class="info-box">
                        <div class="info-inner">
                            <div class="info-in-head">
                                <!-- PROFILE-COVER-IMAGE -->
                                <img src="<?php echo BASE_URL.$user->profile_cover; ?>"/>
                            </div><!-- info in head end -->
                            <div class="info-in-body">
                                <div class="in-b-box">
                                    <div class="in-b-img">
                                        <!-- PROFILE-IMAGE -->
                                        <img src="<?php echo BASE_URL.$user->profile_photo; ?>"/>
                                    </div>
                                </div><!--  in b box end-->
                                <div class="info-body-name">
                                    <div class="in-b-name">
                                        <div><a href="<?php echo BASE_URL.$user->username; ?>"><?php echo $user->nick_name; ?></a></div>
                                        <span><small><a href="<?php echo BASE_URL.$user->username; ?>">@<?php echo $user->username; ?></a></small></span>
                                    </div><!-- in b name end-->
                                </div><!-- info body name end-->
                            </div><!-- info in body end-->
                            <div class="info-in-footer">
                                <div class="number-wrapper">
                                    <div class="num-box">
                                        <div class="num-head">
                                            TWEETS
                                        </div>
                                        <div class="num-body">
                                            <?php $getFromTweets->countTweets($user_id)?>
                                        </div>
                                    </div>
                                    <div class="num-box">
                                        <div class="num-head">
                                            FOLLOWING
                                        </div>
                                        <div class="num-body">
                                                <span class="count-following">

                                                    <?php echo $user->following ;?></span>
                                        </div>
                                    </div>
                                    <div class="num-box">
                                        <div class="num-head">
                                            FOLLOWERS
                                        </div>
                                        <div class="num-body">
                                            <span class="count-followers">
                                                <?php echo $user->followers ;?></span>
                                        </div>
                                    </div>
                                </div><!-- mumber wrapper-->
                            </div><!-- info in footer -->
                        </div><!-- info inner end -->
                    </div><!-- info box end-->

                    <!--==TRENDS==-->
                    <?php $getFromTweets->trends();
                    ?>
                    <!--==TRENDS==-->

                </div><!-- in left wrap-->
            </div><!-- in left end-->
            <div class="in-center">
                <div class="in-center-wrap">












                    <!--NOTIFICATION WRAPPER FULL WRAPPER-->
                    <div class="notification-full-wrapper">

                        <div class="notification-full-head">
                            <div>
                                <a href="#">All</a>
                            </div>
                            <div>
                                <a href="#">Mention</a>
                            </div>
                            <div>
                                <a href="#">settings</a>
                            </div>
                        </div>


                        <?php  foreach($notifications as $n) :?>
                            <?php   if ($n->type == 'follow') :?>

                        <!-- Follow Notification -->
                        <!--NOTIFICATION WRAPPER-->
                        <div class="notification-wrapper">
                            <div class="notification-inner">
                                <div class="notification-header">

                                    <div class="notification-img">
                                        <span class="follow-logo">
                                            <i class="fa fa-child" aria-hidden="true"></i>
                                        </span>
                                                            </div>
                                    <div class="notification-name">
                                        <div>
                                            <img src="<?php echo BASE_URL.$n->profile_photo?>"/>
                                        </div>

                                    </div>
                                    <div class="notification-tweet">
                                        <a href="<?php echo BASE_URL.$n->username?>" class="notifi-name"><?php echo $n->nick_name?></a><span> Followed you your - <span><?php echo $getFromUsers->timeAgo($n->time)?></span>

                                    </div>

                                </div>

                            </div>
                            <!--NOTIFICATION-INNER END-->
                        </div>
                        <!--NOTIFICATION WRAPPER END-->
                        <!-- Follow Notification -->
                        <?php endif;?>

                        <?php   if ($n->type == 'like') :?>

                        <!-- Like Notification -->
                        <!--NOTIFICATION WRAPPER-->
                        <div class="notification-wrapper">
                            <div class="notification-inner">
                                <div class="notification-header">
                                    <div class="notification-img">
                                    <span class="heart-logo">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </span>
                                                        </div>
                                    <div class="notification-name">
                                        <div>
                                            <img src="<?php echo BASE_URL.$n->profile_photo?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-tweet">
                                    <a href="<?php echo BASE_URL.$user->username?>" class="notifi-name"><?php echo $user->nick_name?></a><span> liked your <?php if($n->tweetBy == $user_id){echo 'Tweet';}else{echo 'Retweet';}?> - <span><?php echo $getFromUsers->timeAgo($n->time)?></span>
                                </div>
                                <div class="notification-footer">
                                    <div class="noti-footer-inner">
                                        <div class="noti-footer-inner-left">
                                            <div class="t-h-c-name">
                                                <span><a href="<?php echo BASE_URL.$n->username?>"><?php echo $n->nick_name?></a></span>
                                                <span>@<?php echo $user->username?></span>
                                                <span><?php echo $getFromUsers->timeAgo($n->time)?></span>
                                            </div>
                                            <div class="noti-footer-inner-right-text">
                                                <?php echo $getFromTweets->getTweetLinks($n->status)?>
                                            </div>
                                        </div>



                                        <?php if (!empty($n->tweetImage)) :?>
                                        <div class="noti-footer-inner-right">
                                            <img src="<?php echo BASE_URL.$n->tweetImage?>"/>
                                        </div>
                                        <?php endif;?>

                                    </div><!--END NOTIFICATION-inner-->
                                </div>
                            </div>
                        </div>
                        <!--NOTIFICATION WRAPPER END-->
                        <!-- Like Notification -->

                            <?php endif;?>


                        <?php   if ($n->type == 'retweet') :?>

                        <!-- Retweet Notification -->





                        <!--NOTIFICATION WRAPPER-->
                        <div class="notification-wrapper">
                            <div class="notification-inner">
                                <div class="notification-header">

                                    <div class="notification-img">
				<span class="retweet-logo">
					<i class="fa fa-retweet" aria-hidden="true"></i>
				</span>
                                    </div>
                                    <div class="notification-tweet">
                                        <a href="<?php echo BASE_URL.$n->username ?>" class="notifi-name"><?php echo BASE_URL.$n->nick_name ?></a><span> retweet your <?php if($n->tweetBy == $user_id){echo 'Tweet';}else{echo 'Retweet';}?> - <span><?php echo $getFromUsers->timeAgo($n->time)?></span>
                                    </div>
                                    <div class="notification-footer">
                                        <div class="noti-footer-inner">

                                            <div class="noti-footer-inner-left">
                                                <div class="t-h-c-name">
                                                    <span><a href="<?php echo BASE_URL.$user->username?>"><?php echo $user->nick_name?></a></span>
                                                    <span>@<?php echo $user->username?></span>
                                                    <span><?php echo $getFromUsers->timeAgo($n->time)?></span>
                                                </div>
                                                <div class="noti-footer-inner-right-text">
                                                    <?php echo $getFromTweets->getTweetLinks($n->status)?>
                                                </div>
                                            </div>



                                            <?php if (!empty($n->tweetImage)) :?>
                                                <div class="noti-footer-inner-right">
                                                    <img src="<?php echo BASE_URL.$n->tweetImage?>"/>
                                                </div>
                                            <?php endif;?>

                                        </div><!--END NOTIFICATION-inner-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--NOTIFICATION WRAPPER END-->
                        <!-- Retweet Notification -->
                            <?php endif;?>

                            <?php if($n->type == 'mention'):?>
                        <?php

                        $t =$n;

                        $likes = $getFromTweets->likes($user_id, $t->tweet_id);
                        $retweet = $getFromTweets->checkRetweet($t->tweet_id, $user_id);

                        echo '
                        <div class="all-tweet-inner">
                            <div class="t-show-wrap">
                                <div class="t-show-inner">


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
                                ' : '') . '


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
                                ?>

                            <?php endif;?>




                        <?php endforeach;?>
                    </div>
                    <!--NOTIFICATION WRAPPER FULL WRAPPER END-->








                    <div class="loading-div">
                        <img id="loader" src="<?php echo BASE_URL?>assets/images/loading.svg" style="display: none;"/>
                    </div>
                    <div class="popupTweet"></div>
                    <!--Tweet END WRAPER-->

                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/retweet.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/like.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/popup.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/comment.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/delete.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/popupForm.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/fetch.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/messages.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/postMsg.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/noti.js"></script>
                    <script src="<?php echo BASE_URL?>assets/js/follow.js"></script>




                </div><!-- in left wrap-->
            </div><!-- in center end -->

            <div class="in-right">
                <div class="in-right-wrap">

                    <!--Who To Follow-->
                    <?php $getFromFollows->whoToFollow($user_id,$user_id);?>
                    <!--Who To Follow-->

                </div><!-- in left wrap-->

            </div><!-- in right end -->
        </div><!--in full wrap end-->

    </div><!-- in wrappper ends-->
</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>

</html>
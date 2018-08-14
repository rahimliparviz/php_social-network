<?php
include 'core/init.php';

$user_id = $_SESSION['user_id'];
$user=$getFromUsers->userData($user_id);
$notify =$getFromMsgs->getNotiCount($user_id);


//$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


var_dump(realpath(__FILE__));
var_dump(realpath($_SERVER['SCRIPT_FILENAME']));
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
       $tw_id = $getFromUsers->create('tweets',array('status'=>$status,'tweetBy'=> $user_id,'tweetImage'=>$tweetImg,'postedOn'=>date('Y-m-d H:i:s')));

        preg_match_all("/#+([a-zA-Z0-9])+/i",$status,$hashtag);


        unset($_POST['tweet']);

        header('Location:home.php');

        if(!empty($hashtag)){
            $getFromTweets->addtrend($status);
        }

        $getFromTweets->addMention($status,$user_id,$tw_id);

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
                                    <img src="<?php echo $user->profile_cover; ?>"/>
                                </div><!-- info in head end -->
                                <div class="info-in-body">
                                    <div class="in-b-box">
                                        <div class="in-b-img">
                                            <!-- PROFILE-IMAGE -->
                                            <img src="<?php echo $user->profile_photo; ?>"/>
                                        </div>
                                    </div><!--  in b box end-->
                                    <div class="info-body-name">
                                        <div class="in-b-name">
                                            <div><a href="<?php echo $user->username; ?>"><?php echo $user->nick_name; ?></a></div>
                                            <span><small><a href="<?php echo $user->username; ?>">@<?php echo $user->username; ?></a></small></span>
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
                                                <span class="count-followers"><?php echo $user->followers ;?></span>
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
                        <!--TWEET WRAPPER-->
                        <div class="tweet-wrap">
                            <div class="tweet-inner">
                                <div class="tweet-h-left">
                                    <div class="tweet-h-img">
                                        <!-- PROFILE-IMAGE -->
                                        <img src="<?php echo $user->profile_photo; ?>"/>
                                    </div>
                                </div>
                                <div class="tweet-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <textarea class="status" name="status" placeholder="Type Something here!" rows="4" cols="50"></textarea>
                                        <div class="hash-box">
                                            <ul>
                                            </ul>
                                        </div>
                                </div>
                                <div class="tweet-footer">
                                    <div class="t-fo-left">
                                        <ul>
                                            <input type="file" name="file" id="file"/>
                                            <li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                                <span class="tweet-error"><?php
                                                    if (isset($error)){
                                                    echo $error;
                                                }else if(isset($Imgerror)){
                                                        echo $Imgerror;
                                                    }?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="t-fo-right">
                                        <span id="count">140</span>
                                        <input type="submit" name="tweet" value="tweet"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!--TWEET WRAP END-->


                        <!--Tweet SHOW WRAPPER-->
                        <div class="tweets">
                            <?php $getFromTweets->tweets($user_id,5)?>
                        </div>
                        <!--TWEETS SHOW WRAPPER-->

                        <div class="loading-div">
                            <img id="loader" src="assets/images/loading.svg" style="display: none;"/>
                        </div>
                        <div class="popupTweet"></div>
                        <!--Tweet END WRAPER-->
                        <script type="text/javascript" src="assets/js/a.js"></script>

                        <script type="text/javascript" src="assets/js/retweet.js"></script>
                        <script type="text/javascript" src="assets/js/like.js"></script>
                        <script type="text/javascript" src="assets/js/popup.js"></script>
                        <script type="text/javascript" src="assets/js/comment.js"></script>
                        <script type="text/javascript" src="assets/js/delete.js"></script>
                        <script type="text/javascript" src="assets/js/popupForm.js"></script>
                        <script type="text/javascript" src="assets/js/fetch.js"></script>
                        <script type="text/javascript" src="assets/js/messages.js"></script>
                        <script type="text/javascript" src="assets/js/postMsg.js"></script>
                        <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/noti.js"></script>




                    </div><!-- in left wrap-->
                </div><!-- in center end -->

                <div class="in-right">
                    <div class="in-right-wrap">

                        <!--Who To Follow-->
                       <?php $getFromFollows->whoToFollow($user_id,$user_id);?>
                        <!--Who To Follow-->

                    </div><!-- in left wrap-->

                </div><!-- in right end -->
                <script src="assets/js/follow.js"></script>
            </div><!--in full wrap end-->

        </div><!-- in wrappper ends-->
    </div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>

</html>
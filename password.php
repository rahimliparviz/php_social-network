<?php
include 'core/init.php';

if ($getFromUsers->loggedIn() === false) {

    header('Location:index.php');
}

$user_id = $_SESSION['user_id'];
$user = $getFromUsers->userData($user_id);



if (isset($_POST['submit'])) {
    $curPas=$getFromUsers->checkInput($_POST['currentPwd']);
    $newPas=$getFromUsers->checkInput($_POST['newPassword']);
    $rePas=$getFromUsers->checkInput($_POST['rePassword']);
    $error = array();


    if (!empty($curPas) and !empty($newPas) and !empty($rePas)) {
        if ($getFromUsers->checkPassword(md5($curPas)) === true) {

            if (strlen($newPas)<6){
                $error['newPas'] = 'Password is too short';
            }
            else if ($newPas != $rePas) {
                $error['rePas'] = 'Password does not match';
            }
            else{
                $getFromUsers->update('user',$user_id,array('password'=>md5($newPas)));
                header('Location:'.BASE_URL.$user->username);
            }
        }
        else{
            $error['curPas']='Password is incorrect';
        }

    }
    else {
        $error['fields'] = 'All fields are required';
    }
}









?>



<html>
<head>
    <title>Paaword settings page</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
</head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
    <!-- header wrapper -->
    <div class="header-wrapper">

        <div class="nav-container">
            <!-- Nav -->
            <div class="nav">
                <div class="nav-left">
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                        <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
                        <li id="messagePopup" rel="user_id"><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
                    </ul>
                </div>
                <!-- nav left ends-->
                <div class="nav-right">
                    <ul>
                        <li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i></li>
                        <div class="nav-right-down-wrap">
                            <ul class="search-result">

                            </ul>
                        </div>
                        <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL . $user->profile_photo ?>"/></label>
                            <input type="checkbox" id="drop-wrap1">
                            <div class="drop-wrap">
                                <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?php echo $user->username ?>"><?php echo $user->username ?></a></li>
                                        <li><a href="settings/account">Settings</a></li>
                                        <li><a href="includes/logout.php">Log out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><label for="pop-up-tweet">Tweet</label></li>

                    </ul>
                </div>
                <!-- nav right ends-->

            </div>
            <!-- nav ends -->






        </div><!-- nav container ends -->
    </div><!-- header wrapper end -->

    <div class="container-wrap">

        <div class="lefter">
            <div class="inner-lefter">

                <div class="acc-info-wrap">
                    <div class="acc-info-bg">
                        <!-- PROFILE-COVER -->
                        <img src="<?php echo BASE_URL . $user->profile_cover ?>"/>
                    </div>
                    <div class="acc-info-img">
                        <!-- PROFILE-IMAGE -->
                        <img src="<?php echo BASE_URL . $user->profile_photo ?>"/>
                    </div>
                    <div class="acc-info-name">
                        <h3><?php echo $user->nick_name; ?></h3>
                        <span><a href="<?php echo $user->username; ?>">@<?php echo $user->username ?></a></span>
                    </div>
                </div><!--Acc info wrap end-->

                <div class="option-box">
                    <ul>
                        <li>
                            <a href="<?php echo BASE_URL?>settings/account" class="bold">
                                <div>
                                    Account
                                    <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL?>settings/password">
                                <div>
                                    Password
                                    <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div><!--LEFTER ENDS-->

        <div class="righter">
            <div class="inner-righter">
                <div class="acc">
                    <div class="acc-heading">
                        <h2>Password</h2>
                        <h3>Change your password or recover your current one.</h3>
                    </div>
                    <form method="POST">
                        <div class="acc-content">
                            <div class="acc-wrap">
                                <div class="acc-left">
                                    Current password
                                </div>
                                <div class="acc-right">
                                    <input type="password" name="currentPwd"/>
                                    <span>
								 <?php if (isset($error['curPas'])) {
                                     echo $error['curPas'];
                                 } ?>
							</span>
                                </div>
                            </div>

                            <div class="acc-wrap">
                                <div class="acc-left">
                                    New password
                                </div>
                                <div class="acc-right">
                                    <input type="password" name="newPassword" />
                                    <span>
							 <?php if (isset($error['newPas'])) {
                                 echo $error['newPas'];
                             } ?>
							</span>
                                </div>
                            </div>

                            <div class="acc-wrap">
                                <div class="acc-left">
                                    Verify password
                                </div>
                                <div class="acc-right">
                                    <input type="password" name="rePassword"/>
                                    <span>
							 <?php if (isset($error['rePas'])) {
                                 echo $error['rePas'];
                             } ?>
							</span>
                                </div>
                            </div>
                            <div class="acc-wrap">
                                <div class="acc-left">
                                </div>
                                <div class="acc-right">
                                    <input type="Submit" name="submit" value="Save changes"/>
                                </div>
                                <div class="settings-error">
                                    <?php if (isset($error['fields'])) {
                                        echo $error['fields'];
                                    } ?>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="content-setting">
                <div class="content-heading">

                </div>
                <div class="content-content">
                    <div class="content-left">

                    </div>
                    <div class="content-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--RIGHTER ENDS-->
</div>
<!--CONTAINER_WRAP ENDS-->
</div>
<!-- ends wrapper -->


<script type="text/javascript" src='<?php echo BASE_URL?>/assets/js/search.js'></script>
<script type="text/javascript" src='<?php echo BASE_URL?>/assets/js/hashtag.js'></script>
<script type="text/javascript" src="<?php echo BASE_URL?>/assets/js/popupForm.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/delete.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/messages.js">
    <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/postMsg.js"></script>

</body>
</html>


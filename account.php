<?php
include 'core/init.php';

if ($getFromUsers->loggedIn() === false) {

    header('Location:index.php');
}

$user_id = $_SESSION['user_id'];
$user = $getFromUsers->userData($user_id);
$notify =$getFromMsgs->getNotiCount($user_id);

if (isset($_POST['submit'])) {
    $username = $getFromUsers->checkInput($_POST['username']);
    $email = $getFromUsers->checkInput($_POST['email']);
    $error = array();

    if (!empty($username) and !empty($email)) {
        if ($user->username != $username and $getFromUsers->checkUsername($username) === true) {
            $error['username'] = 'Username is not available';
        } else if (preg_match("/[^a-zA-Z0-9\!]/", $username)) {
            $error['username'] = 'Only charackters and numbers allowed';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $error['email'] = 'Invalid email format';
        } else if ($user->$email != $email and $getFromUsers->checkemail($email) === true) {
            $error['email'] = 'Email alreade in use';
        } else {
            $getFromUsers->update('user', $user_id, array('username' => $username, 'email' => $email));
            header('Location:' . BASE_URL . 'settings/account');
        }
    } else {
        $error['fields'] = 'All fields are required';
    }
}


?>

<?php include 'includes/header.inc.php'?>



            <script type="text/javascript" src='<?php echo BASE_URL?>/assets/js/search.js'></script>
            <script type="text/javascript" src='<?php echo BASE_URL?>/assets/js/hashtag.js'></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>/assets/js/popupForm.js">
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/messages.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/delete.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/postMsg.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL?>assets/js/noti.js"></script>







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
                        <h2>Account</h2>
                        <h3>Change your basic account settings.</h3>
                    </div>
                    <div class="acc-content">
                        <form method="POST">
                            <div class="acc-wrap">
                                <div class="acc-left">
                                    USERNAME
                                </div>
                                <div class="acc-right">
                                    <input type="text" name="username" value="<?php echo $user->username ?>"/>
                                    <span>
									<?php if (isset($error['username'])) {
                                        echo $error['username'];
                                    } ?>
								</span>
                                </div>
                            </div>

                            <div class="acc-wrap">
                                <div class="acc-left">
                                    Email
                                </div>
                                <div class="acc-right">
                                    <input type="text" name="email" value="<?php echo $user->email ?>"/>
                                    <span>
									<?php if (isset($error['email'])) {
                                        echo $error['email'];
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
        </div><!--RIGHTER ENDS-->

    </div>
    <!--CONTAINER_WRAP ENDS-->

</div><!-- ends wrapper -->
</body>

</html>



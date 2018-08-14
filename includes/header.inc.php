<!DOCTYPE HTML>
<html>
<head>
    <title>Tweety</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/font/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/style-complete.css"/>
    <script src="<?php echo BASE_URL?>assets/js/jquery.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
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

                        <li><a href="<?php BASE_URL?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                        <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification<span id="notification"><?php if ($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';}?></span></a></li>
                        <li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages <span id="messages"><?php if ($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';}?></span></li>
                    </ul>
                </div><!-- nav left ends-->

                <div class="nav-right">
                    <ul>
                        <li>
                            <input type="text" placeholder="Search" class="search"/>
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <div class="search-result">
                            </div>
                        </li>

                        <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profile_photo; ?>"/></label>
                            <input type="checkbox" id="drop-wrap1">
                            <div class="drop-wrap">
                                <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?php echo $user->username; ?>"><?php echo $user->username; ?></a></li>
                                        <li><a href="settings/account">Settings</a></li>
                                        <li><a href="includes/logout.php">Log out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><label class="addTweetBtn">Tweet</label></li>
                    </ul>
                </div><!-- nav right ends-->

            </div><!-- nav ends -->

        </div><!-- nav container ends -->

    </div><!-- header wrapper end -->




    <script type="text/javascript" src='<?php echo BASE_URL?>assets/js/search.js'></script>
    <script type="text/javascript" src='<?php echo BASE_URL?>/assets/js/hashtag.js'></script>
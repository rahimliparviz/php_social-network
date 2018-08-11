<?php 
include '../init.php';
//echo '<li><span class="getValue">'.$_POST['hashtag'].'</span></li>';

if(isset($_POST['hashtag'])){

    $hash= $getFromUsers->checkInput($_POST['hashtag']);
    $mention= $getFromUsers->checkInput($_POST['hashtag']);


    if(substr($hash,0,1) === '#'){

        $trend= str_replace('#','',$hash);
        $trends=$getFromTweets->trendsByHash($trend);

        //echo var_dump($trends);

        foreach($trends as $t){
           
                echo '<li><a href="#"><span class="getValue">'.'#'.$t->hashtag.'</span></a></li>';
        }
    }
    if(substr($mention,0,1) === '@'){

        $mention= str_replace('@','',$mention);
        $mentions=$getFromTweets->getMention($mention);




        foreach($mentions as $m ){

            echo '<li><div class="nav-right-down-inner">
                        <div class="nav-right-down-left">
                            <span><img src="'.BASE_URL.$m->profile_photo.'"></span>
                        </div>
                        <div class="nav-right-down-right">
                            <div class="nav-right-down-right-headline">
                                <a>'.$m->nick_name.'</a><span class="getValue">@'.$m->username.'</span>
                            </div>
                        </div>
                    </div><!--nav-right-down-inner end-here-->
                    </li>';
        }
    }
}
?>
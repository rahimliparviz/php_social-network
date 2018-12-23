<?php


//if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__)==realpath($_SERVER['SCRIPT_FILENAME'])){
  //  header('Location:../index.php');
//}

if (isset($_POST['signup'])){

    $nickName= $_POST['nickName'];
    $password= $_POST['password'];
    $email= $_POST['email'];
    $error ='';

    if (empty($nickName) or empty($password) or empty($email))
    {
        $error= 'All fields are required';
    }
        else{
        $email =$getFromUsers->checkInput($email);
        $nickName =$getFromUsers->checkInput($nickName);
        $password =$getFromUsers->checkInput($password);

        if(!filter_var($email)){
            $error="Email is invalid";
        }
        else if(strlen($nickName) > 20){
            $error="Name must be between in 6-20 characters";
        }else if(strlen($password) < 5){
            $error="Password is too short";
        }else{
            if ($getFromUsers->checkEmail($email) === true){
                $error='Email is already taken';
            } else{


            $user_id  =    $getFromUsers->create('user',array('nick_name'=>$nickName,'email'=>$email,'password'=>md5($password),'profile_photo'=>'assets/images/profile.png','profile_cover'=>'assets/images/cover.png'));
            $_SESSION['user_id']=$user_id;

            header('Location:includes/signup.php?step=1');
            }
        }

    }

}


?>

<form method="post">
    <div class="signup-div">
        <h3>Sign up </h3>
        <ul>
            <li>
                <input type="text" name="nickName" placeholder="Full Name"/>
            </li>
            <li>
                <input type="email" name="email" placeholder="Email"/>
            </li>
            <li>
                <input type="password" name="password" placeholder="Password"/>
            </li>
            <li>
                <input type="submit" name="signup" Value="Signup for Twitter">
            </li>
        </ul>
        <?php
        if (isset($error)){

            echo '<li class="error-li">
                        <div class="span-fp-error">'.$error.'</div>
                    </li>';
        }

        ?>
    </div>
</form>
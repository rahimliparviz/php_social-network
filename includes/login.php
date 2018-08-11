<?php
if (isset($_POST['login']) && !empty($_POST['login'])){

    $email =$_POST['email'];
    $pass=$_POST['password'];

    if (!empty($_POST['email']) && !empty($_POST['password'])){
        $email=$getFromUsers->checkInput($email);
        $pass=$getFromUsers->checkInput($pass);



        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $error = 'invalid email';
        }else{
                if($getFromUsers->login($email,md5($pass))==false){
                    $error="Email or password  is incorrect";
                }
        }


    }else{
        $error = 'Please fill the fields';
    }
}

?>

<div class="login-div">
    <form method="post">
        <ul>
            <li>
                <input type="text" name="email" placeholder="Please enter your Email here"/>
            </li>
            <li>
                <input type="password" name="password" placeholder="password"/><input type="submit" name="login" value="Log in"/>
            </li>
            <li>
                <input type="checkbox" Value="Remember me">Remember me
            </li>

            <?php
                if (isset($error)){

                    echo '<li class="error-li">
                        <div class="span-fp-error">'.$error.'</div>
                    </li>';
                }

            ?>

        </ul>

    </form>
</div>

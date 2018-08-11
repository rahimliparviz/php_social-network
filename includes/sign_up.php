<?php
    if (isset($_POST['signup'])){

        $nickName= $_POST['nickName'];
        $password= $_POST['password'];
        $email= $_POST['email'];
        $error ='';

        if (!empty($nickName) or !empty($password) or !empty($email));
        $error= 'All fields are required';

    }else{
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
        <!--
         <li class="error-li">
          <div class="span-fp-error"></div>
         </li>
        -->
    </div>
</form>
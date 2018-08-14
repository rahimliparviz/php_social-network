<?php
/**
 * Created by PhpStorm.
 * User: Parviz
 * Date: 23.07.2018
 * Time: 20:41
 */

class User
{

    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

//input check
    public function checkInput($var)
    {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripcslashes($var);

        return $var;
    }

    public function preventAccess($request,$currentFile,$currentlyExecutedFile){
        if ($request == "GET" && $currentFile == $currentlyExecutedFile){
            header('Location:'.BASE_URL.'index.php');
        }

    }


//Login user
    public function login($email, $pass)
    {
        $stmt = $this->pdo->prepare("SELECT `user_id` FROM `user` WHERE `email`= :email AND `password`=:pass");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();

        if ($count > 0) {
            $_SESSION['user_id'] = $user->user_id;
            header('Location:home.php');
        } else {
            return false;
        }
    }

    //register user
    public function register($email, $nickName, $pass)
    {

        $stmt = $this->pdo->prepare("INSERT INTO `user`(`email`,`password`,`nick_name`,`profile_photo`,`profile_cover`) VALUES(:email,:pass,:nick_name,'assets/images/profile.png','assets/images/cover.png')");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);
        $stmt->bindParam(":nick_name", $nickName, PDO::PARAM_STR);

        $stmt->execute();

        $user_id = $this->pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
    }

//Fetch user s data
    public function userData($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `user_id`= :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header('Location:../index.php');

    }

    public function checkEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT `email` FROM `user` WHERE `email`= :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT `username` FROM `user` WHERE `email`= :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function checkPassword($password)
    {
        $stmt = $this->pdo->prepare("SELECT `password` FROM `user` WHERE `password`= :password");
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $array)
    {
        $sql= "delete from `{$table}` ";
        $where=" where ";

        foreach ($array as $name =>$value){
            $sql.="{$where} `{$name}` = :{$name}";
            $where = " and ";

        }

        if($stmt = $this->pdo->prepare($sql)){
            foreach ($array as $key=>$value){
                $stmt->bindValue(':'.$key,$value);
            }


            $stmt->execute();


        }




    }


    public function timeAgo($Dtime)
    {

        $time =strtotime($Dtime);
        $cur =time();
        $seconds= $cur - $time;
        $min= round($seconds/60);
        $hours= round($seconds/3600);
        $months= round($seconds/2600640);

        if ($seconds <= 60){
            if ($seconds == 0){
                return 'now';
            }else{
                return $seconds.'s';
            }
        }else if ($min <= 60){
            return $min.'m';
        }else if ($hours <= 24){
            return $hours.'h';
        }else if ($months <= 12){
            return date('M j',$time);
        }else{
            return date('j M Y',$time);
        }

    }
    
    public function search($search)
    {
        $stmt = $this->pdo->prepare("SELECT `user_id`,`username`,`nick_name`,`profile_photo`,`profile_cover` FROM `user` WHERE `username` LIKE ? or `nick_name` LIKE ?");
        $stmt->bindValue(1, $search.'%', PDO::PARAM_STR);
        $stmt->bindValue(2, $search.'%', PDO::PARAM_STR);
        $stmt->execute();

       
            return $stmt->fetchAll(PDO::FETCH_OBJ);
  
    }

    public function create($table, $fields = array())
    {
        $cols = implode(',', array_keys($fields));
        $vals = ':' . implode(', :', array_keys($fields));
        $sql = "INSERT INTO {$table} ({$cols}) VALUES({$vals})";
        if ($stmt = $this->pdo->prepare($sql)) {

            foreach ($fields as $key => $d) {
                $stmt->bindValue(':' . $key, $d);
            }

            $stmt->execute();


            return $this->pdo->lastInsertId();


        }
    }

    public function update($table, $user_id, $fields = array())
    {
        $cols = '';
        $i = 1;

        foreach ($fields as $name => $value) {
            $cols .= "{$name}=:{$name}";

            if ($i < count($fields)) {
                $cols .= ', ';
            };
            $i++;
        }

        $sql = "UPDATE {$table} SET {$cols} WHERE `user_id`={$user_id}";
        if ($stmt = $this->pdo->prepare($sql)) {
            foreach ($fields as $key => $d) {
                $stmt->bindValue(':' . $key, $d);

            }
            $stmt->execute();

        }
    }

    public function IdByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT `user_id` from `user` WHERE `username` = :username");


        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        return $user->user_id;
    }

    public function loggedIn()
    {
        return (isset($_SESSION['user_id'])) ? true : false;
    }

    public function uploadImage($file)
    {


        $filename = basename($file['name']);
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $error = $file['error'];

        $ext = explode('.', $filename);
        $ext = strtolower(end($ext));

        $allowed_ext = array('jpg', 'png', 'jpeg');

        if (in_array($ext, $allowed_ext) === true) {
            if ($error === 0) {
                if ($fileSize <= 209272152) {
                                $fileRoot='users/'.$filename;
                                move_uploaded_file($fileTmp,$_SERVER['DOCUMENT_ROOT'].'/twitter/'.$fileRoot);
                                return $fileRoot;

                } else {
                    $GLOBALS['imageError'] = "Image size is too large";
                }
            }
        } else {
            $GLOBALS['imageError'] = "The extension is not valid";
        }


        return (isset($_SESSION['user_id'])) ? true : false;
    }
}

?>
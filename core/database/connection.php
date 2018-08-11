<?php

$db_info='mysql:host=localhost;dbname=twitter';
$user='root';
$pass='';

try{
    $pdo =new PDO($db_info,$user,$pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
    echo 'Connection error !' . $e->getMessage();
};

?>

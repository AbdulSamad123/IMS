<?php

try{
    // $pdo = new PDO('mysql:host=localhost;dbname=medicine_ipos','medicine_user','Karachi@123');
    $pdo = new PDO('mysql:host=localhost;dbname=ipos','root','');
}catch(PDOException $error){
    echo $error->getmessage();
}


?>
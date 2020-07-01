<?php

$connection = null;

try{
    //confiq
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "logindanregister";

    //connect
    $database = "mysql:dbname=$dbname;host=$host";
    $connection = new PDO($database, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //if($connection){
      //  echo "Koneksi Berhasil";
    //}else {
      //  echo "koneksi gagal";
    //}

} catch (PDOException $e){
    echo "Error ! " . $e->getMessage();
    die;
}

?>
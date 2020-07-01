<?php

include 'connection.php';

if($_POST){

    //data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $response = []; //data response

    //cek username didalam database
    $userQuery = $connection->prepare("SELECT * FROM logindanregister where username = ?");
    $userQuery->execute(array($username));
    $query = $userquery->fetch();

    if($userQuery->rowCount() == 0){
        $response['status'] = false;
        $response['message'] = "Username Tidak Terdaftar";
    } else {
        //ambil password di database
        $passwordDB = $query['password'];

        if(strcmp(md5($password), $passwordDB) === 0){
            $response['status'] = true;
            $response['message'] = "Login Berhasil";
            $response['data'] = [
                'user_id' => $query['id'],
                'username' => $query['username'],
                'name' => $query['name']
            ];
        } else {
            $response['status'] = false;
            $response['message'] = "Password Anda salah";
        }
    }

    //jadikan data JSON
    $json = json_encode($response, JSON_PRETTY_PRINT);
    //print
    echo $json;
}

?>
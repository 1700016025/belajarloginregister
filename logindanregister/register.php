<?php

include 'connection.php';

if($_POST){

    //POST DATA
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

    $response = [];

    //cek username didalam database
    $userQuery = $connection->prepare("SELECT * FROM logindanregister where username = ?");
    $userQuery->execute(array($username));
    
    //cek username adaatau tidak
    if($userQuery->rowCount() != 0){
        //Beri response
        $response['status'] = false;
        $response['message'] = 'Akun Sudah Digunakan';

    }else{
        $insertAccount = 'INSERT INTO logindanregister (username,password, name) valus (:username, :password, :name)';
        $statement = $connection->prepare($insertAccount);

        try{
            //eksekusi statement db
            $statement->execute([
                ':username' => $username,
                ':password' => md5($password),
                ':name' => $name
            ]);

            // response
            $response['status'] = true;
            $response['message'] = 'Akun Berhasil Didaftar';
            $response['data'] = [
                'username' => $username,
                'name' => $name
            ];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    //berikan data json
    $json = json_encode($response, JSON_PRETTY_PRINT);

    //print
    echo $json;


}
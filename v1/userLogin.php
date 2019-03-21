<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 14/01/2019
 * Time: 13:32
 */
require_once '../includes/DbOperations.php';
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['phone_no']) and isset($_POST['password'])){
        $db = new DbOperations();
        //checking user authentication
        if ($db->userLogin($_POST['phone_no'], $_POST['password'])){
            $user = $db->getUserByPhoneNumber($_POST['phone_no']);
            $response['error'] = false;
            $response['user_id'] = $user['user_id'];
            $response['name'] = $user['name'];
            $response['phone_no'] = $user['phone_no'];
            $response['national_id'] = $user['national_id'];
        }else{
            //wrong username and password
            $response['error'] = true;
            $response['message'] = "Invalid phone number or password";
        }
    }else{
        $response['error'] = true;
        $response['message'] = "User not registered, please try again";
    }
}

echo json_encode($response);
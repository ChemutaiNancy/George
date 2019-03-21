<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 14/01/2019
 * Time: 10:24
 */
require_once '../includes/DbOperations.php';
$response = [];//associative array
if ($_SERVER['REQUEST_METHOD']=='POST'){
        //user has provided all the requirements
        if (
            isset($_POST['name']) and
            isset($_POST['phone_no']) and
            isset($_POST['national_id']) and
            isset($_POST['password'])
        ){
            //operate further
            //create db object
                $db = new DbOperations();
                $result = $db->createUser($_POST['name'],
                                            $_POST['phone_no'],
                                            $_POST['national_id'],
                                            $_POST['password']);
               /*if ( $db->createUser(//passing values from createUser method
                    $_POST['name'],
                    $_POST['phone_no'],
                    $_POST['national_id'],
                    $_POST['password']*/
               if ($result == 1){
                    //user is created
                   $response['error'] = false;
                   $response['message'] = "User registered successfully";
               }elseif ($result == 2){
                   //presence of an error
                    $response['error'] = true;
                    $response['message'] = "User not registered, please try again";
               }elseif ($result == 0){
                   $response['error'] = true;
                   $response['message'] = "You are already registered, please choose a different phone and ID number";
               };

        }else{//user not provided all the requirements
            $response['error'] = true;
            $response['message'] = "All fields are required";
        }

}else{
    $response['error'] = true;
    $response['message'] = "Invalid request";
}
echo json_encode($response);
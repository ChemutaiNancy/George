<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 21/01/2019
 * Time: 12:10
 */
require_once '../includes/DbOperations.php';
$response = [];
if ($_SERVER['REQUEST_METHOD']=='POST'){
    //user has provided all the requirements
    if (
        isset($_POST['route']) and
        isset($_POST['bus_company']) and
        isset($_POST['seat_no']) and
        isset($_POST['travel_date']) and
        isset($_POST['pick_up_location'])
    ){
        //operate further
        //create db object
        $db = new DbOperations();
        $result = $db->insertBookingDetails($_POST['route'],
            $_POST['bus_company'],
            $_POST['seat_no'],
            $_POST['travel_date'],
            $_POST['pick_up_location']);
        /*if ( $db->createUser(//passing values from createUser method
             $_POST['name'],
             $_POST['phone_no'],
             $_POST['national_id'],
             $_POST['password']*/
        if ($result == 4){
            //user is created
            $response['error'] = false;
            $response['message'] = "Booking successful";
        }elseif ($result == 5){
            //presence of an error
            $response['error'] = true;
            $response['message'] = "Booking not successful, please try again";
        }elseif ($result == 3){
            $response['error'] = true;
            $response['message'] = "You are already registered, please choose a different date";
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
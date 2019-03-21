<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 14/01/2019
 * Time: 10:08
 */
class DbOperations{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__).'/DbConnect.php';
        $db = new  DbConnect();
        $this->con=$db->connect();
    }

    //CRUD CREATE

    public function createUser($name, $phone_no, $national_id, $pass){

            if ($this->isUserExists($phone_no, $national_id)){
                return 0;
            }else{//if user does not exist
                $password = md5($pass);
                $stmt = $this->con->prepare("INSERT INTO `users` (`user_id`, `name`, `phone_no`, `national_id`, `password`) 
                  VALUES (NULL, ?, ?, ?, ?);");
                $stmt->bind_param("ssss",$name, $phone_no, $national_id, $password);
                if ($stmt->execute()){
                    /*return true;*/
                    return 1;
                }else{
                    /*return false;*/
                    return 2;
                };
            }
    }

    public function userLogin($phone_no, $pass){
        $password = md5($pass);
        $stmt = $this->con->prepare("SELECT user_id FROM users WHERE phone_no = ? and password = ?");
        $stmt->bind_param("ss", $phone_no,$password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    //fetch data from the db
    public function getUserByPhoneNumber($phone_no){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE phone_no = ?");
        $stmt->bind_param("s",$phone_no);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    private function isUserExists($phone_no, $national_id){//eliminate redundancy in the db
        $stmt = $this->con->prepare("SELECT user_id FROM users WHERE phone_no = ? OR national_id = ?");
        $stmt->bind_param("ss", $phone_no, $national_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;

    }

    public function getDb(){
        return$this->con;
    }

    public function insertBookingDetails($route, $busCompany, $seatNo, $travelDate, $pickUpLocation){

        if ($this->isBookingExists($travelDate)){
            return 3;
        }else{
            $stmt = $this->con->prepare("INSERT INTO `booking_details` (`book_id`, `route`, `bus_company`, `seat_no`, `travel_date`, `pick_up_location`) 
                      VALUES (NULL, ?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss",$route,$busCompany, $seatNo, $travelDate, $pickUpLocation);
            if ($stmt->execute()){
                return 4;
            }else{
                return 5;
            }
        }
    }

    private function isBookingExists( $travel_date){
        $stmt = $this->con->prepare("SELECT book_id FROM booking_details WHERE travel_date = ?");
        $stmt->bind_param("s",$travel_date);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

}
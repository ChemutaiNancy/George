<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 16/01/2019
 * Time: 13:49
 */

$route = array();
class QueryRoute{
    private $tables, $con;

    public function __construct()
    {
        $this->tables = "route";
    }

    public function getRoute(){
        $db = new DbOperations();
        $sql = "SELECT * FROM route";

        $result = mysqli_query($db->getDb(), $sql);

        $rows = mysqli_num_rows($result);

        if ($rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $route[] = $row;
            }
        }
    }
}
echo json_encode($route);
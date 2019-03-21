<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 16/01/2019
 * Time: 13:36
 */
require_once '../includes/DbOperations.php';
require_once '../includes/QueryRoute.php';
$queryRouteObject = new QueryRoute();
$queryRouteObject->getRoute();
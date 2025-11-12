<?php
include("../models/Car.php");
include("../connection/connection.php");
include("../services/ResponseService.php");

function getCars()
{
    global $connection;

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $car = Car::find($connection, $id);
        echo ResponseService::response(200, $car->toArray());
        return;
    } else {
        $cars = Car::findAll($connection);
        $arr = [];
        foreach ($cars as $car) {
            $arr[] = $car->toArray();
        }
        echo ResponseService::response(200, $arr);
        return;
    }
}




?>
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
function deleteCar()
{
    global $connection;

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $car = Car::Deleterow($connection, $id);
        echo ResponseService::response(200, ["message" => "row deleted successfully"]);
        return;
    } else {
        echo ResponseService::response(500, ["message" => "failed to delete row"]);
        return;
    }
}
function newCar()
{
    global $connection;
    if ($_SERVER["REQUEST_METHOD"] != 'POST') {
        echo ResponseService::response(405, "Method Not Allowed");
        exit;
    }
    $data = json_decode(file_get_contents("php://input"), true);
    $car = ["id" => $data['id'], "name" => $data['name'], "color" => $data['color'], "year" => $data['year']];
    $new = new Car($car);
    $insertedId = $new->add($connection, $car);
    if ($insertedId) {
        echo ResponseService::response(200, ["message" => "Car added successfully", "id" => $insertedId]);
    } else {
        echo ResponseService::response(500, ["error" => "Failed to add car"]);
    }
}
function updatecar()
{
    global $connection;
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $newdata = ["name" => $data['name'], "color" => $data['color'], "year" => $data['year']];
    $row = Car::update($connection, $id, $newdata);
    if ($row) {
        echo ResponseService::response(200, ["message" => "row Updated successfully"]);
        return;
    } else {
        echo ResponseService::response(500, ["message" => "failed to update row"]);
        return;
    }
}
updatecar();

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//dołączenie plików
include_once '../config/database.php';
include_once '../objects/product.php';

//dołączenie plików
$database = new Database();
$db = $database->getConnection();

//tworzenie produktu
$product = new Product($db);

//pobranie id edytowanego produktu
$data = json_decode(file_get_contents("php://input"));

//ustawienie pobranego id
$product->id = $data->id;

//ustawienie pozostałych atrybutów
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->categoryId = $data->categoryId;

//akutalizacja produktu
if($product->update())
{
    http_response_code(200);

    echo json_encode(array("message" => "Product was updated."));
}
else
{
    http_response_code(503);

    echo json_encode(array("message" => "Unable to update product."));
}
?>
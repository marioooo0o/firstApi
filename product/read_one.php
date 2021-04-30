<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//dołączenie plików
include_once '../config/database.php';
include_once '../objects/product.php';

//połączenie z bazą 
$database = new Database();
$db = $database->getConnection();

//nowy produkt
$product = new Product($db);

//ustawienie id czytanego rekordu
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

//wczytanie atrybutów produktu
$product->readOne();

if($product->name!=null)
{
    $product_arr = array(
        "id" => $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "categoryId" => $product->categoryId,
        "categoryName" => $product->categoryName
    );

    http_response_code(200);

    echo json_encode($product_arr);
}
else
{
    http_response_code(404);

    echo json_encode(array("message"=> "Product does not exist."));
}
?>
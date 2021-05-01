<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
//dołączenie plików
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';
 
//inicjalizacja bazy
$database = new Database();
$db = $database->getConnection();

//inicjalizacja produktu
$product = new Product($db);

//pobranie z klawiatury
$keywords = isset($_GET["s"])? $_GET["s"] : "";

//zapytanie
$stmt = $product->search($keywords);
$num = $stmt->rowCount();

//jeśli znaleziono rekordy
if($num>0)
{
    $productArr = array();
    $productArr["records"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $productItem = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $categoryId,
            "category_name" => $categoryName
        );

        array_push($productArr["records"], $productItem);  
    }
    http_response_code(200);

    echo json_encode($productArr);
}
else
{
    http_response_code(404);
    echo json_encode(
        array("message"=> "No product found.")
    );
}
?>

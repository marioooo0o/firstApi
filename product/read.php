<?php
/*W tym przypadku nasz read.phpplik może odczytać każdy 
(gwiazdka * oznacza wszystko) i zwróci dane w formacie JSON .*/
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


//dołączenie plików database.php i product.php
include_once '../objects/product.php';
include_once '../config/database.php';

//inicjalizacja bazy danych i obiektu product
$database = new Database();
$db = $database->getConnection();

//inicjalizacja objektów
$product = new Product($db);

//zapytanie bazy o produkty
$stmt = $product->read();
$num = $stmt->rowCount();

//sprawdzenie czy są jakieś rekordy
if($num>0)
{
    $productArr = array();
    $productArr["records"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        //uproszenie z $row['name'] na $name
        extract($row);

        $productItem = array(
            "id" => $id,
            "name" => $name,
            "description"=> html_entity_decode($description),
            "price" => $price,
            "category_id" => $categoryId,
            "categoryName" => $categorName
        );
        array_push($productArr["records"], $productItem);
    }
       http_response_code(200);
       echo json_encode($productArr);
}
else{
    http_response_code(404);

    echo json_encode( 
        array("message" => "No products found.")
    );
}

?>

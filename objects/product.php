<?php

class Product
{

    //połączenie z bazą nazwa tabeli
    private $conn;
    private $table_name = "products";

    //pola składowe
    public $id;
    public $name;
    public $description;
    public $price;
    public $categoryId;
    public $categoryName;
    public $created;

    //konstruktor łączący z bazą 
    public function __construct($db)
    {
        $this->conn = $db;
    }
    //metoda read
    function read()
    {
        $query = "SELECT
                    c.name as cetegory_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                  FROM
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                  ORDER BY
                  p.created DESC";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    
}
?>
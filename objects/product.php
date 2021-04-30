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
    //tworzenie produktu
    function create()
    {
        $query = "INSERT INTO
            " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, categoryId=:categoryId, created=:created";
        //przygotowanie zapytania
        $stmt = $this->conn->prepare($query);
        
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->categoryId=htmlspecialchars(strip_tags($this->categoryId));
        $this->created=htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->categoryId);
        $stmt->bindParam(":created", $this->created);

        //wywołanie
        if($stmt->execute())
        {
            return true;
        }
        else false;
    }
}
?>
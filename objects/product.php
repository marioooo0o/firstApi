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
    function read(){
  
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.categoryId = c.id
                ORDER BY
                    p.created DESC";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // execute query
        $stmt->execute();
      
        return $stmt;
    }
    //tworzenie produktu
    function create()
    {
        $query = "INSERT INTO
            " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
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
    function readOne()
    {
        //zapytanie o pojedyńczy rekord
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM  
                 " .$this->table_name . " p
                 LEFT JOIN
                    categories c
                        ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT
                    0,1";
        
        //przygotowanie zapytania
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        //szukany wiersz
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->categoryId = $row['category_id'];
        $this->categoryName = $row['category_name'];
    }
    function update()
    {
        $query = "UPDATE
                    " . $this->table_name . "
                SET 
                    name = :name,
                    price = :price,
                    description = :description,
                    category_id = :categoryId
                WHERE
                    id = :id";

        //przygotowanie zapytania
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->categoryId=htmlspecialchars(strip_tags($this->categoryId));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->categoryId);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute())
        {
            return true;
        }
        //możliwe że do zmiany
        else false;
    }
}
?>
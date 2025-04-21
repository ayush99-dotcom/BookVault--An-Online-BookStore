<?php
class BookVault {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    //index ma class
    public function getBookVault() {
        $query = "SELECT * FROM book_info";
        $res = $this->conn->query($query);
        return $res;
    }
    public function addBook($bname, $btitle, $price, $desc, $img) {
        $query = "INSERT INTO book_info(`name`, `title`, `price`, `description`, `image`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdss", $bname, $btitle, $price, $desc, $img);
        $res = $stmt->execute();
        return $res;
    }
    public function deleteBook($delete_id) {
        $query = "DELETE FROM book_info WHERE bid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $delete_id);
        $res = $stmt->execute();
        return $res;
    }
}



class Book{
    private $conn;
    public function __construct($conn){
        $this->conn=$conn;
    }
    //index ko class
    public function getBookVault() {
        $query = "SELECT * FROM book_info";
        $res = $this->conn->query($query);
        return $res;
    }
}

class Author{
    private $conn;
    public function __construct($conn){
        $this->conn=$conn;
    }
    public function getAuthor(){
        $query = "SELECT * FROM Author";
        $res=$this->conn->query($query);
        return $res;
    }

    //admin le book add garni class
    public function addBook($bname, $btitle, $price, $desc, $img) {
        $query = "INSERT INTO book_info(`name`, `title`, `price`, `description`, `image`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdss", $bname, $btitle, $price, $desc, $img);
        $res = $stmt->execute();
        return $res;
    }
} 

class Customer {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    //user le book kinni class
    public function purchaseBook($user_id, $conn_oid, $address, $city, $state, $country, $pincode, $cart_books, $quantity, $unit_price, $sub_total) {
        $query = "INSERT INTO `orders`(user_id, id, address, city, state, country, pincode, book, quantity, unit_price, sub_total) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisssssiiii", $user_id, $conn_oid, $address, $city, $state, $country, $pincode, $cart_books, $quantity, $unit_price, $sub_total);
        $res = $stmt->execute();
        return $res;
    }
}


class Order {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    //user le order history herni class 
    public function purchaseHistory($user_id) {
        $query = "SELECT * FROM `confirm_order` WHERE user_id = ? ORDER BY order_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }
    //admin le order history herni class
    public function orderDetails() {
        $query = "SELECT * FROM `confirm_order`ORDER BY `order_id` DESC";
        $res = $this->conn->query($query);
        return $res;
    }

}


?>
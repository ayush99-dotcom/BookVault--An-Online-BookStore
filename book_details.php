<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null; // Ensure user_id exists in session

if (isset($_POST['add_to_cart'])) {
    if(!isset($user_id)){
        $message[]= 'Please Login to get your books';
     }else{
    $book_name = $_POST['book_name'];
    $book_id = $_POST['book_id'];
    $book_image = $_POST['book_image'];
    $book_price = $_POST['book_price'];
    $book_quantity = $_POST['quantity'];
    $total_price =number_format($book_price * $book_quantity);
    $select_book = $conn->query("SELECT * FROM cart WHERE name= '$book_name' AND user_id='$user_id' ") or die('query failed');

    if (mysqli_num_rows($select_book) > 0) {
        $message[] = 'This Book is alredy in your cart';
    } else {
        $conn->query("INSERT INTO cart (`book_id`,`user_id`,`name`, `price`, `image`, `quantity` ,`total`) VALUES('$book_id','$user_id','$book_name','$book_price','$book_image','$book_quantity', '$total_price')") or die('Add to cart Query failed');
        $message[] = 'Book Added To Cart Successfully';
    }
}
    // Redirect to the cart page
    //header("Location: cart.php");
    //exit;
}

// Check if book details are passed
if (isset($_GET['details'])) {
    $get_id = $_GET['details'];
    $get_book = mysqli_query($conn, "SELECT * FROM book_info WHERE bid = '$get_id'") or die('Query failed');

    if (mysqli_num_rows($get_book) > 0) {
        $book = mysqli_fetch_assoc($get_book);
        $book_name = $book['name'];
        $book_author = $book['title'];
        $book_price = $book['price'];
        $book_description = $book['description'];
        $book_genre = isset($book['genre']) ? $book['genre'] : 'Not Available';
        $book_rating = isset($book['rating']) ? $book['rating'] : 'Not Rated';
        $book_image = $book['image'];
    } else {
        die('Book not found!');
    }
}

// Get recommendations based on the same genre as the current book, ordered by highest rating
$recommended_books_genre = mysqli_query($conn, "SELECT * FROM book_info WHERE genre = '$book_genre' AND bid != '$get_id' ORDER BY rating DESC LIMIT 5") or die('Query failed');

// Get recommendations based on highest rating (5 to 0), excluding the current book
$recommended_books_rating = mysqli_query($conn, "SELECT * FROM book_info WHERE bid != '$get_id' ORDER BY rating DESC LIMIT 5") or die('Query failed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index_book.css">
    <title>Selected Products</title>
    <style>
        .message {
  position: sticky;
  top: 0;
  margin: 0 auto;
  width: 61%;
  background-color: #fff;
  padding: 6px 9px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 100;
  gap: 0px;
  border: 2px solid rgb(68, 203, 236);
  border-top-right-radius: 8px;
  border-bottom-left-radius: 8px;
}
.message span {
  font-size: 22px;
  color: rgb(240, 18, 18);
  font-weight: 400;
}
.message i {
  cursor: pointer;
  color: rgb(3, 227, 235);
  font-size: 15px;
}
    </style>
</head>

<body>
    <?php include 'index_header.php'; ?>
        <?php
    if(isset($message)){
      foreach($message as $message){
        echo '
        <div class="message" id= "messages"><span>'.$message.'</span>
        </div>
        ';
      }
    }
    ?>

    <div class="details">
        <?php if (isset($book_name)): ?>
            <div class="row_box">
                <form action="" method="POST" style="display: flex;">
                    <div class="col_box">
                        <img src="./added_books/<?php echo $book_image; ?>" alt="<?php echo $book_name; ?>">
                    </div>
                    <div class="col_box">
                        <h1>Book Name: <?php echo $book_name; ?></h1>
                        <h3>Author: <?php echo $book_author; ?></h3>
                        <h3>Price: Rs. <?php echo $book_price; ?>/-</h3>
                        
                         <!-- Display Genre and Rating -->
                         <h3>Genre: <?php echo $book_genre; ?></h3>
                        <h3>Rating: <?php echo $book_rating; ?> / 5</h3>

                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="10" id="quantity">
                        <div class="buttons">
                            <input type="hidden" name="book_name" value="<?php echo $book_name; ?>">
                            <input type="hidden" name="book_id" value="<?php echo $get_id; ?>">
                            <input type="hidden" name="book_image" value="<?php echo $book_image; ?>">
                            <input type="hidden" name="book_price" value="<?php echo $book_price; ?>">
                            <input type="submit" name="add_to_cart" value="Add To Cart" class="btn">
                        </div>

                        <!-- Display Book Details -->
                        <h3>Book Details:</h3>
                        <p><?php echo $book_description; ?></p>
                    </div>
                </form>
            </div>

            <!-- Display Recommendations Based on Genre, Ordered by Rating -->
            <h3>Recommended Books Based on Genre (<?php echo $book_genre; ?>)</h3>
            <div class="recommended-books">
                <?php if (mysqli_num_rows($recommended_books_genre) > 0): ?>
                    <div class="row_box">
                        <?php while ($fetch_rec_genre = mysqli_fetch_assoc($recommended_books_genre)): ?>
                            <div class="col_box">
                                <img src="./added_books/<?php echo $fetch_rec_genre['image']; ?>" alt="<?php echo $fetch_rec_genre['name']; ?>">
                                <h4><?php echo $fetch_rec_genre['name']; ?></h4>
                                <p><?php echo $fetch_rec_genre['title']; ?></p>
                                <a href="book_details.php?details=<?php echo $fetch_rec_genre['bid']; ?>" class="btn">View Details</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>No recommendations available based on genre.</p>
                <?php endif; ?>
            </div>

            <!-- Display Recommendations Based on Highest Rating -->
            <h3>Recommended Books Based on Highest Rating:</h3>
            <div class="recommended-books">
                <?php if (mysqli_num_rows($recommended_books_rating) > 0): ?>
                    <div class="row_box">
                        <?php while ($fetch_rec_rating = mysqli_fetch_assoc($recommended_books_rating)): ?>
                            <div class="col_box">
                                <img src="./added_books/<?php echo $fetch_rec_rating['image']; ?>" alt="<?php echo $fetch_rec_rating['name']; ?>">
                                <h4><?php echo $fetch_rec_rating['name']; ?></h4>
                                <p><?php echo $fetch_rec_rating['title']; ?></p>
                                <a href="book_details.php?details=<?php echo $fetch_rec_rating['bid']; ?>" class="btn">View Details</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>No recommendations available based on rating.</p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p>Book not found!</p>
        <?php endif; ?>
    </div>
</body>
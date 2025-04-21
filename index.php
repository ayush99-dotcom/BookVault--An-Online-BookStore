<?php
include 'config.php';
include 'userclass.php'; // Include the BookVault class

error_reporting(0);
session_start();

$user_id = $_SESSION['user_id'];

$bookVault = new BookVault($conn); // Instantiate the BookVault class

if (isset($_POST['add_to_cart'])) {
    if (!isset($user_id)) {
        $message[] = 'Please Login to get your books';
    } else {
        $book_name = $_POST['book_name'];
        $book_id = $_POST['book_id'];
        $book_image = $_POST['book_image'];
        $book_price = $_POST['book_price'];
        $book_quantity = '1';

        $total_price = number_format($book_price * $book_quantity);

        $select_book = $conn->query("SELECT * FROM cart WHERE book_id= '$book_id' AND user_id='$user_id' ") or die('query failed');

        if (mysqli_num_rows($select_book) > 0) {
            $message[] = 'This Book is already in your cart';
        } else {
            $conn->query("INSERT INTO cart (`user_id`,`book_id`,`name`, `price`, `image`,`quantity` ,`total`) VALUES('$user_id','$book_id','$book_name','$book_price','$book_image','$book_quantity', '$total_price')") or die('Add to cart Query failed');
            $message[] = 'Book Added To Cart Successfully';
            header('location:index.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/hello.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" />
    <title>Hamro Book Pasal</title>
    <style>
        img {
            border: none;
        }
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
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message" id="messages"><span>' . $message . '</span></div>
            ';
        }
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <section id="New">
        <div class="container px-5 mx-auto">
            <h2 class="m-8 font-extrabold text-4xl text-center border-t-2 " style="color: rgb(0, 167, 245);">
                New Arrived
            </h2>
        </div>
    </section>
    <section class="show-products">
        <div class="box-container">
            <?php
            $new_books = $conn->query("SELECT * FROM `book_info` ORDER BY date DESC LIMIT 4");
            if ($new_books->num_rows > 0) {
                while ($fetch_book = $new_books->fetch_assoc()) {
            ?>
            <div class="box" style="width: 255px; height:355px;">
                <a href="book_details.php?details=<?php echo $fetch_book['bid']; echo '-name=', $fetch_book['name']; ?>">
                    <img style="height: 200px;width: 125px;margin: auto;" class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="">
                </a>
                <div style="text-align:left;">
                    <div style="font-weight: 500; font-size:18px; text-align: center;" class="name"><?php echo $fetch_book['name']; ?></div>
                </div>
                <div class="price">Price: Rs. <?php echo $fetch_book['price']; ?>/-</div>
                <form action="" method="POST">
                    <input class="hidden_input" type="hidden" name="book_name" value="<?php echo $fetch_book['name']; ?>">
                    <input class="hidden_input" type="hidden" name="book_id" value="<?php echo $fetch_book['bid']; ?>">
                    <input class="hidden_input" type="hidden" name="book_image" value="<?php echo $fetch_book['image']; ?>">
                    <input class="hidden_input" type="hidden" name="book_price" value="<?php echo $fetch_book['price']; ?>">
                    <button onclick="myFunction()" name="add_to_cart"><img src="./images/cart2.png" alt="Add to cart"></button>
                    <a href="book_details.php?details=<?php echo $fetch_book['bid']; echo '-name=', $fetch_book['name']; ?>" class="update_btn">Know More</a>
                </form>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>
    </section>
    <section id="all">
        <div class="container px-5 mx-auto">
            <h2 class="m-8 font-extrabold text-4xl text-center border-t-2" style="color: rgb(0, 167, 245);">
                All books
            </h2>
        </div>
    </section>
    <section class="show-products">
        <div class="box-container">
            <?php
            $all_books = $bookVault->getBookVault(); // Use the BookVault method to get all books
            if ($all_books->num_rows > 0) {
                while ($fetch_book = $all_books->fetch_assoc()) {
            ?>
            <div class="box" style="width: 255px; height:355px;">
                <a href="book_details.php?details=<?php echo $fetch_book['bid']; echo '-name=', $fetch_book['name']; ?>">
                    <img style="height: 200px;width: 125px;margin: auto;" class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="">
                </a>
                <div style="text-align:left;">
                    <div style="font-weight: 500; font-size:18px; text-align: center;" class="name"><?php echo $fetch_book['name']; ?></div>
                </div>
                <div class="price">Price: Rs. <?php echo $fetch_book['price']; ?>/-</div>
                <form action="" method="POST">
                    <input class="hidden_input" type="hidden" name="book_name" value="<?php echo $fetch_book['name']; ?>">
                    <input class="hidden_input" type="hidden" name="book_id" value="<?php echo $fetch_book['bid']; ?>">
                    <input class="hidden_input" type="hidden" name="book_image" value="<?php echo $fetch_book['image']; ?>">
                    <input class="hidden_input" type="hidden" name="book_price" value="<?php echo $fetch_book['price']; ?>">
                    <button onclick="myFunction()" name="add_to_cart"><img src="./images/cart2.png" alt="Add to cart"></button>
                    <a href="book_details.php?details=<?php echo $fetch_book['bid']; echo '-name=', $fetch_book['name']; ?>" class="update_btn">Know More</a>
                </form>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>
    </section>
    <hr style="color: black; width:5px;">
    <?php include 'index_footer.php'; ?>
    <script>
        setTimeout(() => {
            const box = document.getElementById('messages');
            box.style.display = 'none';
        }, 8000);
    </script>
</body>
</html>


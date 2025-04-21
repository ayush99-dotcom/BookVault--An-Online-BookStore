<?php
include 'config.php'; 
include 'userclass.php'; // Include the BookVault class

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

$bookVault = new BookVault($conn); // Instantiate the BookVault class

// Add Book logic
if (isset($_POST['add_books'])) {
    $bname = mysqli_real_escape_string($conn, $_POST['bname']);
    $btitle = mysqli_real_escape_string($conn, $_POST['btitle']);
    $price = $_POST['price'];
    $desc = mysqli_real_escape_string($conn, $_POST['bdesc']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $rating = $_POST['rating'];
    $img = $_FILES["image"]["name"];
    $img_temp_name = $_FILES["image"]["tmp_name"];
    $img_file = "./added_books/" . $img;

    // Validate inputs
    if (empty($bname) || empty($btitle) || empty($price) || empty($desc) || empty($genre) || empty($rating) || empty($img)) {
        $message[] = 'All fields are required!';
    } else {
        // Insert the book into the database
        $query = "INSERT INTO `book_info` (name, title, price, description, genre, rating, image) 
                  VALUES ('$bname', '$btitle', '$price', '$desc', '$genre', '$rating', '$img')";
        if (mysqli_query($conn, $query)) {
            // Move the uploaded image to the correct directory
            move_uploaded_file($img_temp_name, $img_file);
            $message[] = 'New Book Added Successfully';
        } else {
            $message[] = 'Failed to Add Book';
        }
    }
}

// Delete Book Logic
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `book_info` WHERE bid = '$delete_id'") or die('query failed');
    header('location:add_books.php');
}

// Update Book logic
if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_title = $_POST['update_title'];
    $update_description = $_POST['update_description'];
    $update_price = $_POST['update_price'];
    $update_genre = $_POST['update_genre'];
    $update_rating = $_POST['update_rating'];

    $query = "UPDATE `book_info` SET name = '$update_name', title = '$update_title', description = '$update_description', price = '$update_price', genre = '$update_genre', rating = '$update_rating' WHERE bid = '$update_p_id'";
    mysqli_query($conn, $query) or die('Query Failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = './added_books/'.$update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image file size is too large';
        } else {
            // Update the image if a new one is uploaded
            mysqli_query($conn, "UPDATE `book_info` SET image = '$update_image' WHERE bid = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            // Delete the old image
            unlink('added_books/'.$update_old_image);
        }
    }

    header('location:add_books.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/register.css">
    <title>Add Books</title>
</head>
<body>
    <?php include './admin_header.php'; ?>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message" id="messages"><span>' . $message . '</span></div>';
        }
    }
    ?>

    <a class="update_btn" style="position: fixed; z-index:100;" href="total_books.php">See All Books</a>

    <div class="container_box">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Add Books</h3>
            <input type="text" name="bname" placeholder="Enter book Name" class="text_field" required>
            <input type="text" name="btitle" placeholder="Enter Author name" class="text_field" required>
            <input type="number" min="0" name="price" class="text_field" placeholder="Enter product price" required>
            <textarea name="bdesc" placeholder="Enter book description" class="text_field" cols="18" rows="5" required></textarea>
            <input type="text" name="genre" placeholder="Enter book genre" class="text_field" required>
            <input type="number" name="rating" placeholder="Enter admin rating (1-5)" class="text_field" step="0.1" min="0" max="5" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="text_field" required>
            <input type="submit" value="Add Book" name="add_books" class="btn text_field">
        </form>
    </div>

    <section class="edit-product-form">
    <?php
    if (isset($_GET['update'])) {
        $update_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * FROM `book_info` WHERE bid = '$update_id'") or die('query failed');
        if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['bid']; ?>">
        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
        <img src="./added_books/<?php echo $fetch_update['image']; ?>" alt="">
        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter Book Name">
        <input type="text" name="update_title" value="<?php echo $fetch_update['title']; ?>" class="box" required placeholder="Enter Author Name">
        <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" required placeholder="Enter Book Description">
        <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter Product Price">
        <input type="text" name="update_genre" value="<?php echo $fetch_update['genre']; ?>" class="box" required placeholder="Enter Book Genre">
        <input type="number" name="update_rating" value="<?php echo $fetch_update['rating']; ?>" step="0.1" min="0" max="5" class="box" required placeholder="Enter Admin Rating (1-5)">
        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="Update" name="update_product" class="delete_btn">
        <input type="reset" value="Cancel" id="close-update" class="update_btn">
    </form>
    <?php
            }
        }
    } else {
        echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
    }
    ?>
    </section>

    <script src="./js/admin.js"></script>
    <script>
        setTimeout(() => {
            const box = document.getElementById('messages');
            box.style.display = 'none';
        }, 8000);
    </script>
</body>
</html>
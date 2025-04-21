<?php
// Start the session and connect to the database
include 'config.php';  // Include your database connection
include 'userclass.php'; // Include BookVault class (if needed)

session_start();

// Capture the genre from the URL query string (e.g., genre.php?type=romantic)
if (isset($_GET['type'])) {
    $genre = mysqli_real_escape_string($conn, $_GET['type']);
} else {
    // Default to 'all' or a general message if no genre is selected
    $genre = 'all';
}

// Get the list of books based on the genre
$query = "SELECT * FROM `book_info`";
if ($genre !== 'all') {
    $query .= " WHERE genre = '$genre'";
}
$query .= " ORDER BY rating DESC"; // Sort books by rating (optional)

$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/hello.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Genre - Book Recommendations</title>
    <style>
        /* Custom styling */
        .genre-books {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }
        .book-item {
            width: 200px;
            margin: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .book-image {
            width: 150px;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .book-item h3 {
            font-size: 18px;
            font-weight: bold;
        }
        .book-item p {
            font-size: 14px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        header a, footer a {
            text-decoration: none;
            color: inherit; /* Optional: Ensures the link color matches the text */
        }
    </style>
</head>
<body>
    <!-- Include the header/menu from the other page -->
    <?php include 'index_header.php'; ?>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message" id="messages"><span>' . $msg . '</span></div>';
        }
    }
    ?>

    <!-- Display genre title -->
    <section class="genre-section">
        <div class="container">
            <h2 class="text-center my-5" style="font-size: 2rem; font-weight: bold; color: grey;">
                Books in the "<?php echo ucfirst($genre); ?>" Genre
            </h2>
            <div class="genre-books">
                <?php
                // Check if any books are found
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display each book's details
                        echo '<div class="book-item">';
                        echo '<img src="added_books/' . $row['image'] . '" alt="' . $row['name'] . '" class="book-image">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<p>Author: ' . $row['title'] . '</p>';
                        echo '<p>Price: Rs. ' . $row['price'] . '/-</p>';
                        echo '<p>Rating: ' . $row['rating'] . '/5</p>';
                        echo '<a href="book_details.php?details=' . $row['bid'] . '" class="btn">View Details</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">No books found in this genre.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer or additional content -->
    <?php include 'index_footer.php'; ?>
</body>
</html>



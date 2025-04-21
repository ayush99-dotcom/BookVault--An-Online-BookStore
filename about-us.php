<?php
    include 'config.php';

    session_start();

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>About-Us</title>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/hello.css">
  <style>

        
      
        body {
            
            line-height: 1.6;
          
            
            margin: 0 auto;
        }
        
        h1 {
            color: #1C92C5;
            
        }

        h2{
          padding:0px 70px 0px 70px;
        }

         .des{
          padding:0px 70px 0px 70px;
        }

        .quote{
          /* padding:0px 70px 0px 70px;  */
          text-align: center;
        }

        p {
            text-align: justify;
            
            padding:0px 70px 0px 70px;
        }

        .quote {
            font-style: italic;
            color: #777;
        }

    </style>
</head>

<body>

  <?php
  include 'index_header.php';
  ?>
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
  <div class="contact-section" >

    <h1>About Us</h1>
    <section id="about">
            <h2>Our Story</h2>
            <p>Welcome to Hamro Book Pasal, your one-stop destination for all your book needs. Established in 2024, we are dedicated to providing our customers with a wide range of books, from classics to contemporary bestsellers, across various genres including fiction, non-fiction, children's books, and more.</p>
            <p>Our mission is to promote lifelong learning by offering high-quality books at affordable prices. We believe in the power of books to inspire, educate, and entertain people of all ages.</p>
        </section>

        <section id="mission">
            <h2>Our Mission</h2>
            <p>At Hamro Book Pasal, our mission is to:</p>
            <ol class="des">

                <li>Provide a wide selection of high-quality books.</li>
                <li>Promote lifelong learning.</li>
                <li>Offer exceptional customer service.</li>
                <li>Support local authors and publishers.</li>
            </ol>
        </section>
        <section id="quote">
            <blockquote class="quote">"Books are a uniquely portable magic." - Stephen King</blockquote>
        </section>
    
  </div>

<?php include'index_footer.php';?>


</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hamro Book Pasal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #1C92C5;
        }

        p {
            text-align: justify;
        }

        .quote {
            font-style: italic;
            color: #777;
        }

        .team-member {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .team-member img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .team-member .info {
            flex: 1;
        }

        .team-member .info h3 {
            margin-top: 0;
            color: #1C92C5;
        }

        .team-member .info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>About Us - Hamro Book Pasal</h1>
        <hr>
    </header>
    <main>
        <section id="about">
            <h2>Our Story</h2>
            <p>Welcome to hamro Book Pasal, your one-stop destination for all your book needs. Established in 2024, we are dedicated to providing our customers with a wide range of books, from classics to contemporary bestsellers, across various genres including fiction, non-fiction, children's books, and more.</p>
            <p>Our mission is to promote lifelong learning by offering high-quality books at affordable prices. We believe in the power of books to inspire, educate, and entertain people of all ages.</p>
        </section>
        <section id="team">
            <h2>Our Team</h2>
            <div class="team-member">
                <img src="team-member1.jpg" alt="Team Member 1">
                <div class="info">
                    <h3>John Doe</h3>
                    <p>Founder & CEO</p>
                    <p>John is passionate about books and has been in the book retail business for over 20 years. He oversees the overall operations and ensures that Hamro Book Pasal continues to deliver excellent customer service.</p>
                </div>
            </div>
            <div class="team-member">
                <img src="team-member2.jpg" alt="Team Member 2">
                <div class="info">
                    <h3>Jane Smith</h3>
                    <p>Customer Relations Manager</p>
                    <p>Jane is committed to providing a pleasant and seamless shopping experience for our customers. She ensures that all inquiries and concerns are addressed promptly.</p>
                </div>
            </div>
            <div class="team-member">
                <img src="team-member3.jpg" alt="Team Member 3">
                <div class="info">
                    <h3>Michael Johnson</h3>
                    <p>Marketing & Sales Manager</p>
                    <p>Michael develops and executes marketing strategies to promote our books and engage with book lovers through social media and community events.</p>
                </div>
            </div>
        </section>
        <section id="mission">
            <h2>Our Mission</h2>
            <p>At Hamro Book Pasal, our mission is to:</p>
            <ul>
                <li>Provide a wide selection of high-quality books.</li>
                <li>Promote lifelong learning.</li>
                <li>Offer exceptional customer service.</li>
                <li>Support local authors and publishers.</li>
            </ul>
        </section>
        <section id="quote">
            <blockquote class="quote">"Books are a uniquely portable magic." - Stephen King</blockquote>
        </section>
    </main>
    <footer>
        <hr>
        <p>&copy; 2024 Hamro Book Pasal. All rights reserved.</p>
    </footer>
</body>
</html> -->

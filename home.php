<?php

include 'config.php';

session_start();

$user_id = $_SESSION['Customer_ID'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `shopping_cart` WHERE product_name = '$product_name' AND Customer_ID  = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `shopping_cart`(Customer_ID , Quantity,Price, Image_URL,product_name) VALUES('$user_id','$product_quantity','$product_price', '$product_image','$product_name')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3> Welcome to the realm of knowledge.</h3>
      <p>UIU BOOK SHOP is the best place for availing books and study materials.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `book` ") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['Book_Image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['Book_Title']; ?></div>
      <div class="price">TK.<?php echo $fetch_products['Book_Price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['Book_Title']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['Book_Price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['Book_Image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

<?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `academic_book` ") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['ac_Book_Image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['ac_Book_Title']; ?></div>
      <div class="price">TK.<?php echo $fetch_products['ac_Book_Price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['ac_Book_Title']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['ac_Book_Price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['ac_Book_Image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>






   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/new.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>UIU Book Shop stands out as the premier destination for acquiring top-notch books and essential study materials. Renowned for its exceptional collection, UIU Book Shop is the go-to choice for students and avid readers, offering a diverse range of resources to enhance the learning experience</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Feel free to reach out if you have any questions! At UIU Book Shop, our knowledgeable staff is here to assist you in finding the perfect books and study materials</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
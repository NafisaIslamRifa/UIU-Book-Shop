<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['Admin_ID'];

if (!isset($admin_id)) {
   header('location: login.php');
   exit; // Ensure to exit after a redirect
}

if (isset($_POST['add_product'])) {

   $book_id = $_POST['book_id'];

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $department = $_POST['Category'];

   $book_date = $_POST['book_date'];
   $author_id = $_POST['Author_id'];

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT ac_Book_Title FROM `academic_book` WHERE ac_Book_Title = '$name'") or die('query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'Product name already added';
   } else {
      $add_product_query = mysqli_query($conn, "INSERT INTO academic_book (ac_Book_Title, ac_Publication_Year, ac_Book_Price, Department, Author_Id, ac_Book_Image, ac_book_id) VALUES ('$name', '$book_date', '$price', '$department', '$author_id', '$image', '$book_id')") or $message[] = 'ERROR';
      if ($add_product_query) {
         if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         }
      } else {
         $message[] = 'Product could not be added!';
      }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT ac_Book_Image FROM `academic_book` WHERE ac_book_id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/' . $fetch_delete_image['ac_Book_Image']);
   mysqli_query($conn, "DELETE FROM `academic_book` WHERE ac_book_id = '$delete_id'") or die('query failed');
   header('location: admin_academic_book.php');
   
}

if (isset($_POST['update_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `academic_book` SET ac_Book_Title = '$update_name', ac_Book_Price = '$update_price' WHERE ac_book_id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/' . $update_image;
   $update_old_image = $_POST['update_old_image'];

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'Image file size is too large';
      } else {
         mysqli_query($conn, "UPDATE `academic_book` SET ac_Book_Image = '$update_image' WHERE ac_book_id  = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/' . $update_old_image);
      }
   }

   header('location: admin_academic_book.php');
   exit; // Ensure to exit after a redirect
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <!-- Product CRUD section starts  -->

   <section class="add-products">
      <h1 class="title">ADD ACADEMIC BOOK</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <!-- Add Product Section -->
         <h3>Add Product</h3>

         <!-- Book ID -->
         <input type="text" name="book_id" class="box" placeholder="Enter Book ID" required>

         <!-- Book Name -->
         <input type="text" name="name" class="box" placeholder="Enter Book Name" required>

         <!-- Book Price -->
         <input type="number" min="0" name="price" class="box" placeholder="Enter Book Price" required>

         <!-- Category Dropdown -->
         <div style="text-align: left;">
    <label style="font-size: 20px; display: inline-block; margin-right: 10px;">DEPARTMENT</label>

    <label for="CSE" style="font-size: 18px;">
        <input type="radio" id="CSE" name="Category" value="CSE" style="margin-right: 5px;">
        CSE
    </label>

    <label for="EEE" style="font-size: 18px;">
        <input type="radio" id="EEE" name="Category" value="EEE" style="margin-right: 5px;">
        EEE
    </label>

    <label for="BBA" style="font-size: 18px;">
        <input type="radio" id="BBA" name="Category" value="BBA" style="margin-right: 5px;">
        BBA
    </label>
</div>


         <!-- Book Publication Year -->
         <input type="date" min="0" name="book_date" class="box" placeholder="Enter Book Publication Year" required>

         <!-- Author ID -->
         <input type="text" name="Author_id" class="box" placeholder="Enter Author ID" required>

         <!-- Book Image -->
         <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>

         <!-- Submit Button -->
         <input type="submit" value="Add Product" name="add_product" class="btn">
      </form>
   </section>

   <!-- Product CRUD section ends -->

   <!-- Show products  -->

   <section class="show-products">

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `academic_book`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <div class="box">
                  <img src="uploaded_img/<?php echo $fetch_products['ac_Book_Image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['ac_Book_Title']; ?></div>
                  <div class="price">TK.<?php echo $fetch_products['ac_Book_Price']; ?></div>
                  <div class="name">DEP: <?php echo $fetch_products['Department']; ?></div>

                  <a href="admin_academic_book.php?update=<?php echo $fetch_products['ac_book_id']; ?>" class="option-btn">update</a>
                  <a href="admin_academic_book.php?delete=<?php echo $fetch_products['ac_book_id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">delete</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No products added yet!</p>';
         }
         ?>
      </div>

   </section>

   <section class="edit-product-form">

      <?php
      if (isset($_GET['update'])) {
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `academic_book` WHERE ac_book_id= '$update_id'") or die('query failed');
         if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
      ?>
                  <form action="" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['ac_book_id']; ?>">
                     <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['ac_Book_Image']; ?>">
                     <img src="uploaded_img/<?php echo $fetch_update['ac_Book_Image']; ?>" alt="">
                     <input type="text" name="update_name" value="<?php echo $fetch_update['ac_Book_Title']; ?>" class="box" required placeholder="Enter product name">
                     <input type="number" name="update_price" value="<?php echo $fetch_update['ac_Book_Price']; ?>" min="0" class="box" required placeholder="Enter product price">
                     <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                     <input type="submit" value="Update" name="update_product" class="btn">
                     <input type="reset" value="Cancel" id="close-update" class="option-btn">
                  </form>
      <?php
            }
         }
      } else {
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
      ?>

   </section>

   <!-- Custom admin JS file link -->
   <script src="js/admin_script.js"></script>

</body>

</html>

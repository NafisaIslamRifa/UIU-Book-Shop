<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p><a href="login.php">LOGIN</a> | <a href="register.php">REGISTER</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
          <a href="home.php" class="logo">UIU BOOK SHOP</a> 
          

          <nav class="navbar">
    <div class="links">
        <a href="home.php">HOME</a>
        <a href="about.php">ABOUT</a>
        <a href="shop.php">SHOP</a>
        <a href="contact.php">CONTACT</a>
        <a href="orders.php">ORDERS</a>
        <a href="authors.php">AUTHORS</a>
       
    </div>
    <div class="dropdown">
        <!-- <button class="dropbtn">ACADEMIC</button> -->
        <button class="dropbtn" style="font-size: 20px;">ACADEMIC</button>

        <div class="dropdown-content">
            <a href="cse.php">CSE</a>
            <a href="eee.php">EEE</a>
            <a href="bba.php">BBA</a>
        </div>
    </div>
</nav>


         




         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `shopping_cart` WHERE Customer_ID = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>username : <span><?php echo $_SESSION['Customer_Name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['Customer_Email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
         </div>
      </div>
   </div>

</header>
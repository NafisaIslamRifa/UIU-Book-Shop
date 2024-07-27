<?php
include 'config.php';

session_start();

$user_id = $_SESSION['Customer_ID'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['author_search'])) {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);  // assuming 'name' is the Author_Name in the form
    $select_users = mysqli_query($conn, "SELECT * FROM `author` WHERE Author_Name = '$name' ") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);
        $_SESSION['Author_Id'] = $row['Author_Id'];
         header('location:author_details.php');
       
        
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>AUTHORS</h3>
        <p> <a href="home.php"></a> </p>
    </div>

    <section class="about">

        <div class="flex">

        </div>

    </section>

    <section class="products">

        <h1 class="title">AUTHORS</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `author` ") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="Author_Id "><?php echo $fetch_products['Author_Id']; ?></div>
                        <div class="name"><?php echo $fetch_products['Author_Name']; ?></div>

                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['Author_Name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['Biography']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="hidden" name="author_id" value="<?php echo $fetch_products['Author_Id']; ?>">
                        <input type="submit" value="View details" name="author_search" class="btn">
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">No authors added yet!</p>';
            }
            ?>
        </div>

    </section>

    <section class="about">
        <?php include 'footer.php'; ?>
        <!-- custom js file link  -->
        <script src="js/script.js"></script>
    </section>

</body>

</html>

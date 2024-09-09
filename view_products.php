<?php
include 'components/connection.php';
session_start();


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

?>
<style type="text/css">
<?php include 'style.css'; ?>	
</style>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Coffee - Shop Page</title>
</head>
<body>

  
    <?php include 'components/header.php'; ?>
    
    <div class="main">

        <div class="banner">
            <h1>Shop</h1>
        </div>

        <div class="title2">
            <a href="home.php">home</a><span>/our shop</span>
        </div>

        <section class="products">
            <div class="box-container">
                <?php
               
                $select_products = $conn->prepare("SELECT * FROM products");
                $select_products->execute();
                
                
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        
                        // Check if the image exists
                        $image_path = 'image/fetch_products' . $fetch_products['image'];
                        if (file_exists($image_path)) {
                            $image_src = $image_path;
                        } else {
                            $image_src = 'img/default.png'; 
                        }

                ?>

                <!-- Product Box -->
                <form action="" method="post" class="box">
                    <img src="<?=$image_src; ?>" alt="<?=$fetch_products['name']; ?>" class="image">
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?=$fetch_products['id']; ?>" class="bx bxs-show"></a>
                    </div>
                    <h3 class="name"><?=$fetch_products['name']; ?></h3>
                    <input type="hidden" name="product_id" value="<?=$fetch_products['id']; ?>">
                    <div class="fles">
                        <p class="price">Price: $<?=$fetch_products['price']; ?>/-</p>
                        <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?=$fetch_products['id']; ?>" class="btn">Buy Now</a>
                </form>

                <?php
                    }
                } else {
                  
                    echo '<p class="empty">No products added yet</p>';
                }
                ?>
            </div>
        </section>

        <!-- Include the footer -->
        <?php include 'components/footer.php'; ?>
    </div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
    
</body>
</html>
<?php
header("content-type:text/html; charset=UTF-8");
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn Hàng</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>your orders</h3>
   <p> <a href="home.php">Trang Chủ</a> / Đơn Hàng </p>
</div>

<section class="placed-orders">

   <h1 class="title">Đơn hàng của bạn</h1>

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> Ngày lập đơn: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Tên: <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Số điện thoại: <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Email: <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Địa chỉ: <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Phương thức thanh toán: <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> Tác phẩm: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Tổng tiền: <span><?php echo $fetch_orders['total_price']; ?>K VNĐ/-</span> </p>
         <p> Trạng thái thanh toán: <span style="color:<?php if($fetch_orders['payment_status'] == 'Chưa hoàn thành'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         <!-- các phần tử thông tin đơn hàng -->
         <?php
            if($fetch_orders['payment_status'] == 'Chưa hoàn thành') {
         ?>
            <a href="orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Hủy đơn hàng này?');" class="delete-btn">Hủy đơn</a>
         <?php
            }
         ?>    
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">Chưa có đơn hàng nào!</p>';
      }
      ?>
   </div>

</section>



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>


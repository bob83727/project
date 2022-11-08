<?php

require_once("../housetunedbconnect.php");

if (!isset($_GET["id"])) {
    echo "訂單不存在";
    exit;
}

$id = $_GET["id"];

$sql = "SELECT order_detail.*, user.account, product.price, order_list.price AS totalprice, product.name AS product_name FROM order_detail
JOIN user on order_detail.user_id = user.id
JOIN product on order_detail.product_id = product.id
JOIN order_list on order_detail.order_list_id = order_list.id

WHERE order_detail.order_list_id=$id";

// $sql = "SELECT user_order.*, users.account, product.price, product.name AS product_name FROM user_order
// JOIN users ON user_order.user_id = users.id
// JOIN product ON user_order.product_id = product.id
// WHERE user_order.id=$id
// ORDER BY user_order.id DESC
// "; 

$result = $conn->query($sql);
$productCount=$result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);


?>
<!doctype html>
<html lang="en">

<head>
    <title>Order Detail</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-info" href="order-list.php">Back</a>
        </div>
        
        <table class="table table-bordered">
            <?php foreach($rows as $row): ?>
            <tr>
                <th>id</th>
                <td><?= $row["id"] ?></td>
            </tr>
            <tr>
                <th>訂單id</th>
                <td><?= $row["order_list_id"] ?></td>
            </tr>
            <tr>
                <th>訂購者</th>
                <td><?= $row["account"] ?></td>
            </tr>
            <tr>
                <th>商品</th>
                <td><?= $row["product_name"] ?></td>
            </tr>
            <tr>
                <th>單價</th>
                <td><?= $row["price"] ?></td>
            </tr>
            <tr>
                <th>數量</th>
                <td><?= $row["amount"] ?></td>
            </tr>
            <tr>
                <th>單品總價</th>
                <td><?= $row["price"] * $row["amount"] ?></td>
            </tr>
            <?php endforeach ;?> 
        </table>
        
        <p>訂單總價=<?=$row["totalprice"]?></p>  
    </div>
</body>

</html>
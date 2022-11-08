<?php

require_once("../housetunedbconnect.php");


$whereClause = "";

if (isset($_GET["date"])) {
    $date = $_GET["date"];
    $whereClause = "WHERE order_list.order_date ='$date'";
}

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
    $whereClause = "WHERE order_list.user_id = '$user_id'";
}
if (isset($_GET["price"])) {
    $price = $_GET["price"];
    $whereClause = "WHERE order_list.price ='$price'";
}
if (isset($_GET["startDate"])) {
    $start = $_GET["startDate"];
    $end = $_GET["endDate"];
    $whereClause = "WHERE order_list.order_date BETWEEN '$start' AND '$end'";
}

$sql = "SELECT order_list.*, user.account FROM order_list
JOIN user ON order_list.user_id = user.id
$whereClause
ORDER BY order_list.id DESC
";




$result = $conn->query($sql);
$productCount = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);




?>
<!doctype html>
<html lang="en">

<head>
    <title>Order LIst</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   

</head>

<body>
    <div class="container">
    <?php if (isset($_GET["date"]) || isset($_GET["price"]) || isset($_GET["user_id"]) || isset($_GET["startDate"])) : ?>
            <div class="p-2">
                <a class="btn btn-info" href="order-list.php">至訂單列表</a>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET["user_id"])): ?>
        <a class="btn btn-info" href="user-detail.php?id=<?=$_GET["user_id"]?>">至會員詳細資訊</a>
        <?php endif ;?>
        <div class="py-2">
            <form action="">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <input type="date" class="form-control" name="startDate" value="<?php if (isset($_GET["startDate"])) echo $_GET["startDate"]; ?>">
                    </div>
                    <div class="col-auto">
                        to
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="endDate" value="<?php if (isset($_GET["endDate"])) echo $_GET["endDate"]; ?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-info">確定</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>訂購日期</th>
                        <th>訂購者</th>
                        <th>訂購總價</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $data) : ?>
                        <tr>
                            <td><a class="text-black-50" href="order-list-detail.php?id=<?= $data["id"] ?>"><?= $data["id"] ?></a>
                            </td>
                            <td>
                                <a class="text-black-50" href="order-list.php?date=<?= $data["order_date"] ?>"><?= $data["order_date"] ?></a>
                            </td>
                            <td>
                                <a href="order-list.php?user_id=<?= $data["user_id"] ?>"><?= $data["account"] ?></a>
                            </td>
                            <td>
                                <a class="text-black-50 text-decoration-none" href=""><?= $data["price"] ?></a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php

require_once("../housetunedbconnect.php");

if(isset($_GET["page"])){
    $page=$_GET["page"];
}else{
    $page=1;
}
$perPage=5;
$page_start=($page-1)*$perPage;


$whereClause = "";

if (isset($_GET["user_id1"]) && $_GET["user_id1"]!=="") {
    $user_id1 = $_GET["user_id1"];
    $whereClause = "WHERE order_list.user_id = '$user_id1'";
}
if (isset($_GET["user_id"]) && $_GET["user_id"]!=="") {
    $user_id = $_GET["user_id"];
    $whereClause = "WHERE order_list.user_id = '$user_id'";
}
if (isset($_GET["startDate"]) && $_GET["startDate"]!=="") {
    $start = $_GET["startDate"];
    $end = $_GET["endDate"];
    $whereClause = "WHERE order_list.order_date BETWEEN '$start' AND '$end'";
}

$sql = "SELECT order_list.*, user.account FROM order_list
JOIN user ON order_list.user_id = user.id
$whereClause
ORDER BY order_list.id DESC
";
$sql1= "SELECT order_list.*, user.account FROM order_list
JOIN user ON order_list.user_id = user.id
$whereClause
ORDER BY order_list.id DESC LIMIT $page_start, $perPage
";


$result = $conn->query($sql);
$productCount = $result->num_rows;
$totalPage=ceil($productCount/$perPage);
$result1 = $conn->query($sql1);

$rows = $result1->fetch_all(MYSQLI_ASSOC);




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

<div class="container">
<?php if(!isset($_GET["user_id"]) && !isset($_GET["user_id1"]) || $_GET["user_id1"]=="" && $_GET["user_id"]==""): ?>
<h2 class="text-center p-2">Housetune訂單管理</h2>
<?php elseif(count($rows)!=0): ?>
<h2 class="text-center p-2"><?=$rows[0]["account"]?>的所有訂單</h2>
<?php else: ?>
<h2 class="text-center p-2">該用戶尚未有任何訂單</h2>
<?php endif; ?>
    <?php if (isset($_GET["startDate"]) && $_GET["startDate"]!=="" || isset($_GET["user_id"]) && $_GET["user_id"]!=="") : ?>
        <div class="p-2">
            <a class="btn btn-info" href="order-list.php">至訂單列表</a>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["user_id1"]) && $_GET["user_id1"]!=="") : ?>
        <a class="btn btn-info" href="user-detail.php?id=<?= $_GET["user_id1"] ?>">至會員詳細資訊</a>
    <?php endif; ?>
    <div class="py-2">
        <?php if (!isset($_GET["user_id1"]) || $_GET["user_id1"]=="" && $_GET["user_id"]=="" ) : ?>
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
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>訂購日期</th>
                    <th>訂購者</th>
                    <th>訂單狀態</th>
                    <th>訂購總價</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $data) : ?>
                    <tr>
                        <td><a class="text-black-50" href="order-list-detail.php?id=<?=$data["id"]?>"><?= $data["id"] ?></a>
                        </td>
                        <td>
                            <a class="text-black-50 text-decoration-none" href=""><?= $data["order_date"] ?></a>
                        </td>
                        <td>
                            <a class="text-black-50" href="order-list.php?user_id=<?= $data["user_id"] ?>&user_id1="><?= $data["account"] ?></a>
                        </td>
                        <td>
                            <a class="text-black-50 text-decoration-none" href=""><?php if($data["valid"]==1){
                        echo "待支付" ;}else if($data["valid"]==2){echo "已支付" ;}else if($data["valid"]==3){echo "待出貨" ;}else{echo "已出貨" ;}?></a>
                        </td>
                        <td>
                            <a class="text-black-50 text-decoration-none" href=""><?= $data["price"] ?></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for($i=1; $i<=$totalPage; $i++):?>
                <li class="page-item <?php if($i==$page)echo "active";?>"><a class="page-link"
                        href="order-list.php?page=<?=$i?>&startDate=<?php if(isset($start)) echo"$start";?>&endDate=<?php if(isset($end)) echo"$end"?>&user_id=<?php if(isset($user_id)) echo"$user_id"?>&user_id1=<?php if(isset($user_id1)) echo"$user_id1"?>"><?=$i?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>
</body>


</html>
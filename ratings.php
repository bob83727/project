<?php
require_once("../housetunedbconnect.php");
if(isset($_GET["page"])){
    $page=$_GET["page"];
}else{
    $page=1;
}
$perPage=5;
$page_start=($page-1)*$perPage;

if(isset($_GET["user_id"]) && $_GET["user_id"]!==""){
    $id=$_GET["user_id"];
    $sql= "SELECT rating.*, product.name, user.account FROM rating
    JOIN product ON rating.product_id = product.id
    JOIN user ON rating.user_id = user.id
    WHERE rating.user_id='$id' ";
}else if(isset($_GET["startdate"]) && $_GET["startdate"]!==""){
    $date1=$_GET["startdate"];
    if(isset($_GET["enddate"]) && $_GET["enddate"]!==""){
    $date2=$_GET["enddate"];
    $sql= "SELECT rating.*, product.name, user.account FROM rating
    JOIN product ON rating.product_id = product.id
    JOIN user ON rating.user_id = user.id
    WHERE rating.posted_at >= '$date1' AND rating.posted_at<= '$date2' ORDER BY rating.posted_at DESC ";
    }else{
        $sql= "SELECT rating.*, product.name, user.account FROM rating
        JOIN product ON rating.product_id = product.id
        JOIN user ON rating.user_id = user.id
        WHERE rating.posted_at >= '$date1' ORDER BY rating.posted_at DESC ";
    }
}else if(isset($_GET["enddate"]) && $_GET["enddate"]!==""){
    $date2=$_GET["enddate"];
    $sql= "SELECT rating.*, product.name, user.account FROM rating
    JOIN product ON rating.product_id = product.id
    JOIN user ON rating.user_id = user.id
    WHERE rating.posted_at <= '$date2' ORDER BY rating.posted_at DESC ";
}else if(isset($_GET["score"])&& $_GET["score"]!==""){
    $score=$_GET["score"];
    $sql= "SELECT rating.*, product.name, user.account FROM rating
    JOIN product ON rating.product_id = product.id
    JOIN user ON rating.user_id = user.id
    WHERE rating.stars='$score' ORDER BY rating.posted_at DESC";
}
else{
    $sql= "SELECT rating.*, product.name, user.account FROM rating
JOIN product ON rating.product_id = product.id
JOIN user ON rating.user_id = user.id";
}

$result = $conn->query($sql);
$ratingCount=$result->num_rows;
$sql1=" $sql LIMIT $page_start, $perPage";
$result1 = $conn->query($sql1) ;
$rows = $result1->fetch_all(MYSQLI_ASSOC);
$totalPage=ceil($ratingCount/$perPage);

?>
<!doctype html>
<html lang="en">

<head>
    <title>評價列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="/fontawesome-free-6.2.0-web/css/all.min.css" rel="stylesheet">
    <style>
    .input-group {
        width: 60%;
        margin: 40px auto 0;
    }
    </style>

</head>

<body>
    <div class="container">
        <div class="py-2">
            <?php if(isset($_GET["user_id"]) && $_GET["user_id"]!==""): ?>
            <?php if(count($rows)!=0): ?>
            <h2 class="text-center">會員<?=$rows[0]["account"]?>的所有評價</h2>
            <?php else: ?>
            <h2 class="text-center">該會員尚未新增任何評價</h2>
            <?php endif; ?>
            <?php endif; ?>
            <?php if($_GET["user_id"]==""): ?>
            <h2 class="text-center">Housetune商品評價列表</h2>
            <form action="ratings.php" method="get">
                <div class="input-group">
                    <h6 class="d-flex align-items-center mx-2">依發布日期篩選</h6>
                    <input type="date" class="form-control" name="startdate"
                        value="<?php if(isset($date1)) echo"$date1";?>">
                    <h6 class="d-flex align-items-center mx-2">~</h6>
                    <input type="date" class="form-control" name="enddate"
                        value="<?php if(isset($date2)) echo"$date2";?>">
                    <select name="score" id="" class="ms-2">
                        <option value="">依評分篩選</option>
                        <option value="5" <?php if(isset($score) && $score=="5") echo"selected"?>>5星</option>
                        <option value="4" <?php if(isset($score) && $score=="4") echo"selected"?>>4星</option>
                        <option value="3" <?php if(isset($score) && $score=="3") echo"selected"?>>3星</option>
                        <option value="2" <?php if(isset($score) && $score=="2") echo"selected"?>>2星</option>
                        <option value="1" <?php if(isset($score) && $score=="1") echo"selected"?>>1星</option>
                    </select>
                    <button class="btn btn-info" type="submit">送出</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-start my-2">
        <h6 class="text-start d-flex align-items-center me-4">共 <?= $ratingCount ?> 則</h6>
            <?php if(isset($_GET["user_id"]) && $_GET["user_id"]!==""): ?>
            <a href="user-detail.php?id=<?=$id?>" class="btn btn-info">回會員詳細資訊</a>
            <?php endif; ?>
            <?php if($_GET["startdate"]!=="" || $_GET["enddate"]!=="" || $_GET["score"]!==""):?>
            <?php if(isset($_GET["startdate"])): ?>    
            <a href="ratings.php" class="btn btn-info">回評價列表</a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <table class="table table-bordered mt-3">
            <tr>
                <th>編號</th>
                <th>用戶帳號</th>
                <th>商品名</th>
                <th>評分</th>
                <th>發布時間</th>
                <th><?php if(isset($_GET["user_id"])&& $_GET["user_id"]!==""){echo "評論";} ?></th>
            </tr>
            <?php foreach($rows as $row): ?>
            <tr>
                <td><?=$row["id"]?></td>
                <td><?=$row["account"]?></td>
                <td><?=$row["name"]?></td>
                <td>
                    <?php if($row["stars"]==5){
                echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>';}
                else if($row["stars"]==4){
                    echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"><i class="fa-regular fa-star"></i>';}
                    else if($row["stars"]==3){
                        echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"><i class="fa-regular fa-star"></i>';}
                        else if($row["stars"]==2){
                            echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"><i class="fa-regular fa-star"></i>';}
                            else if($row["stars"]==1){
                                echo '<i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"><i class="fa-regular fa-star"></i>';}
                ?>
                </td>
                <td><?=$row["posted_at"]?></td>
                <td>
                    <?php if($_GET["user_id"]==""): ?>
                    <a href="rating-detail.php?id=<?=$row["id"]?>" class="btn btn-info">查看詳細評論</a>
                    <?php endif; ?>
                    <?php if(isset($_GET["user_id"]) && $_GET["user_id"]!==""): ?>
                    <?=$row["comment"]?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for($i=1; $i<=$totalPage; $i++):?>
                <li class="page-item <?php if($i==$page)echo "active";?>"><a class="page-link"
                        href="ratings.php?page=<?=$i?>&user_id=<?php if(isset($id)) echo"$id";?>&startdate=<?php if(isset($date1)) echo"$date1";?>&enddate=<?php if(isset($date2)) echo"$date2";?>&score=<?php if(isset($score)) echo"$score";?>"><?=$i?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>

</html>
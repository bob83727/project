<?php
require_once("../housetunedbconnect.php");

if(isset($_GET["startdate"]) && $_GET["startdate"]!==""){
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
}else if(isset($_GET["score"])){
    $score=$_GET["score"];
    $sql= "SELECT rating.*, product.name, user.account FROM rating
    JOIN product ON rating.product_id = product.id
    JOIN user ON rating.user_id = user.id
    WHERE rating.stars='$score'";
}
else{
    $sql= "SELECT rating.*, product.name, user.account FROM rating
JOIN product ON rating.product_id = product.id
JOIN user ON rating.user_id = user.id";
}



$result = $conn->query($sql);
$ratingCount=$result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);

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

</head>

<body>
    <div class="container">
        <div class="py-2">
        <h2 class="text-center">Housetune商品評價列表</h2>
        <form action="ratings.php" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php if(isset($search)) echo"$search";?>" placeholder="依帳號篩選">
                <h6 class="d-flex align-items-center mx-2">依發布日期篩選</h6>
                <input type="date" class="form-control" name="startdate"
                    value="<?php if(isset($date1)) echo"$date1";?>">
                <h6 class="d-flex align-items-center mx-2">~</h6>
                <input type="date" class="form-control" name="enddate" value="<?php if(isset($date2)) echo"$date2";?>">
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
        </div>
        <h6 class="text-start">共 <?= $ratingCount ?> 則</h6>
        <table class="table table-bordered mt-3">
            <tr>
                <th>編號</th>
                <th>用戶帳號</th>
                <th>商品名</th>
                <th>評分</th>
                <th>發布時間</th>
                <th></th>
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
                <td><a href="rating-detail.php?id=<?=$row["id"]?>" class="btn btn-info">查看詳細評論</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
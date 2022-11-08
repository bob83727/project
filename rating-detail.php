<?php
require_once("../housetunedbconnect.php");

if (!isset($_GET["id"])){
    echo "評價不存在";
    exit;
}
$id=$_GET["id"];
$sql= "SELECT rating.*, product.name, user.account FROM rating
JOIN product ON rating.product_id = product.id
JOIN user ON rating.user_id = user.id
WHERE rating.id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
  <title>產品詳細評價</title>
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
    <h2 class="text-center">產品詳細評價</h2>
    <table class="table table-bordered">
        <tr>
            <th>用戶帳號</th>
            <td><?=$row["account"]?></td>
        </tr>
        <tr>
            <th>商品名</th>
            <td><?=$row["name"]?></td>
        </tr>
        <tr>
            <th>評分</th>
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
        </tr>
        <tr>
            <th>評論</th>
            <td><?=$row["comment"]?></td>
        </tr>
    </table>
    <div class="text-center">
    <a href="ratings.php" class="btn btn-info mt-2">回全部評價列表</a>
    </div>
  </div>
</body>

</html>
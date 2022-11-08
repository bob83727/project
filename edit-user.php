<?php
require_once("../housetunedbconnect.php");
if(!isset($_GET["id"])){
    echo "使用者不存在";
    exit;
}
$id = $_GET["id"];
$sql = "SELECT * FROM user WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$userCount=$result->num_rows;

?>

<!doctype html>
<html lang="en">

<head>
  <title>編輯資訊</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <?php if($userCount==0): ?>
        使用者不存在
    <?php else: ?>
    <h3 class="text-center">編輯使用者資訊</h3>
    <form action="doUpdate.php?id=<?=$row["id"]?>" method="post">
        <table class="table table-bordered mt-3">
        <tr>
            <input type="hidden" value="<?=$row["id"]?>" name="id">
            <th>編號</th>
            <td><?= $row["id"]?></td>
        </tr>
        <tr>
            <th>帳號</th>
            <td><input type="text" value="<?= $row["account"]?>" name="account"></td>
        </tr>
        <tr>
            <th>密碼</th>
            <td><input type="text" value="<?= $row["password"]?>" name="password"></td>
        </tr>
        <tr>
            <th>名稱</th>
            <td><input type="text" value="<?= $row["name"]?>" name="name"></td>
        </tr>
        <tr>
            <th>電話</th>
            <td><input type="text" value="<?= $row["phone"]?>" name="phone"></td>
        </tr>
        <tr>
            <th>信箱</th>
            <td><input type="text" value="<?= $row["email"]?>" name="email"></td>
        </tr>
        <tr>
            <th>地址</th>
            <td><input type="text" value="<?= $row["address"]?>" name="address"></td>
        </tr>
        <tr>
            <th>註冊時間</th>
            <td><?= $row["created_at"]?></td>
        </tr>
        <tr>
            <th>狀態</th>
            <td>
                <select name="valid" id="">
                    <option value="1" <?php if($row["valid"]==1){echo "selected" ;}?>>使用中</option>
                    <option value="0" <?php if($row["valid"]==0){echo "selected" ;}?>>已停權</option>
                </select>
            </td>
        </tr>
        </table>
        <button class="btn btn-info" type="submit">送出</button>
    </form>
    <div class="d-flex justify-content-center mt-3">
    <a href="user-detail.php?id=<?=$row["id"]?>" class="btn btn-info">返回會員詳細資料</a>
    </div>
    <?php endif ;?>
  </div>
</body>

</html>
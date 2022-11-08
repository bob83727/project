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

?>
<!doctype html>
<html lang="en">

<head>
    <title>會員詳細資料</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h3 class="text-center">會員詳細資料</h3>
        <table class="table table-bordered mt-3">
            <tr>
                <th>編號</th>
                <td><?= $row["id"]?></td>
            </tr>
            <tr>
                <th>帳號</th>
                <td><?= $row["account"]?></td>
            </tr>
            <tr>
                <th>密碼</th>
                <td><?= $row["password"]?></td>
            </tr>
            <tr>
                <th>名稱</th>
                <td><?= $row["name"]?></td>
            </tr>
            <tr>
                <th>電話</th>
                <td><?= $row["phone"]?></td>
            </tr>
            <tr>
                <th>信箱</th>
                <td><?= $row["email"]?></td>
            </tr>
            <tr>
                <th>地址</th>
                <td><?= $row["address"]?></td>
            </tr>
            <tr>
                <th>註冊時間</th>
                <td><?= $row["created_at"]?></td>
            </tr>
            <tr>
                <th>最後異動時間</th>
                <td><?= $row["last_modified"]?></td>
            </tr>
            <tr>
                <th>狀態</th>
                <td><?php if($row["valid"]==1){
                        echo "使用中" ;}else{
                            echo "已停權" ;}?></td>
            </tr>
            <tr>
                <th>異動</th>
                <td><a href="edit-user.php?id=<?=$row["id"]?>" class="btn btn-info me-4">編輯資訊</a><a
                        href="delete-user.php?id=<?=$row["id"]?>" class="btn btn-danger">永久刪除使用者</a></td>
            </tr>
        </table>
        <div class="d-flex justify-content-evenly">
            <a href="userlist.php" class="btn btn-info mt-2">回會員列表</a>
            <a href="ratings.php" class="btn btn-info mt-2">檢視用戶所有評價</a>
            <a href="order-list.php?user_id=<?= $row["id"]?>" class="btn btn-info mt-2">檢視用戶歷史訂單</a>
        </div>
    </div>
</body>

</html>
<?php
require_once("../housetunedbconnect.php");

$id=$_GET["id"];

$sql="DELETE FROM user WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("refresh:5; userlist.php");
    print("刪除使用者完成，5秒後跳轉回會員列表頁");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

?>
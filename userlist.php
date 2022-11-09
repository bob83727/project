<?php
require_once("../housetunedbconnect.php");
//pdo寫法
//require_once("../htpdo-connect.php");
if(isset($_GET["page"])){
    $page=$_GET["page"];
}else{
    $page=1;
}
$perPage=5;
$page_start=($page-1)*$perPage;

if(isset($_GET["search"]) && $_GET["search"]!==""){
    $search=$_GET["search"];
    $sql = "SELECT * FROM user WHERE account LIKE '%$search%' ORDER BY created_at DESC ";
    $sql1= "SELECT * FROM user WHERE account LIKE '%$search%' ORDER BY created_at DESC LIMIT $page_start, $perPage";
}
else if(isset($_GET["startdate"]) && $_GET["startdate"]!==""){
    $date1=$_GET["startdate"];
    if(isset($_GET["enddate"]) && $_GET["enddate"]!==""){
    $date2=$_GET["enddate"];
    $sql = "SELECT * FROM user WHERE created_at >= '$date1' AND created_at<= '$date2' ORDER BY created_at DESC ";
    $sql1= "SELECT * FROM user WHERE created_at >= '$date1' AND created_at<= '$date2' ORDER BY created_at DESC LIMIT $page_start, $perPage";
    }else{
        $sql = "SELECT * FROM user WHERE created_at >= '$date1' ORDER BY created_at DESC ";
        $sql1= "SELECT * FROM user WHERE created_at >= '$date1' ORDER BY created_at DESC LIMIT $page_start, $perPage";
    }
}else if(isset($_GET["enddate"]) && $_GET["enddate"]!==""){
    $date2=$_GET["enddate"];
    $sql = "SELECT * FROM user WHERE created_at<= '$date2' ORDER BY created_at DESC ";
    $sql1= "SELECT * FROM user WHERE created_at<= '$date2' ORDER BY created_at DESC LIMIT $page_start, $perPage";
}
else if(isset($_GET["address"]) && $_GET["address"]!==""){
    $address=$_GET["address"];
    $sql = "SELECT * FROM user WHERE address LIKE '%$address%' ORDER BY created_at DESC ";
    $sql1= "SELECT * FROM user WHERE address LIKE '%$address%' ORDER BY created_at DESC LIMIT $page_start, $perPage";}
else if(isset($_GET["status"]) && $_GET["status"]!==""){
    $valid=$_GET["status"];
    $sql = "SELECT * FROM user WHERE valid=$valid ORDER BY created_at DESC ";
    $sql1= "SELECT * FROM user WHERE valid=$valid ORDER BY created_at DESC LIMIT $page_start, $perPage ";
}
else{
    $sql = "SELECT * FROM user";
    $sql1= "SELECT * FROM user ORDER BY created_at DESC LIMIT $page_start, $perPage";}

$result = $conn->query($sql);
$userCount = $result->num_rows;
$totalPage=ceil($userCount/$perPage);
$result1=$conn->query($sql1);
$rows = $result1->fetch_all(MYSQLI_ASSOC);

// if(isset($_GET["page"])){
//     $page=$_GET["page"];
// }else{
//     $page=1;
// }
// //計算所有使用者
// $sqlAll="SELECT * FROM users WHERE valid=1";
// $resultAll=$conn->query($sqlAll);
// $userCount=$resultAll->num_rows;
// $perPage=5;
// //$page=3;
// $page_start=($page-1)*$perPage;
// $sql="SELECT * FROM users WHERE valid=1 ORDER BY created_at DESC LIMIT $page_start, $perPage";
// $result=$conn->query($sql);
// $totalPage=ceil($userCount/$perPage);

//pdo寫法
// $stmt=$db_host->prepare($sql);

// try{
//     大概等同於 $conn->query()
//     $stmt->execute();
//     $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
//     $userCount= $stmt->rowCount();
// }catch(PDOException $e){
//     echo "預處理陳述式執行失敗! .<br/>";
//     echo "Error: ". $e->getMessage() ."<br/>";
//     $db_host = NULL;
//     exit;
// }


?>
<!doctype html>
<html lang="en">

<head>
    <title>Member list</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">

        <h2 class="text-center">Housetune會員名單</h2>
        <div class="py-2 d-flex justify-content-end">
            <a href="sign-up-ui.php" class="btn btn-info">Add user</a>
        </div>
        <div class="py-2">
            <form action="userlist.php" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="search"
                        value="<?php if(isset($search)) echo"$search";?>" placeholder="依帳號篩選">
                    <h6 class="d-flex align-items-center mx-2">依註冊日期篩選</h6>
                    <input type="date" class="form-control" name="startdate"
                        value="<?php if(isset($date1)) echo"$date1";?>">
                    <h6 class="d-flex align-items-center mx-2">~</h6>
                    <input type="date" class="form-control" name="enddate"
                        value="<?php if(isset($date2)) echo"$date2";?>">
                    <select name="address" id="" class="ms-2">
                        <option value="">依城市篩選</option>
                        <option value="台北市" <?php if(isset($address) && $address=="台北市") echo"selected"?>>台北市</option>
                        <option value="新北市" <?php if(isset($address) && $address=="新北市") echo"selected"?>>新北市</option>
                        <option value="台中市" <?php if(isset($address) && $address=="台中市") echo"selected"?>>台中市</option>
                        <option value="台南市" <?php if(isset($address) && $address=="台南市") echo"selected"?>>台南市</option>
                        <option value="桃園市" <?php if(isset($address) && $address=="桃園市") echo"selected"?>>桃園市</option>
                    </select>
                    <select name="status" id="">
                        <option value="">依狀態篩選</option>
                        <option value="1" <?php if(isset($valid) && $valid=='1') echo"selected"?>>使用中</option>
                        <option value="0" <?php if(isset($valid) && $valid=='0') echo"selected"?>>已停權</option>
                    </select>
                    <button class="btn btn-info" type="submit">送出</button>
                </div>

            </form>
        </div>
        <div class="py-2 d-flex justify-content-between">
            <?php if (isset($search) && $search!==""):?>
            <h6><?=$search?>的搜尋結果</h6>
            <?php endif;?>
            <?php if (isset($address) && $address!==""):?>
            <h6><?=$address?>的搜尋結果</h6>
            <?php endif;?>
            <h6>共 <?= $userCount ?> 人</h6>
        </div>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>編號</th>
                    <th>帳號</th>
                    <th>密碼</th>
                    <th>名稱</th>
                    <th>電話</th>
                    <th>狀態</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $person): ?>
                <tr>
                    <td><?= $person["id"]?></td>
                    <td><?= $person["account"]?></td>
                    <td><?= $person["password"]?></td>
                    <td><?= $person["name"]?></td>
                    <td><?= $person["phone"]?></td>
                    <td><?php if($person["valid"]==1){
                        echo "使用中" ;}else{
                            echo "已停權" ;}?></td>
                    <td><a href="user-detail.php?id=<?= $person["id"] ?>" class="btn btn-info">詳細資訊</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for($i=1; $i<=$totalPage; $i++):?>
                <li class="page-item <?php if($i==$page)echo "active";?>"><a class="page-link"
                        href="userlist.php?page=<?=$i?>&search=<?php if(isset($search)) echo"$search";?>&startdate=<?php if(isset($date1)) echo"$date1";?>&enddate=<?php if(isset($date2)) echo"$date2";?>&address=<?php if(isset($address)) echo"$address";?>&status=<?php if(isset($valid)) echo"$valid";?>"><?=$i?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php if(isset($search)|| isset($address)|| isset($valid)|| isset($date1)|| isset($date2)):?>
        <div>
            <a href="userlist.php" class="btn btn-info">回全部會員列表</a>
        </div>
        <?php endif ;?>
    </div>
</body>

</html>
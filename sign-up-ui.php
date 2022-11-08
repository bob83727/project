<!doctype html>
<html lang="en">

<head>
    <title>Housetune 會員註冊</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <style>
        .container {
            width: 600px;
            height: 400px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="doSignUp.php" method="post">
            <div class="card m-4">
                <div class="card-header">
                    <div>
                        <h1 class="m-5 ms-0">Housetune 會員註冊</h1>
                        <p>快速又簡單</p>
                        <hr>
                    </div>
                </div>
                <div class="card-body ">

                    <div class="row justify-content-center p-2">
                        <input class="mb-1 bg-light col form-control" type="text" placeholder="請輸入4~20字元長度的帳號" name="account" require minlength="4" maxlength="20">
                        <input class="mb-1 bg-light col ms-1 form-control" type="text" placeholder="姓名" name="name" required>
                        <input class="mb-1  bg-light form-control" type="text" placeholder="手機號碼" name="phone" required>
                        <input class="mb-1  bg-light form-control" type="email" placeholder="email" name="email" required>
                        <!-- 需要一樣長就確定都下一的東西 ms-1 不會爆版 -->
                        <input class="mb-1  bg-light form-control" type="address" placeholder="地址" name="address" required>
                        <input class="mb-1  bg-light form-control" type="password" placeholder="設定4-20位數密碼" class="form-control" name="password" required>
                        <input class="mb-1  bg-light form-control" type="repassword" placeholder="再次輸入密碼" class="form-control" name="repassword" required>
                    </div>

                    <button class="btn btn-primary m-auto" type="submit">註冊</button>
        </form>
    </div>
    </div>
    </div>



    <script>

    </script>
</body>

</html>
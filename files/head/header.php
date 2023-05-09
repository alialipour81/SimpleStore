<?php require_once 'files/connect/database.php'?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <link rel="stylesheet" href="files/css/style.css">
    <title> عنوان صفحه </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        nav form{
            display: flex;
        }
        .search{
            width: 145px;
            height: 30px;
            outline:none;
            font-family: 'iran' !important;
        }
        .btn-search{
            width: 90px;
            height: 30px;
            background: #005cbf;
            color: #fff;
            outline:none;
            border: none;
            cursor: pointer;
            font-family: 'iran' !important;
            transition: all 0.4s ease-out;
        }
        .btn-search:hover{
           opacity: 0.7;
        }
        .sendComment{
            width: 90%;height: 300px;box-shadow: 2px 2px 20px 2px #cccccc;margin: 0 auto;margin-bottom: 20px;
            padding: 20px;
        }
        .sendComment .right{
            float: right;display: inline-block;width: 50%;height: 100%;
        }
        .sendComment .right input{
            width: 100%;padding: 7px;border: none;border-radius: 5px;border: 1px solid #dddddd;font-family: 'iran';
        }
        .sendComment .right textarea{
            width: 100%;padding: 7px;border: none;border-radius: 5px;border: 1px solid #dddddd;font-family: 'iran';
            margin-top: 10px;
        }
        .sendComment .right input,textarea::placeholder{
            font-size: 13px;
        }
        textarea{
            resize: none;
        }
        .sendComment .right button{
            width: 100%;padding: 7px;border: none;border-radius: 5px;font-family: 'iran';
            margin-top: 10px;background-color: #12a1ee;color: #ffffff;
        }
        .sendComment .left{
            float: left;display: inline-block;width: 48%;height: 257px;background-color: #cce5ff;border-radius: 5px;
            padding: 10px;text-align: right;overflow: hidden;border: 1px solid #b8daff;
        }
        .sendComment .left li{
            font-size: 13px;margin-right: 20px;color: #007bff;margin-top: 18px;
        }
        /************************ END PAGE **********************/

        /************************ START COMMENT **********************/
        .comment{
            width: 90%;height: 100%;box-shadow: 2px 2px 8px 2px #dddddd;background-color: #12a1ee;
            margin: 20px auto;
        }
        .comment .box{
            width: 98%;background-color: #ffffff;padding: 10px 0px;margin: 10px auto;
        }
        .comment .box span{
            line-height: 50px;font-size: 13px;margin-right: 20px;
        }
        .alert-mess{
            width: 90%;margin: 0px auto;text-align: center;
        }
        .comment .boxcom{
            width: 98%;background-color: #2d8cdf;padding: 10px 0px;margin: 10px auto;color: #fff;
        }
        .next-kh{
            text-decoration: none ;background: indigo;color: #fff;border-radius: 3px;padding: 7px;transition: background 0.6s ease-out;font-size: 13px;
        }
        .next-kh:hover{
            background: transparent;border: 1px solid indigo;color: #1b1e21;
        }
        .inp-address{
            width: 100%;font-family: 'iran';outline: none;
        }
        .btn-address{
            font-family: 'iran';
           border: none;
            cursor: pointer;
            margin-top: 9px;
            width: 100%;
        }
    </style>
</head>
<body>
<!------------ start header ------------>
<?php
$query = "SELECT * FROM categories WHERE parent_id=?";
$categories = $action->select($query,[0],'fetchAll');

?>
<header>
    <nav>
        <ul>
            <li> <a href="index.php">خانه</a> </li>
            <?php foreach ($categories as $category){?>
            <li><a href="<?= 'category.php?categoryid='.$category->id ?>"> <?= $category->name ?></a>
                <!------ start dropDown ------>
                <?php
                $query2 = "SELECT * FROM categories WHERE parent_id=?";
                $submenu = $action->select($query2,[$category->id],'fetchAll');
                if (count($submenu)){
                ?>
                <ul class="dropdown">
                    <?php foreach ($submenu as $value){?>
                    <li><a href="<?= 'category.php?categoryid='.$value->id ?>"> <?= $value->name ?></a>
                    <?php }?>
                </ul>
                <?php }?>
                <!------ end dropDown ------>
            </li>
            <?php }?>
            <?php if (isset($_SESSION['userid'])){?>
               <li><a href="exit.php">خروج از سایت</a></li>
                <li> <a href="bascket.php" style="background-color: limegreen;padding: 5px 15px;border-radius: 3px;color: #ffffff;font-size: 12px"> سبد خرید  </a> </li>
            <?php }else{?>
            <li> <a href="login.php">ورود</a> </li>
            <li> <a href="register.php">عضویت</a> </li>
            <?php } ?>

            <li>
                <form method="post" action="search.php">
                    <input type="text" class="search" name="search" placeholder="دنبال چی میگردی">
                    <button type="submit" class="btn-search" name="btn_search">جستجو</button>
                </form>
            </li>
        </ul>
    </nav>
</header>
<!------------ end header ------------>
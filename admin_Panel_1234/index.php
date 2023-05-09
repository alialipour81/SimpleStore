<?php
include_once 'file_admin/head/header.php';
if (isset($_POST['btnlogin'])){
    $username = $_POST['username'];$password=$_POST['password'];
    if (isset($username) && isset($password) && !empty($username) && !empty($password)){
        $query = "SELECT * FROM admin WHERE username=? AND password=?";
        $result = $action->select($query,[$action->SecuriyInput($username),md5($action->SecuriyInput($password))]);
        if ($result == true) {
            session_regenerate_id();
            $_SESSION['name'] = $result->name;
            header('location:panel.php');
        } else {
            $error = 'ادمینی با این مشخصات وجود ندارد';
        }
    }else{
        $error = 'لطفا ورودی ها را پرکنید';
    }
}
?>

<div class="boxfader">
<div class="ADDmininputLOG">
   <h3 style="text-align: center">فرم ورود مدیریت</h3><br>
    <?php include_once 'file_admin/head/message.php'?>
    <form method="post">
    <input type="text" placeholder="نام کاربری"name="username"><br>
    <input type="password" placeholder="پسورد" name="password"><br>
    <button type="submit" name="btnlogin">ورود به داشبورد</button>
    </form>
</div>
</div>
<?php include_once 'file_admin/head/footer.php'; ?>
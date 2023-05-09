<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['edituser']) && $_GET['edituser'] >=1){
    $user_id = (int) $_GET['edituser'];
    $query = "SELECT * FROM users WHERE id=?";
    $user = $action->select($query,[$user_id]);

}else{
    header('location:list-users.php');
}

if (isset($_POST['btn_updateuser'])){
    $name = $action->SecuriyInput($_POST['name']);
    $username = $action->SecuriyInput($_POST['username']);
    $email = $action->SecuriyInput($_POST['email']);
    $password = $action->SecuriyInput($_POST['password']);
    $confirm_password = $action->SecuriyInput($_POST['confirm_password']);
    if (isset($name) && isset($username) && isset($email) && !empty($name) && !empty($username) && !empty($email)){
        $errorCounter = 0;
        if ( !empty($password) &&  empty($confirm_password)){
            $error = 'شما باید فیلد تکرار پسورد رو وارد کنید';
            $errorCounter = $errorCounter +1;
        }
        if ( empty($password) && !empty($confirm_password)){
            $error = 'شما باید فیلد  پسورد رو وارد کنید';
            $errorCounter = $errorCounter +1;
        }
         if ( !empty($password) && !empty($confirm_password)){
            if ($password != $confirm_password){
                $error = 'فیلد پسورد جدید وتکرار پسورد جدید با هم مطابقت ندارند';
                $errorCounter = $errorCounter +1;
            }
        }
         if ($errorCounter == 0){
             $query2 = "UPDATE users SET name=?,username=?,email=?,password=? WHERE id=?";
             if ( !empty($password) && !empty($confirm_password)) {
                 $action->inud($query2, [$name, $username,$email,md5(sha1($password)),$user_id]);
             }else{
                 $action->inud($query2, [$name, $username,$email,$user->password,$user_id]);
             }
             if ($action== true){
                 header('location:list-users.php?update=success');
             }
         }
    }else{
        $error = "ورودی های نام و نام کاربری و ایمیل  ضرروری است";
    }
}
?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">ویرایش  کاربر</div>
                <form method="post" >
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="نام را بنویسید" value="<?= $user->name ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="نام کاربری را بنویسید" value="<?= $user->username ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="ایمیل را بنویسید" value="<?= $user->email ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="پسورد جدید را بنویسید(در صورت نیاز وارد کنید)" >
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="تکرار پسورد جدید را بنویسید(در صورت نیاز وارد کنید)" >
                    </div>

                    <button class="btn btn-primary float-right" type="submit" name="btn_updateuser">ویرایش  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


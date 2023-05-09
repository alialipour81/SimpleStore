<?php require_once 'files/head/header.php';
if (!isset($_SESSION['userid'])){
    header('location:login.php');
}

if (isset($_POST['btn_saveaddress'])){
    $address = $action->SecuriyInput($_POST['address']);
    if (isset($address) && !empty($address)){
        $query = "UPDATE basket SET address=? WHERE user_id=?";
        $action->inud($query,[$address,$_SESSION['userid']]);
        if ($action == true){
            header('location:request.php');
        }
    }else{
        $error = 'فیلد آدرس اجباریست';
    }



}
?>
    <!-------------- start Table ------------->
    <div class="container">
        <?php include_once 'admin_Panel_1234/file_admin/head/message.php'?><br>
        <form method="post">
            <textarea name="address" rows="4" class="inp-address" placeholder="ادرس خود را وارد کنید"></textarea>
            <button name="btn_saveaddress" type="submit" class="next-kh btn-address">ثبت آدرس وادامه خرید</button>
        </form>

        <br>

    </div>
    <!-------------- end Table ------------->
<?php require_once 'files/head/footer.php'?>


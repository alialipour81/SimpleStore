<?php require_once 'files/head/header.php';
if (isset($_POST['btn_login'])){
    $username= $action->SecuriyInput($_POST['username']); $password= $action->SecuriyInput($_POST['password']);
    if (isset($username) && isset($password) && !empty($username) && !empty($password)){
        $recaptcha_secret = "6LcKpgYkAAAAAH9_ivoGUgvv6Ao6Nmk_26rOWK8t";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
        $response = json_decode($response, true);
        if($response["success"] == true){
            $query = "SELECT * FROM users WHERE username=? AND password=?";
            $result = $action->select($query,[$username,md5(sha1($password))]);
            if (isset($_POST['remember_me'])){
                setcookie('username',$username,time()+ (30*24*60*60));
                setcookie('password',$password,time()+ (30*24*60*60));
            }else{
                setcookie('username',"");
                setcookie('password',"");
            }
            if ($result == true){
                session_regenerate_id();
                $_SESSION['userid']= $result->id;
                header('location:index.php');
            }else{
                $error = 'کاربری با این مشخصات وجود ندارد';
            }
        }else{
            $error = 'لطفا کپچا را صحیح وارد کنید';
        }
    }else{
        $error = "لطفا ورودی ها را پر کنید";
    }
}
?>

    
    <!------------ start login form ------------>
    <div class="login">
        <div class="login-top">
            <span> ورود به حساب کاربری </span>
        </div>
        <div class="login-bot">
            <?php if (isset($error)) { ?>
                <div class="alert-danger"><?= $error ?></div>
            <?php } ?>
            <?php if (isset($success)) { ?>
                <div class="alert-success"><?= $success ?></div>
            <?php } ?>
        <form method="post">
            <input type="text" placeholder="نام کاربری خود را وارد کنید" name="username"
                   value="<?php if (isset($_COOKIE['username'])){ echo $_COOKIE['username'];}  ?>"><br>
            <input type="password" placeholder="رمز عبور خود را وارد کنید" name="password"
                   value="<?php if (isset($_COOKIE['password'])){ echo $_COOKIE['password'];}  ?>">
            <input type="checkbox" class="check" id="check"  name="remember_me" <?php if (isset($_COOKIE['username']) || isset($_COOKIE['password'])){ ?> checked <?php } ?> ><label for="check" > مرا به خاطر بسپار ! </label>
            <button type="submit" name="btn_login"> ورود به سایت </button>
            <div class="g-recaptcha" data-sitekey="6LcKpgYkAAAAAIx_nyQjYATHQV4KKvEpkoM_PnoV"></div>
        </form>
        </div>
    </div>
    <!------------ end login form ------------>
    
    
  <?php require_once 'files/head/footer.php' ?>
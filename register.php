<?php require_once 'files/head/header.php';require_once 'files/PHPMailer/class.phpmailer.php';

if (isset($_POST['btn_register'])){
    $name = $action->SecuriyInput($_POST['name']);$username = $action->SecuriyInput( $_POST['username']);$email = $action->SecuriyInput($_POST['email']);$password = $action->SecuriyInput($_POST['password']);$mpassword = $action->SecuriyInput($_POST['mpassword']);
    if (isset($name) && isset($username) && isset($email) && isset($password) && isset($mpassword)
    && !empty($name) && !empty($username) && !empty($email) && !empty($password) && !empty($mpassword)) {

       if ($password == $mpassword){
               $recaptcha_secret = "6LcKpgYkAAAAAH9_ivoGUgvv6Ao6Nmk_26rOWK8t";
               $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
               $response = json_decode($response, true);
               if($response["success"] === true){
                  if (preg_match("/^[a-zA-Z]*$/",$username)){
                      $query = "SELECT * FROM users WHERE username=? OR email=?";
                      $SelectUser = $action->select($query,[$username,$email]);
                      if ($SelectUser == true){
                          $error = "نام کاربری یا ایمیل از قبل موجود میباشد";
                      }else{
                          $queryInsertUser = "INSERT INTO users SET name=?,username=?,email=?,password=?,ip=?";
                          $action->inud($queryInsertUser,[$name,$username,$email,md5(sha1($password)),$_SERVER['REMOTE_ADDR']]);
                          if ($action == true){
                              $mail = new PHPMailer();
                              $mail->IsSMTP();
                              $mail->AddAddress($email);
                              $mail->MsgHTML('حساب کاربری شما در سایت آنلاین شاپ با موفقیت ایجاد شد .هم اکنون میتوانید به تمامی امکانات سایت دسترسی داشته باشید');
                              $mail->Send();
                              $success = "اطلاعات شما با موفقیت ثبت شد و ایمیل به حساب شما ارسال شد";
                          }
                      }
                  }else{
                      $error = "نام کاربری فقط باید شامل حروف الفبای انگلیسی باشد";
                  }
               }else{
                   $error = 'کپچا به درستی وارد نشده است';
               }
       }else{
           $error = "پسورد ها با هم مطابقت ندارند";
       }
    }else{
        $error = "لطفا همه ورودی ها را پر کنید";
    }

}





?>


    
    <!------------ start login form ------------>
    <div class="sighn">
        <div class="login-top">
            <span> فرم ثبت نام در سایت </span>
        </div>
        <div class="login-bot">
            <?php if (isset($error)) { ?>
                <div class="alert-danger"><?= $error ?></div>
            <?php } ?>
            <?php if (isset($success)) { ?>
                <div class="alert-success"><?= $success ?></div>
            <?php } ?>
        <form method="post">
            <input type="text" placeholder="نام خود را وارد کنید" name="name"><br>
            <input type="text" placeholder="نام کاربری خود را وارد کنید" name="username"><br>
            <input type="email" placeholder="ایمیل خود را وارد کنید" name="email"><br>
            <input type="password" placeholder="رمز عبور خود را وارد کنید" name="password">
            <input type="password" placeholder="تکرار رمز عبور خود را وارد کنید" name="mpassword"><br><br>
            <div class="g-recaptcha" data-sitekey="6LcKpgYkAAAAAIx_nyQjYATHQV4KKvEpkoM_PnoV"></div>
            <button type="submit" name="btn_register"> ثبت نام در سایت </button>
        </form>
            <br>
            <a href="login.php" style="font-size: 14px;text-decoration: none;color: forestgreen">قبلا ثبت نام کردید؟</a>
        </div>
    </div>
    <!------------ end login form ------------>
    
    <?php require_once 'files/head/footer.php'?>
<?php require_once 'files/head/header.php';require_once 'admin_Panel_1234/file_admin/jdf.php';
if (isset($_GET['product']) && $_GET['product'] >=1){
    $pID = (int) $_GET['product'];
    $querygetinfoproduct = "SELECT * FROM products WHERE id=?";
      $product =  $action->select($querygetinfoproduct,[$pID]);
      $querygetcatproduct = "SELECT * FROM categories WHERE id=?";
      $category = $action->select($querygetcatproduct,[$product->category_id]);
}else{
    header('location:index.php');
}

if (isset($_POST['btn_addprotobasketbuy'])) {
    $queryaddprotobasket = "INSERT INTO basket SET user_id=?,product_id=?";
    $action->inud($queryaddprotobasket,[$_SESSION['userid'],$product->id]);
    if ($action == true){
        header('location:bascket.php?afzoodan=success');
    }
}

?>
<div class="det-product">
    <p><?= $product->title ?></p>
</div>
<div class="pic-box">
    <div class="pic-product">
        <img src="<?= 'admin_Panel_1234/file_admin/products/'.$product->image ?>" alt="">
    </div>
    <div class="desc-product">
        <p> تاریخ ثبت محصول : <?= $action->DateToSHamsi($product->date) ?> </p>
        <p> فروشنده این محصول :  <?= $product->seller ?> </p>
        <p> گارانتی : <?= $product->waran ?> </p>
        <p> دسته بندی محصول : <?= $category->name ?> </p>
        <p> برند : <?= $product->brand ?> </p>
        <span> قیمت نهایی محصول : <?= number_format($product->price) ?> </span>

        <form method="post" <?php if(!isset($_SESSION['userid'])){ ?> action="login.php" <?php } ?>>
            <button name="btn_addprotobasketbuy" type="submit"> افزودن محصول به سبد خرید </button>
        </form>
    </div>
</div>
   <div class="descrip-pro">

    <h4 style="color: #6b6b6b"> بررسی تخصصی محصول </h4>
    <p><?= $product->content ?></p>
    <?php $tags = explode('-',$product->tags);
         foreach ($tags as $tag){
     ?>
           <span style="background: purple;color: #fff;margin-left: 5px;padding: 3px;border-radius: 4px">#<?= $tag ?></span>
       <?php } ?>
   </div>
   <div class="tabligh">  </div>
   <div class="onvan1"> <h4>کالای مشابه</h4> </div>
<?php
$query2 = "SELECT * FROM products WHERE brand=? LIMIT 0,4";
$productsM = $action->select($query2,[$product->brand],'fetchAll');
?>
   <div class="dop-pro">
       <?php
       foreach ($productsM as $item){
           if ($item->id != $product->id){
           ?>
           <div class="div div1">
               <div class="image-box">
                   <img src="<?= 'admin_Panel_1234/file_admin/products/'.$item->image ?>" alt="">
               </div>
               <div class="text-box">
                   <a href="<?= 'page.php?product='.$item->id ?>" class="link-title-post" style="text-decoration: none;">
                       <p ><?= $item->title ?></p>
                   </a>
               </div>
               <div class="price-box">
                   <p style="display: inline-block;"> <?= number_format($item->price) ?> تومان </p>
                   <sapn style="background-color: #12a1ee;width: 50px;padding: 2px 5px;"><?= number_format($item->pricem) ?></sapn>
               </div>
           </div>
    <?php } } ?>

   </div>
          <!------------ end box ------------>
<?php
$querygetallcomment = "SELECT * FROM comments WHERE product_id=? && reply=? && status=?";
$comments = $action->select($querygetallcomment,[$product->id,0,1],'fetchAll');
?>
      <div class="onvan1"> <h4>نظرات کاربران در مورد این محصول</h4> </div>
        <?php foreach ($comments as $comment){ ?>
         <div class="comment">
             <span style="color: #ffffff;font-size: 13px;margin: 20px"> <?= $comment->name ?> </span>
             <span style="color: #ffffff;font-size: 12px;margin: 20px"> در تاریخ <?= $action->DateToSHamsi($comment->time) ?> </span>
             <div class="box">
                 <span><?= $comment->comment ?></span>
             </div>
             <?php
             $replies = $action->select($querygetallcomment,[$product->id,$comment->id,1],'fetchAll');
             foreach ($replies as $reply) {
             ?>
             <div class="boxcom">
                 <span> <?= $reply->comment ?> </span>
             </div>
         <?php } ?>

         </div>
    <?php } ?>
<?php

if (isset($_POST['add-comment'])) {
    $name = $action->SecuriyInput($_POST['name']);
    $email = $action->SecuriyInput($_POST['email']);
    $comment = $action->SecuriyInput($_POST['comment']);
    if (isset($name) && isset($email) && isset($comment) && !empty($name) && !empty($email) && !empty($comment)){
        $query = "INSERT INTO comments SET product_id=?,name=?,email=?,comment=?,reply=?,status=?";
        $action->inud($query,[$product->id,$name,$email,$comment,0,0]);
        if ($action == true) {
            $success = "نظر شما با موفقیت ثبت شد";
        }else{
            $error = "خطا در ارسال نظر";
        }
    }else{
        $error = "لطفا فیلد هارا پرکنید";
    }

}

?>
    <div class="alert-mess">
        <?php include_once 'admin_Panel_1234/file_admin/head/message.php'; ?>
    </div>

    <div class="sendComment">
        <div class="right">
            <form method="post">
                <input type="text" placeholder="نام خود را وارد کنید" name="name"><br>
                <input type="email" placeholder="ایمیل خود را وارد کنید" name="email" style="margin-top: 10px"><br>
                <textarea placeholder="نظر خود را بنویسید" cols="10" rows="3" size="none" name="comment"></textarea>
                <button type="submit" name="add-comment"> ثبت نظر </button>
            </form>
        </div>
        <div class="left">
            <li>کامنت های حاوی توهین نمایش داده نخواهد شد</li>
            <li>از ارسال کامنت بصورت فینگلیش خودداری فرمایید</li>
            <li>لطفا نظر خود در مورد محصول خریداری شده را بصورت کامل و واضح بیان کنید</li>
            <li>در صورت وجود مشکل در بخش ثبت یا پرداخت مبالغ محصول از قسمت تماس با ما بصورت مستقیم تماس حاصل فرمایید</li>
            <li>نظرات بعد از تایید مدیریت نمایش داده خواهد شد،شکیبا باشید</li>
        </div>
    </div>
 <!------------ end box ------------>



<?php require_once 'files/head/footer.php'?>
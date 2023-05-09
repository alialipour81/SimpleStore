<?php require_once 'files/head/header.php'?>
    <!------------ start slider ------------>

    <!------------ end slider ------------>
    <?php 

      if(isset($_GET['categoryid']) && $_GET['categoryid'] >=1){
        $query = "SELECT * FROM products WHERE category_id=?";
        $products = $action->select($query,[(int) $_GET['categoryid']],'fetchAll');
      }
     ?>
    
    <!------------ start body ------------>
    <div class="onvan"><p> جستجوی دسته بندی  </p></div>
    <div class="section">
        <?php
        if (!empty($products)){
         foreach ($products as $product){ 
        ?>
        <div class="div div1">
            <div class="image-box">
                <img src="<?= 'admin_Panel_1234/file_admin/products/'.$product->image ?>" alt="">
            </div>
            <div class="text-box">
                <a href="<?= 'page.php?product='.$product->id ?>" class="link-title-post" style="text-decoration: none;">
                    <p ><?= $product->title ?></p>
                </a>
            </div>
            <div class="price-box">
                <p style="display: inline-block;"> <?= number_format($product->price) ?> تومان </p>
                <sapn style="background-color: #12a1ee;width: 50px;padding: 2px 5px;"><?= number_format($product->pricem) ?></sapn>
            </div>
        </div>
    <?php } }else{ ?>
        <div class="alert-success ">برای این دسته بندی محصولی وجودندارد</div>
        <br><br>
    <?php } ?>
            
            

    <!------------ end body ------------>
    <?php require_once 'files/head/footer.php'?>
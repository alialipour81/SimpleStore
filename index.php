<?php require_once 'files/head/header.php'?>
    <!------------ start slider ------------>
<?php
$querygetslide = "SELECT * FROM slider ORDER BY id DESC ";
$slider = $action->select($querygetslide,[],'fetchAll');

$querygetlastproducts1 = "SELECT * FROM products ";
$lastproducts1 = $action->select($querygetlastproducts1,[],'fetchAll');
$Countpaginate = ceil(count($lastproducts1) / 8);
if(isset($_GET['page'])){
    $cn = ($_GET['page'] -1 ) *8;
}else{
    $cn =0;
}

$querygetlastproducts = "SELECT * FROM products ORDER BY id DESC LIMIT {$cn},8";
$lastproducts = $action->select($querygetlastproducts,[],'fetchAll');

?>
       <div class="slideshow-container">
           <?php foreach ($slider as $item){ ?>
           <div class="mySlides fade">
               <img src="<?= 'admin_Panel_1234/file_admin/slider/'.$item->image ?>" style="width:100%">
           </div>
           <?php } ?>


    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
    <!------------ end slider ------------>
    
    <!------------ start body ------------>
    <div class="onvan"><p> جدیدترین محصولات </p></div>
    <div class="section">
        <?php foreach ($lastproducts as $product){ ?>
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
    <?php } ?>
<div>
    <ul>
        <?php for ($j=1;$j<= $Countpaginate;$j++){ ?>
        <a href="index.php?page=<?= $j ?>" style="text-decoration: none;background: #005cbf;color: #fff;padding: 3px 9px;border-radius: 4px"><?= $j ?></a>
        <?php } ?>
    </ul>
</div>
            
            

    <!------------ end body ------------>
    <?php require_once 'files/head/footer.php'?>
<?php include_once 'file_admin/head/header.php';require_once 'file_admin/jdf.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['deletepro']) && $_GET['deletepro'] >=1){
    $pID = (int) $_GET['deletepro'];
    $query= "SELECT * FROM products WHERE id=?";
    $product_info = $action->select($query,[$pID]);
   if ($product_info == true){
       $query1 = "DELETE FROM products WHERE id=?";
       $action->inud($query1,[$pID]);
       if ($action == true){
           unlink('file_admin/products/'.$product_info->image);
           $success = 'محصول با موفقیت حذف شد';
       }
   }
}

$query2 = "SELECT * FROM products ORDER BY id DESC ";
$products = $action->select($query2,[],'fetchAll');
?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-12 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">لیست  محصولات</div>
                <table class="table table-dark table-hover ">
                   <thead>
                   <tr>
                       <th>آیدی</th>
                       <th>دسته بندی</th>
                       <th>عنوان</th>
                       <th>تصویر</th>
                       <th>قیمت </th>
                       <th>برند</th>
                       <th>تاریخ</th>
                       <th>عملیات</th>
                   </tr>
                   </thead>
                    <tbody>
                    <?php
                    if (!empty($products)){
                    foreach ($products as $product){
                        $queryGetCat = "SELECT * FROM categories WHERE id=?";
                        $cat = $action->select($queryGetCat,[$product->category_id]);
                        ?>
                    <tr>
                        <td><?= $product->id ?></td>
                        <td><?= $cat->name ?></td>
                        <td><?= $product->title ?></td>
                        <td>
                            <img src="<?= 'file_admin/products/'.$product->image ?>"  class="rounded shadow" width="80px" height="40px">
                        </td>
                        <td><?= number_format($product->price) ?>تومان</td>
                        <td><?= $product->brand ?></td>
                        <td><?= $action->DateToSHamsi($product->date) ?></td>
                        <td>
                            <a href="<?= 'edit-product.php?editpro='.$product->id ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="<?= 'list-products.php?deletepro='.$product->id ?>" class="btn btn-danger btn-sm">حذف</a>
                        </td>
                    </tr>
                    <?php
                    }
                    }else{
                    ?>
                        <div class="alert alert-info mt-2">فعلا محصولی اضافه نکرده اید  </div>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


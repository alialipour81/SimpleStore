<?php include_once 'file_admin/head/header.php';require_once 'file_admin/jdf.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['delorder']) && $_GET['delorder'] >= 1) {
    $OrderId = (int) $_GET['delorder'];
    $querydeleteorder = "DELETE FROM basket WHERE id=?";
    $action->inud($querydeleteorder,[$OrderId]);
    if ($action == true) {
        $success = "سفارش با موفقیت حذف شد";
    }
}

$querygetallorders = "SELECT * FROM basket";
$orders = $action->select($querygetallorders,[],'fetchAll');

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-12 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">لیست  سفارشات </div>
                <table class="table table-dark table-hover ">
                   <thead>
                   <tr>
                       <th>آیدی</th>
                       <th>کاربر</th>
                       <th>محصول</th>
                       <th>قیمت محصول</th>
                       <th>آدرس</th>
                       <th> وضعیت پرداخت</th>
                       <th>  تاریخ </th>
                       <th>عملیات</th>
                   </tr>
                   </thead>
                    <tbody>
                    <?php foreach ($orders as $order){
                        $querygetuser = "SELECT * FROM users WHERE id=?";
                        $user = $action->select($querygetuser,[$order->user_id]);
                        $querygetpro = "SELECT * FROM products WHERE id=?";
                        $product = $action->select($querygetpro,[$order->product_id]);

                    ?>
                    <tr>
                        <td><?= $order->id ?></td>
                       <td><?= $user->name ?></td>
                       <td><?= $product->title ?></td>
                        <td><?= number_format($product->price).'تومان' ?></td>
                       <td><?= $order->address ?></td>
                       <td>
                           <?php if ($order->status == 0){ ?>
                           <span class="badge badge-danger">پرداخت ناموفق</span>
                           <?php }else{ ?>
                               <span class="badge badge-success">پرداخت موفق</span>
                           <?php } ?>
                       </td>
                        <td><?= $action->DateToSHamsi($order->date) ?></td>
                         <td>
                            <a href="<?= 'edit-order.php?editorder='.$order->id ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="<?= 'list-orders.php?delorder='.$order->id ?>" class="btn btn-danger btn-sm">حذف</a>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


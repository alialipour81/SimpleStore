<?php require_once 'files/head/header.php';
if (!isset($_SESSION['userid'])){
    header('location:login.php');
}

if (isset($_GET['delproinbascket']) && $_GET['delproinbascket']>=1) {
    $proID = (int) $_GET['delproinbascket'];
    $querydelproinbas = "DELETE FROM basket WHERE id=?";
    $action->inud($querydelproinbas,[$proID]);
    if ($action == true){
        $success = "محصول با موفقیت از سبد خرید حذف شد";
    }
}


$querygetproinbasket = "SELECT * FROM basket WHERE user_id=? AND status=?";
$probasket = $action->select($querygetproinbasket,[$_SESSION['userid'],0],'fetchAll');


if (isset($_GET['order']) && $_GET['order'] == 'success'){
    $success = 'سفارش شما با موفقیت پرداخت شد وبزودی ارسال خواهد شد';
}elseif(isset($_GET['order']) && $_GET['order'] == 'error'){
    $error = 'پرداخت ناموفق بود لطفا دوباره امتحان کنید';
}
?>
    <!-------------- start Table ------------->
    <div class="container">
        <?php include_once 'admin_Panel_1234/file_admin/head/message.php'?><br>
    <table>
        <thead>
            <tr>
                <th> آیدی محصول </th>
                <th> نام محصول </th>
                <th> قیمت محصول </th>
                <th> حذف از سبد </th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($probasket)){
        foreach ($probasket as $key=>$item){
            $querygetinfopro = "SELECT * FROM products WHERE id=?";
            $pro = $action->select($querygetinfopro,[$item->product_id]);
            @$all_price+= $pro->price;
            $_SESSION['all_price'] = $all_price;
        ?>
            <tr>
                <td> <?= $key+1 ?> </td>
                <td><?= $pro->title ?></td>
                <td><?= number_format($pro->price).'تومان' ?></td>
                <td> <a href="<?= 'bascket.php?delproinbascket='.$item->id ?>"> حذف </a> </td>
            </tr>
        <?php }?>
        <tr>
            <td colspan="2">تعداد محصول : <?= count($probasket) ?></td>
            <td colspan="2">مبلغ قابل پرداخت : <?= number_format($all_price).'تومان' ?></td>
        </tr>
        <?php }else{ ?>
            <div class="alert alert-success">سبد خرید خالی است</div><br>
        <?php } ?>
        </tbody>
    </table>
        <br>
        <?php  if (!empty($probasket)){ ?>
        <a href="address.php" class="next-kh">ادامه خرید</a>
        <?php } ?>
    </div>
    <!-------------- end Table ------------->
<?php require_once 'files/head/footer.php'?>


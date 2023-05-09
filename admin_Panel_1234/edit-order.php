<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['editorder']) && $_GET['editorder'] >=1) {
    $OrderId = (int) $_GET['editorder'];
    $querygetinfoorder = "SELECT * FROM basket WHERE id=?";
    $order = $action->select($querygetinfoorder,[$OrderId]);
    
}else{
    header('location:list-orders.php');
}

if (isset($_POST['btn_updateorder'])) {
    $address = $action->SecuriyInput($_POST['address']);
    $status = $_POST['status'];
    if (isset($address) && !empty($address)) {
        $queryupdateorder = "UPDATE basket SET address=?,status=? WHERE id=?";
        $action->inud($queryupdateorder,[$address,$status,$OrderId]);
        if ($action == true){
            header('location:list-orders.php?update=success');
        }
    }else{
        $error = 'همه فیلد ها اجباری است';
    }
}

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">ویرایش سفارش  </div>
                <form method="post" >
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="address" placeholder="آدرس دقیق را بنویسید"><?= $order->address ?></textarea>
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control" >
                            <option value="0" <?php if ($order->status == 0){ ?> selected <?php } ?>>پرداخت ناموفق</option>
                            <option value="1" <?php if ($order->status == 1){ ?> selected <?php } ?>>پرداخت موفق</option>
                        </select>
                    </div>
                    <button class="btn btn-primary float-right" type="submit" name="btn_updateorder">ویرایش  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


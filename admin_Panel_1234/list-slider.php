<?php include_once 'file_admin/head/header.php';

if (isset($_GET['deleteslider']) && $_GET['deleteslider'] >=1) {
    $id = (int) $_GET['deleteslider'];
    $query = "SELECT * FROM slider WHERE id=?";
    $InfoOneSlider = $action->select($query,[$id]);
    if ($InfoOneSlider == true){
        unlink('file_admin/slider/'.$InfoOneSlider->image);
        $query2 = "DELETE FROM slider WHERE id=?";
        $action->inud($query2,[$id]);
        if ($action == true){
            $success = 'اسلایدر با موفقیت حذف شد';
        }else{
            $error = 'خطایی ناشناخته رخ داده است';
        }
    }

}

$query3 = "SELECT  * FROM slider";
$slider = $action->select($query3,[],'fetchAll');


?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-12 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">لیست عکس های اسلایدر</div>
                <table class="table table-dark table-hover ">
                   <thead>
                   <tr>
                       <th>آیدی</th>
                       <th>تصویر</th>
                       <th>عملیات</th>
                   </tr>
                   </thead>
                    <tbody>
                    <?php
                    if (!empty($slider)){
                    foreach ($slider as $item){?>
                    <tr>
                        <td><?= $item->id ?></td>
                        <td>
                            <img src="<?= 'file_admin/slider/'.$item->image ?>" width="80px" height="45px" class="rounded shadow">
                        </td>
                        <td>
                            <a href="<?= 'edit-slide.php?editslide='.$item->id ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="<?= 'list-slider.php?deleteslider='.$item->id ?>" class="btn btn-danger btn-sm">حذف</a>
                        </td>
                    </tr>
                    <?php
                    }
                    }else{
                    ?>
                    <div class="alert alert-info mt-2">فعلا عکسی برای اسلایدر انتخاب نشده است</div>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


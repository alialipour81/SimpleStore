<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}
if (isset($_GET['catdelete']) && $_GET['catdelete'] >=1){
    $query = "DELETE FROM categories WHERE id=?";
    $action->inud($query,[(int) $_GET['catdelete']]);
    if ($action == true){
        $success = 'دسته بندی با موفقیت حذف شد';
    }else{
        $error = 'خطایی نامشخص در حذف دسته بندی';
    }
}

$query2 = "SELECT * FROM categories  ";
$categories = $action->select($query2,[],'fetchAll');


?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-12 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">لیست دسته بندی</div>
                <table class="table table-dark table-hover ">
                   <thead>
                   <tr>
                       <th>آیدی</th>
                       <th>نام</th>
                       <th>وضعیت</th>
                       <th>عملیات</th>
                   </tr>
                   </thead>
                    <tbody>
                    <?php foreach ($categories as $category){ ?>
                    <tr>
                        <td><?= $category->id ?></td>
                        <td><?= $category->name ?></td>
                        <td>
                            <?php if ($category->parent_id == 0){ ?>
                                <span class="badge badge-light">دسته بندی اصلی</span>
                            <?php }else{ ?>
                                <span class="badge badge-primary ">زیردسته بندی</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="<?= 'edit-cat.php?catid='.$category->id ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="<?= 'list-cat.php?catdelete='.$category->id ?>" class="btn btn-danger btn-sm">حذف</a>
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


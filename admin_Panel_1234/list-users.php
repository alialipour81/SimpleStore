<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}
if (isset($_GET['deleteuser']) && $_GET['deleteuser'] >=1){
    $query  = "DELETE FROM users WHERE id=?";
    $action->inud($query,[(int) $_GET['deleteuser']]);
    if ($action == true){
        $success = 'کاربر با موفقیت حذف شد';
    }
}

$query2 = "SELECT * FROM users";
$users = $action->select($query2,[],'fetchAll');
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
                       <th>نام کاربری</th>
                       <th>ایمیل </th>
                       <th>IP </th>
                       <th>عملیات</th>
                   </tr>
                   </thead>
                    <tbody>
                    <?php foreach ($users as $user){ ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->ip ?></td>
                        <td>
                            <a href="<?= 'edit-user.php?edituser='.$user->id ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="<?= 'list-users.php?deleteuser='.$user->id ?>" class="btn btn-danger btn-sm">حذف</a>
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


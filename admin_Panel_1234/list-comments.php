<?php include_once 'file_admin/head/header.php';require_once 'file_admin/jdf.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}
if (isset($_GET['taiidcom'])) {
    $querytaiidcomment = "UPDATE comments SET status=? WHERE id=?";
    $action->inud($querytaiidcomment,[1,$_GET['taiidcom']]);
    if ($action == true){
        header('location:list-comments.php');
    }
}
if (isset($_GET['radcom'])) {
    $querytaiidcomment = "UPDATE comments SET status=? WHERE id=?";
    $action->inud($querytaiidcomment,[0,$_GET['radcom']]);
    if ($action == true){
        header('location:list-comments.php');
    }
}

if (isset($_GET['deletecom'])) {
    $querydelcom = "DELETE FROM comments WHERE id=?";
    $action->inud($querydelcom,[$_GET['deletecom']]);
    if ($action == true) {
        $success = 'حذف نظر با موفقیت انجام شد';
    }
}


$querygetcomments = "SELECT * FROM comments ORDER BY id DESC";
$comments = $action->select($querygetcomments,[],'fetchAll');


?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-12 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">لیست نظرات </div>
                <table class="table table-dark table-hover ">
                   <thead>
                   <tr>
                       <th>آیدی</th>
                       <th>محصول</th>
                       <th>نام</th>
                       <th>ایمیل</th>
                       <th>پاسخ</th>
                       <th>وضعیت</th>
                       <th>تاریخ ایجاد</th>
                       <th>عملیات</th>
                   </tr>
                   </thead>
                    <tbody>
                    <?php
                    foreach ($comments as $comment){
                        $querygetinfoproduct = "SELECT * FROM products WHERE id=?";
                        $product = $action->select($querygetinfoproduct,[$comment->product_id]);
                    ?>
                    <tr>
                        <td><?= $comment->id ?></td>
                        <td><?= $product->title ?></td>
                        <td><?= $comment->name ?></td>
                        <td><?= $comment->email ?></td>
                        <td>
                            <?php if ($comment->reply == 0){ ?>
                                <a href="reply-comment.php?replyto=<?= $comment->id ?>" class="btn btn-primary btn-sm">پاسخ</a>
                            <?php }else{ ?>
                                <span class="badge badge-secondary ">پاسخ است </span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($comment->status == 0){ ?>
                                <a href="list-comments.php?<?= 'taiidcom='.$comment->id ?>" class="btn btn-success btn-sm ">تایید  </a>
                            <?php }else{ ?>
                                <a href="list-comments.php?<?= 'radcom='.$comment->id ?>"  class="btn btn-danger btn-sm ">رد  </a>
                            <?php } ?>
                        </td>
                        <td><?= $action->DateToSHamsi($comment->time) ?></td>
                        <td>
                            <a href="edit-comment.php?<?= 'editcom='.$comment->id ?>" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="list-comments.php?<?= 'deletecom='.$comment->id ?>" class="btn btn-danger btn-sm">حذف</a>
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


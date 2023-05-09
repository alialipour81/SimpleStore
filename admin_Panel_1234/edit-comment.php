<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}


if (isset($_GET['editcom']) && $_GET['editcom'] >= 1) {
    $ID = (int) $_GET['editcom'];
    $queryinfocom = "SELECT * FROM comments WHERE id=?";
    $comment = $action->select($queryinfocom,[$ID]);
}else{
    header('location:list-comments.php');
}

if (isset($_POST['btn_updatecomment'])){
    $name = $action->SecuriyInput($_POST['name']);
    $email = $action->SecuriyInput($_POST['email']);
    $com = $action->SecuriyInput($_POST['comment']);
    $status = $action->SecuriyInput($_POST['status']);
    if (!empty($name) && !empty($email) && !empty($com) ){
        $queryupdatecom = "UPDATE comments SET name=?,email=?,comment=?,status=? WHERE id=?";
        $action->inud($queryupdatecom,[$name,$email,$com,$status,$ID]);
        if ($action == true) {
            header('location:list-comments.php?update=success');
        }
    }else{
        $error = "همه فیلد ها باید پر شود";
    }
}


?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">ویرایش  نظر <?= $comment->name ?></div>
                <form method="post" >
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="نام را بنویسید" value="<?= $comment->name ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="ایمیل را بنویسید" value="<?= $comment->email ?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="comment" rows="4" placeholder="متن نظر را بنویسید"><?= $comment->comment ?></textarea>
                    </div>
                    <div class="form-group">
                        <label >وضعیت تایید</label>
                        <select name="status"  class="form-control">
                            <option value="0" <?php if ($comment->status == 0){ ?> selected <?php } ?> > رد</option>
                            <option value="1" <?php if ($comment->status == 1){ ?> selected <?php } ?>>تایید </option>
                        </select>
                    </div>

                    <button class="btn btn-primary float-right" type="submit" name="btn_updatecomment">ویرایش  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}


if (isset($_GET['replyto']) && $_GET['replyto'] >= 1) {
    $ID = (int) $_GET['replyto'];
    $queryinfocom = "SELECT * FROM comments WHERE id=?";
    $comment = $action->select($queryinfocom,[$ID]);
}else{
    header('location:list-comments.php');
}

if (isset($_POST['btn_reply'])){
    $textReply = $action->SecuriyInput($_POST['reply']);
    if (isset($textReply) && !empty($textReply)) {
        $queryreply = "INSERT INTO comments SET product_id=?,name=?,email=?,comment=?,reply=?,status=?";
        $action->inud($queryreply,[$comment->product_id,'ادمین','aliox300300@gmail.com',$textReply,$comment->id,1]);
        if ($action == true){
            header('location:list-comments.php?reply=success');
        }
    }else{
        $error = "متن پاسخ را باید وارد کنید";
    }
}

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">پاسخ به  نظر <?= $comment->name ?></div>
                <form method="post" >
                    <div class="form-group">
                        <textarea class="form-control" disabled rows="4" placeholder="متن نظر را بنویسید"><?= $comment->comment ?></textarea>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="reply" rows="4" placeholder="پاسخ به این  نظر را بنویسید"></textarea>
                    </div>

                    <button class="btn btn-success float-right" type="submit" name="btn_reply">پاسخ  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


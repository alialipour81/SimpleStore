<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])) {
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['editslide']) && $_GET['editslide'] >= 1) {
    $query = "SELECT * FROM slider WHERE id=?";
    $slider = $action->select($query, [(int)$_GET['editslide']]);
} else {
    header('location:list-slider.php');
}

// update
if (isset($_POST['btn_updateslide'])) {
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTMP = $file['tmp_name'];
    $fileSize = $file['size'];
    if (!empty($fileName)) {
       if ($fileType == 'image/png' || $fileType == 'image/jpg' || $fileType == 'image/jpeg'){
           $format = explode('.',$fileName);$format = end($format);
           $fileNameSave = 'image-'.time().rand(1000,10000000000000).'.'.$format;
           move_uploaded_file($fileTMP,'file_admin/slider/'.$fileNameSave);
           $query2 = "UPDATE slider SET image=? WHERE id=?";
           $action->inud($query2,[$fileNameSave,$slider->id]);
           if ($action == true){
               unlink('file_admin/slider/'.$slider->image);
               header('location:list-slider.php?update=success');
           }else{
               $error = 'خطایی ناشناخته رخ داد';
           }
       }else{
           $error = 'فایل شما یک تصویر نیست لطفا یک تصویر معتبر وارد کنید';
       }
    }else{
        $error = 'لطفا یک تصویر  جایگزین این اسلاید وارد کنید';
    }
}

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php' ?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php' ?>
                <div class="alert alert-secondary mt-2">ویرایش عکس اسلایدر</div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control" name="image">
                        <img src="<?= 'file_admin/slider/' . $slider->image ?>" width="100%" height="100%"
                             class="rounded shadow mt-2">
                    </div>
                    <button class="btn btn-primary float-right" type="submit" name="btn_updateslide">ویرایش</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once 'file_admin/head/footer.php' ?>


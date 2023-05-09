<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_POST['btn_addslide'])){
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTMP = $file['tmp_name'];
    $fileSize = $file['size'];
    if (!empty($fileName)){
        if ($fileType == 'image/png' || $fileType == 'image/jpeg' || $fileType == 'image/jpg' ){
           $format = explode('.',$fileName);$format = end($format);
           $fileNameSave = 'image-'.time().rand(1000,10000000000000).'.'.$format;
           move_uploaded_file($fileTMP,'file_admin/slider/'.$fileNameSave);
           $query = "INSERT INTO slider SET image=?";
           $action->inud($query,[$fileNameSave]);
           if ($action == true){
               $success = 'تصویر با موفقیت آپلود شد';
           }else{
               $error = 'خطایی ناشناخته رخ داده است';
           }
        }else{
            $error = 'فایل شما یک تصویر نیست لطفا یک تصویر معتبر وارد کنید';
        }
    }else{
        $error = 'لطفا یک تصویر وارد کنید';
    }
}

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">افزودن  عکس به اسلایدر</div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control" name="image" >
                    </div>
                    <button class="btn btn-primary float-right" type="submit" name="btn_addslide">افزودن  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


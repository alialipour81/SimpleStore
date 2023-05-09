<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

$query = "SELECT * FROM categories";
$categories = $action->select($query,[],'fetchAll');

if (isset($_POST['btn_addproduct'])){
    $category_id = $action->SecuriyInput($_POST['category_id']);
    $title = $action->SecuriyInput($_POST['title']);
    $seller = $action->SecuriyInput($_POST['seller']);
    $waran = $action->SecuriyInput($_POST['waran']);
    $brand = $action->SecuriyInput($_POST['brand']);
    $price = $action->SecuriyInput($_POST['price']);
    $pricem = $action->SecuriyInput($_POST['pricem']);
    $content = $action->SecuriyInput($_POST['content']);
    $tags = $action->SecuriyInput($_POST['tags']);
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $TmpName = $file['tmp_name'];
    if (!empty($category_id) && !empty($title) && !empty($seller) && !empty($waran) && !empty($brand) && !empty($price) && !empty($pricem) &&
    !empty($content) && !empty($tags) && !empty($fileName)) {
        $format = explode('.',$fileName);$format = end($format);
        if (in_array($format,['png','jpeg','jpg'])) {
            $fileNameSave = 'pro-' . time() . rand(10000, 11111111111111) . '.' . $format;
            move_uploaded_file($TmpName, 'file_admin/products/' . $fileNameSave);
            $queryAdd = "INSERT INTO products SET category_id=?,title=?,seller=?,waran=?,brand=?,price=?,pricem=?,content=?,tags=?,image=?";
            $action->inud($queryAdd, [
                $category_id, $title, $seller, $waran, $brand, $price, $pricem, $content, $tags, $fileNameSave
            ]);
            if ($action == true) {
                $success = 'محصول با موفقیت اضافه شد';
            } else {
                $error = 'خطای ناشناخته';
            }
        }else{
            $error = 'فایل شما باید حاوی تصویر باشد';
        }
    }else{
        $error = 'همه ورودی ها اجباری است';
    }
}

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">افزودن محصول  </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <select name="category_id" class="form-control">
                            <?php foreach ($categories as $category){ ?>
                            <option value="<?= $category->id ?>"> <?= $category->name ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="عنوان را بنویسید" >
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="seller" placeholder="فروشنده را بنویسید" >
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="waran" placeholder="گارانتی را بنویسید" >
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="brand" placeholder="برند را بنویسید" >
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="price" placeholder="قیمت فروش را بنویسید" >
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="pricem" placeholder="قیمت اصلی را بنویسید" >
                    </div>
                    <div class="form-group">
                        <textarea name="content" rows="4" class="form-control" placeholder="نقد وبررسی محصول"></textarea>
                    </div>
                    <div class="form-group">
                        <textarea name="tags" rows="2" class="form-control" placeholder="  برچسپ های محصول"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="image" >
                    </div>

                    <button class="btn btn-primary float-right" type="submit" name="btn_addproduct">افزودن  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


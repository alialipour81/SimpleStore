<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['editpro']) && $_GET['editpro'] >=1 ){
    $PID = (int) $_GET['editpro'];
    $query = "SELECT * FROM products WHERE id=?";
    $p_info = $action->select($query,[$PID]);
}else{
    header('location:');
}


if (isset($_POST['btn_updateproduct'])){
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
    !empty($content) && !empty($tags)) {
        $ErrorCount = 0;
        if (!empty($fileName)){
            $format = explode('.',$fileName);$format = end($format);
            if (in_array($format,['png','jpeg','jpg'])){
                $fileNameSave = 'pro-' . time() . rand(10000, 11111111111111) . '.' . $format;
                unlink('file_admin/products/'.$p_info->image);
                move_uploaded_file($TmpName, 'file_admin/products/' . $fileNameSave);
            }else{
                $error = 'فایل شما باید حاوی یک تصویر باشد';
                $ErrorCount = $ErrorCount+1;
            }
        }
        if ($ErrorCount == 0){
            if (isset($fileNameSave)){
                $fileName = $fileNameSave;
            }else{
                $fileName = $p_info->image;
            }
            $queryAdd = "UPDATE products SET category_id=?,title=?,seller=?,waran=?,brand=?,price=?,pricem=?,content=?,tags=?,image=? WHERE id=?";
            $action->inud($queryAdd, [
                $category_id, $title, $seller, $waran, $brand, $price, $pricem, $content, $tags, $fileName,$PID
            ]);
            if ($action == true) {
                header('location:list-products.php?update=success');
            } else {
                $error = 'خطای ناشناخته';
            }
        }

    }else{
        $error = 'همه ورودی ها اجباری است';
    }
}

$queryGetcats = "SELECT * FROM categories ORDER BY id DESC ";
$categories = $action->select($queryGetcats,[],'fetchAll');
?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">ویرایش محصول  </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <select name="category_id" class="form-control">
                            <?php foreach ($categories as $category){ ?>
                            <option value="<?= $category->id ?>"
                            <?php if ($p_info->category_id == $category->id){ ?> selected <?php } ?>
                            > <?= $category->name ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="عنوان را بنویسید" value="<?= $p_info->title ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="seller" placeholder="فروشنده را بنویسید" value="<?= $p_info->seller ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="waran" placeholder="گارانتی را بنویسید" value="<?= $p_info->waran ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="brand" placeholder="برند را بنویسید" value="<?= $p_info->brand ?>">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="price" placeholder="قیمت فروش را بنویسید" value="<?= $p_info->price ?>">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="pricem" placeholder="قیمت اصلی را بنویسید" value="<?= $p_info->pricem?>">
                    </div>
                    <div class="form-group">
                        <textarea name="content" rows="4" class="form-control" placeholder="نقد وبررسی محصول" ><?= $p_info->content ?></textarea>
                    </div>
                    <div class="form-group">
                        <textarea name="tags" rows="2" class="form-control" placeholder="  برچسپ های محصول"><?= $p_info->tags ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="image" >
                        <img src="<?= 'file_admin/products/'.$p_info->image ?>" width="300px" height="300px" class="rounded shadow my-2 ">
                    </div>

                    <button class="btn btn-primary float-right" type="submit" name="btn_updateproduct">ویرایش  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


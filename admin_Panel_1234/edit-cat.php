<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}

if (isset($_GET['catid']) && $_GET['catid'] >= 1){
    $query = "SELECT * FROM categories WHERE id=?";
    $infoCat = $action->select($query,[$action->SecuriyInput($_GET['catid'])]);
}
if (isset($_POST['btn_updatecategory'])){
    $name = $action->SecuriyInput($_POST['name']);$parent_id = $action->SecuriyInput($_POST['parent_id']);
    if (isset($name) && isset($parent_id) && !empty($name) ){
        $query2 = "UPDATE categories SET name=?,parent_id=? WHERE id=?";
        $action->inud($query2,[$name,$parent_id,$_GET['catid']]);
        if ($action == true){
            header('location:list-cat.php?update=success');
        }else{
            $error = 'خطایی در بروزرسانی این دسته بندی رخ داده است';
        }
    }else{
        $error = 'لطفا ورودی ها را پر کنید';
    }
}

// get all categories asli
$query3 = "SELECT * FROM categories WHERE parent_id=?";
$categories = $action->select($query3,[0],'fetchAll');


?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">ویرایش دسته بندی</div>
                <form method="post" >
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="نام را بنویسید" value="<?= $infoCat->name ?>">
                    </div>
                    <div class="form-group">
                        <select name="parent_id" class="form-control">
                            <option value="0">دسته بندی اصلی</option>
                            <?php foreach ($categories as $category){ ?>
                                <option value="<?= $category->id ?>"
                                <?php if ($category->id == $infoCat->parent_id){ ?> selected <?php } ?>
                                > <?= $category->name ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <button class="btn btn-primary float-right" type="submit" name="btn_updatecategory">ویرایش  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


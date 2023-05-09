<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}
// get all categories asli
$query = "SELECT * FROM categories WHERE parent_id=?";
$categories = $action->select($query,[0],'fetchAll');

if (isset($_POST['btn_addcategory'])){
    $name = $action->SecuriyInput($_POST['name']);
    $parent_id = $action->SecuriyInput($_POST['parent_id']);
    if (isset($name) && !empty($name)){
        $query2 = "INSERT INTO categories SET name=?,parent_id=?";
        $action->inud($query2,[$name,$parent_id]);
        if ($action == true){
            $success = 'دسته بندی با موفقیت ایجادشد';
        }else{
            $error = 'خطا در ایجاد دسته بندی';
        }
    }else{
        $error = 'لطفا ورودی هارا را پر کنید';
    }
}

?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox mt-5 text-light">
        <div class="container-fluid text-center">
            <div class="col-10 mx-auto ">
                <?php include_once 'file_admin/head/message.php'?>
                <div class="alert alert-secondary mt-2">افزودن دسته بندی</div>
                <form method="post" >
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="نام را بنویسید">
                    </div>
                    <div class="form-group">
                        <select name="parent_id" class="form-control">
                            <option value="0">دسته بندی اصلی</option>
                            <?php foreach ($categories as $category){ ?>
                                <option value="<?= $category->id ?>"> <?= $category->name ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <button class="btn btn-primary float-right" type="submit" name="btn_addcategory">افزودن  </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


<?php include_once 'file_admin/head/header.php';
if (!isset($_SESSION['name'])){
    header('location:index.php?ebteda=vorod');
}
?>
<div class="boxfather">
    <?php include_once 'file_admin/head/sidebar.php'?>
    <div class="leftbox">

    </div>
</div>



<?php include_once 'file_admin/head/footer.php'?>


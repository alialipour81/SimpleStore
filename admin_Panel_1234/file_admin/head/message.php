<?php if (isset($error)) { ?>
    <div class="alert-danger"><?= $error ?></div>
<?php } ?>
<?php if (isset($success)) { ?>
    <div class="alert-success"><?= $success ?></div>
<?php } ?>
<?php if (isset($_GET['update'])) { ?>
    <div class="alert-success">بروزرسانی با موفقیت انجام شد</div>
<?php } ?>
<?php if (isset($_GET['reply'])) { ?>
    <div class="alert-success">پاسخ با موفقیت ارسال شد</div>
<?php } ?>
<?php if (isset($_GET['afzoodan'])) { ?>
    <div class="alert-success">محصول با موفقیت به سبد خرید اضافه شد </div>
<?php } ?>

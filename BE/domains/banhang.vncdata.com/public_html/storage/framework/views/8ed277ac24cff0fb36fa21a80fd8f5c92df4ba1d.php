<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make('page.main.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body oncontextmenu="return false;" class="scroollbar-c">
<div id="jqxLoader"></div>

<div class="menu">
    <?php echo $__env->make('page.main.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<div class="main">
    <div class="content" id="content"></div>
</div>

<?php echo $__env->make('page.main.notify_center', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div id="notify">
    <div id="notify_content"></div>
</div>

<?php echo $__env->make('page.main.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>





</body>
</html>
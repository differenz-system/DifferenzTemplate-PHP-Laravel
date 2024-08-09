<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(env('PROJECT_NAME')); ?> | Dashboard</title>
    <?php echo $__env->make('Admin.template.headerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <div id="wrapper">
       
       <?php echo $__env->make('Admin.template.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="page-wrapper" class="gray-bg">
            
            <?php echo $__env->make('Admin.template.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="wrapper wrapper-content">
                
                
            </div>
            
            <?php echo $__env->make('Admin.template.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <?php echo $__env->make('Admin.template.footerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/html/DifferenzTemplateNew/resources/views//Admin/dashboard.blade.php ENDPATH**/ ?>
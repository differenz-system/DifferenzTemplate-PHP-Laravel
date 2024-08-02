<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title><?php echo e(env('PROJECT_NAME')); ?> | Login</title>
    <link rel="icon" target="_blank" href="<?php echo e(asset('storage/admin/images/favicon/favicon-16x16.png')); ?>" type="image/x-icon" >
    <link rel="shortcut icon" target="_blank" href="<?php echo e(asset('storage/admin/images/favicon/favicon-16x16.png')); ?>" type="image/x-icon" >
    <link href="<?php echo e(asset('adminAssets/css/main/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('adminAssets/css/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('adminAssets/css/main/animate.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('adminAssets/css/main/style.css')); ?>" rel="stylesheet">
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            
            <div>
                <img alt="image"  src="<?php echo e(asset('storage/admin/images/logo/logo.png')); ?>" style="width: 100%;">
            </div>
            
            <?php if(!empty(Session::get('message'))): ?>
            <div id ="msgs" class="alert alert-danger"><?php echo e(Session::get('message')); ?></div>
            <?php endif; ?>
            <form class="m-t" role="form" action="<?php echo e(asset('admin/login')); ?>" method="POST" id="admin-login-form" name="admin-login-form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input name="email" id="email" type="email" class="form-control" placeholder="Email Address" required="">
                </div>
                <div class="form-group">
                    <input name="password" id="password" type="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <p class="m-t"> <small><?php echo e(env('PROJECT_NAME')); ?> &copy; 2019</small> </p>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="<?php echo e(asset('adminAssets/js/main/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('adminAssets/js/main/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('adminAssets/js/main/bootstrap.js')); ?>"></script>
    <!-- Form- Validation  -->
    <script src="<?php echo e(asset('adminAssets/js/form-validation/jquery.validate.js')); ?>"></script>
    <script src="<?php echo e(asset('adminAssets/js/form-validation/additional-methods.min.js')); ?>"></script>
    <script src="<?php echo e(asset('adminAssets/js/form-validation/custom-form-validation.js')); ?>"></script>
    <script>
    $(document).ready(function ()
    {
        // login form validation
        $('#admin-login-form').validate({ // initialize the plugin
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "Please Enter Email Address.",
                    email: "Your email address must be in the format of name@domain.com"
                },
                password: {
                    required: "Please Enter Password.",
                }
            }
        });
    });    
    </script>
</body>
</html>
<?php /**PATH /var/www/html/DifferenzTemplateNew/resources/views//Admin/login.blade.php ENDPATH**/ ?>
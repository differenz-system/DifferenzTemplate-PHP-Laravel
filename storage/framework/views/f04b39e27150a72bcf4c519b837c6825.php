<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    
                    <?php $data = \App\Helper\Helper::LoggedUser(); ?>
                    <?php if($data->ProfilePicture == '' || $data->ProfilePicture == null): ?>
                        <?php $Image = asset('storage/admin/images/profile/user-not-found.png') ?>
                    <?php else: ?>
                        <?php if(file_exists(storage_path('admin/images/profile/'.$data->ProfilePicture))): ?>
                            <?php $Image = asset('storage/admin/images/profile').'/'.$data->ProfilePicture ?>
                        <?php else: ?>
                            <?php $Image = asset('storage/admin/images/profile/user-not-found.png') ?>
                        <?php endif; ?>
                    <?php endif; ?>  
                    <img style="height: 50px;width: 50px;" alt="image" class="rounded-circle" src="<?php echo e($Image); ?>"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo e(session('AdminName')); ?></span>
                        <span class="text-muted text-xs block">Admin <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="<?php echo e(url('admin/profile')); ?>">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo e(url('admin/logout')); ?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    DP
                </div>
            </li>
            <li class="<?php echo e(Request::segment(2) == 'dashboard'? 'active':''); ?>">
                <a href="<?php echo e(url('admin/dashboard')); ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="<?php echo e(Request::segment(2) == 'user'? 'active':''); ?>">
                <a href="<?php echo e(url('admin/user')); ?>"><i class="fa fa-users"></i> <span class="nav-label">User Listing</span></a>
            </li>
        </ul>
    </div>
</nav><?php /**PATH /var/www/html/DifferenzTemplateNew/resources/views/Admin/template/sidebar.blade.php ENDPATH**/ ?>
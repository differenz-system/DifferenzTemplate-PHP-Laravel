<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    {{-- @php $data = Helper::LoggedUser(); @endphp --}}
                    @php
                        $data = \App\Helper\Helper::LoggedUser();
                        $defaultImage = 'storage/admin/images/profile_pic/user-not-found.png';
                        $profileImagePath = 'storage/admin/images/profile_pic/' . $data->ProfilePicture;
                        $Image = file_exists(public_path($profileImagePath))
                            ? asset($profileImagePath)
                            : asset($defaultImage);
                    @endphp

                    <img style="height: 50px;width: 50px;" alt="image" class="rounded-circle"
                        src="{{ $Image }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ session('AdminName') }}</span>
                        <span class="text-muted text-xs block">Admin <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{ route('profile_page') }}">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    @php
                        $adminName = session('AdminName');
                        $initials = strtoupper($adminName[0]) . strtoupper(explode(' ', $adminName)[1][0]);
                    @endphp

                    {{ $initials }}
                </div>
            </li>
            <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}"><i class="fa fa-tachometer"></i> <span
                        class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{ Request::segment(2) == 'user' ? 'active' : '' }}">
                <a href="{{ url('admin/user') }}"><i class="fa fa-users"></i> <span class="nav-label">User
                        Listing</span></a>
            </li>
        </ul>
    </div>
</nav>

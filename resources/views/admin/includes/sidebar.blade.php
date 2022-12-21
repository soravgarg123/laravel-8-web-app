<aside id="sidebar">
    <!--| MAIN MENU |-->
    <ul class="side-menu"> 
        <li class="{{ (isset($module) && $module == 'dashboard') ? 'active' : '' }}">
            <a href="{{url('admin/dashboard')}}">
                <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i>
                <span>Dashboard</span> 
            </a>
        </li>
        <li class="{{ (isset($module) && $module == 'orders') ? 'active' : '' }}">
            <a href="{{url('admin/orders/list')}}">
                <i class="zmdi zmdi-shopping-cart zmdi-hc-fw"></i>
                <span>Manage Orders</span>
            </a>
        </li>
        <li class="{{ (isset($module) && $module == 'configurations') ? 'active' : '' }}">
            <a href="{{url('admin/configurations')}}">
                <i class="zmdi zmdi-settings zmdi-hc-fw"></i>
                <span>Manage Configurations</span>
            </a>
        </li>
        <li class="{{ (isset($module) && $module == 'profile') ? 'active' : '' }}">
            <a href="{{url('admin/edit-profile')}}">
                <i class="zmdi zmdi-account zmdi-hc-fw"></i>
                <span>Edit Profile Details</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="showConfirmationBox('Are you sure ?','Are you sure want to log-out? Yes /No','Yes','No','{{url('admin/dashboard/logout/')}}/{{Session::get('admin_user')['login_session_key']}}')">
                <i class="glyphicon glyphicon-log-out" style="margin-left:10px;margin-right:10px;"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>
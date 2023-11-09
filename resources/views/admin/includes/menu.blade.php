<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
    <div class="sidebar-brand-text mx-3"><img src="{{asset('backend/img/logo/logo-full.svg')}}" title="Nimbusbazar Admin" alt="Nimbusbazar Admin" /></div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
    <a class="nav-link" href="{{route('admin.dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
        <div class="sidebar-heading">Ecommerce</div>
    <li class="nav-item">
        <a class="nav-link" href="{{ action('Admin\BrandController@index') }}">
            <i class="fas fa-fw fa-bookmark"></i>
            <span>Brands</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ action('Admin\CategoryController@index') }}">
            <i class="fas fa-fw fa-list-ul"></i>
            <span>Categories</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="fas fa-fw fa-code-branch"></i>
          <span>Attributes</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ action('Admin\ColorController@index') }}">Colors</a>
            <a class="collapse-item" href="{{ action('Admin\SizeController@index') }}">Sizes</a>
          </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ action('Admin\ProductController@index') }}">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Products</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ action('Admin\OrderController@index') }}">
            <i class="fas fa-fw fa-shopping-bag"></i>
            <span>Orders</span>
        </a>
    </li>
    <hr class="sidebar-divider">
        <div class="sidebar-heading">Members</div>
    <li class="nav-item">
        <a class="nav-link" href="{{ action('Admin\AdminController@index') }}">
            <i class="fas fa-fw fa-adjust"></i>
            <span>Admins</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ action('Admin\MemberController@index') }}">
            <i class="fas fa-fw fa-adjust"></i>
            <span>Members</span>
        </a>
    </li>  
    <hr class="sidebar-divider">
        <div class="sidebar-heading">Settings</div>
        <li class="nav-item">
            <a class="nav-link" href="{{ action('Admin\PageController@index') }}">
                <i class="fas fa-fw fa-file-word"></i>
                <span>Pages</span>
            </a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="{{ action('Admin\BannerController@index') }}">
                <i class="fas fa-fw fa-image"></i>
                <span>Banners</span>
            </a>
        </li>    
</ul>
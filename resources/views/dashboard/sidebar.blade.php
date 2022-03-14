<div class="account-sidebar">
    <div class="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <a href="#" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Manage Account
                    </a>
                </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                data-parent="#accordionExample">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="{{ Request::is('dashboard') ? ' active' : 'normal' }}" href="{{action('Dashboard\DashboardController@index')}}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Request::is('profile') ? ' active' : 'normal' }}" href="{{action('Dashboard\ProfileController@index')}}">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Request::is('addressbook') ? ' active' : 'normal' }}" href="{{action('Dashboard\AddressbookController@index')}}">Address Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Request::is('orders') ? ' active' : 'normal' }}" href="{{action('Dashboard\OrderController@index')}}">My Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
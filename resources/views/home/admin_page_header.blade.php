<style>
    @media (max-width: 768px) {
        .nav {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .nav li,
        .nav .gradient-button {
            width: 100%;
            margin-bottom: 10px;
        }

        .nav .gradient-button a {
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px;
        }
    }

    .gradient-button {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <img src="assets/images/logo.png" alt="Chain App Dev">
                    </a>
                    <!-- ***** Logo End ***** -->

                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">

                        <!-- Buttons with icons and padding -->
                        <div class="gradient-button">
                            <a id="modal_trigger" href="{{ url('add_package_page') }}">
                                <i class="fa fa-plus-square"></i> Add Package
                            </a>
                        </div>

                        <div class="gradient-button">
                            <a id="modal_trigger" href="{{ url('view_package_page') }}">
                                <i class="fa fa-box-open"></i> View Package
                            </a>
                        </div>

                        <div class="gradient-button">
                            <a id="modal_trigger" href="{{ url('add_user_page') }}">
                                <i class="fa fa-user-plus"></i> Add User
                            </a>
                        </div>

                        <div class="gradient-button">
                            <a id="modal_trigger" href="{{ url('view_users_page') }}">
                                <i class="fa fa-users"></i> View Users
                            </a>
                        </div>

                        <div class="gradient-button">
                            <a id="modal_trigger" href="{{ url('bill_history_page') }}">
                                <i class="fa fa-money-bill-wave"></i> Bill History
                            </a>
                        </div>

                        @if (Route::has('login'))
                            <li style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                                @auth
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <div class="gradient-button">
                                            <a href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out-alt"></i> Logout
                                            </a>
                                        </div>
                                    </form>
                                @else
                                    <div class="gradient-button">
                                        <a id="modal_trigger" href="{{ route('login') }}">
                                            <i class="fa fa-sign-in-alt"></i> Login
                                        </a>
                                    </div>

                                    @if (Route::has('register'))
                                        <div class="gradient-button">
                                            <a id="modal_trigger" href="{{ route('register') }}">
                                                <i class="fa fa-user"></i> Register
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </li>
                        @endif

                    </ul>

                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->

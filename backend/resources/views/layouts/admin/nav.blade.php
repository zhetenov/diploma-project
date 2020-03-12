<nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
    <div class="container">
        <div class="navbar-brand">
            <span class="brand-text font-weight-light"><b>CRM</b>Box</span>
        </div>

        <div class="collapse navbar-collapse order-1"  id="navbarCollapse" style="font-size: large;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link tag="a" to="/users" class="nav-link {{ (request()->is('admin/users')) ? 'active' : '' }}">
                        Users
                    </router-link>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Statistics</a>
                </li>
                <li class="nav-item">
                    <a href="index3.html" class="nav-link">RFM Analyze</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Mailing</a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto order-2">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <form action="{{ route('logout') }}" method="POST" >
                    @csrf


                    <button class="btn btn-link" href="logout" style="color: #fff;">
                       Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
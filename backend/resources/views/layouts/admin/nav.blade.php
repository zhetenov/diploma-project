<nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
    <div class="container">
        <div class="navbar-brand">
            <span class="brand-text font-weight-light"><b>CRM</b>Box</span>
        </div>

        <div class="collapse navbar-collapse order-1"  id="navbarCollapse" style="font-size: large;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link tag="a" to="/users" class="nav-link" active-class="active">
                        Users
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" to="/statistics" class="nav-link" active-class="active">
                        Statistics
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" to="/rfm" class="nav-link" active-class="active">
                        RFM Analyze
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" to="/mailing" class="nav-link" active-class="active"
                    >
                        Mailing
                    </router-link>
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
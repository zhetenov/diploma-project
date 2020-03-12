<ul class="navbar-nav ml-auto order-2">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" >
            @csrf

        </form>
    </li>
</ul>


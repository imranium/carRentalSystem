<nav class="navbar navbar-expand-lg">
    <div class="container">

        @auth
            @php
                $role = Auth::user()->user_role;
            @endphp
            <a class="navbar-brand" 
            href="{{ route('dashboard.' . $role) }}">
            ECE CarBooking
            </a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">ECE CarBooking</a>
        @endauth


        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    {{-- Example: Role-based nav items --}}
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('cars.index') }}">Cars</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('staffs.index') }}">Staffs</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('branches.index') }}">Branches</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('customers.index') }}">Customers</a></li>
                    @elseif(auth()->user()->isStaff())
                        <li class="nav-item"><a class="nav-link" href="{{ route('cars.index') }}">Cars</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">Bookings</a></li>
                    @elseif(auth()->user()->isCustomer())
                        <li class="nav-item"><a class="nav-link" href="{{ route('bookings.availableCars') }}">Book a Car</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.bookings.index') }}">My Bookings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.show') }}">Profile</a></li>
                    @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

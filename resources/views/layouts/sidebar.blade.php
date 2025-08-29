<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Midone Tailwind HTML Admin Template" class="w-16" src="images/bluedale_logo_1.png">
        <span class="hidden xl:block text-white text-lg ml-3"><span class="font-medium">BGOC </span> Outdoor System </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('home.index') }}" class="side-menu {{ request()->routeIs('home.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                <div class="side-menu__title"> Home </div>
            </a>
        </li>

        <!-- billboard -->
        @if (Auth::guard('web')->user()->can('billboard.view'))
        <li>
            <a href="{{ route('billboard.index') }}" class="side-menu {{ request()->routeIs('billboard.index', 'billboard.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="layers"></i> </div>
                <div class="side-menu__title"> Billboard Master</div>
            </a>
        </li>
        @endif

        @if (Auth::guard('web')->user()->can('billboard_booking.view'))
        <li>
            <a href="{{ route('billboard.booking.index') }}" class="side-menu {{ request()->routeIs('billboard.booking.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="inbox"></i> </div>
                <div class="side-menu__title"> Monthly Ongoing </div>
            </a>
        </li>
        @endif

        @if (Auth::guard('web')->user()->can('billboard_booking.view'))
        <li>
            <a href="{{ route('billboard.availability.index') }}" class="side-menu {{ request()->routeIs('billboard.availability.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                <div class="side-menu__title"> Billboard Availability </div>
            </a>
        </li>
        @endif

        <!-- users -->
        @if (Auth::guard('web')->user()->can('user.view'))
        <li>
            <a href="{{ route('users') }}" class="side-menu {{ request()->routeIs('users') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Users </div>
            </a>
        </li>
        @endif

        <!-- clients -->
        @if (Auth::guard('web')->user()->can('client.view'))
        <li>
            <a href="{{ route('client-company.index') }}" class="side-menu {{ request()->routeIs('client-company.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                <div class="side-menu__title"> Clients </div>
            </a>
        </li>
        @endif


        <!-- management -->
        @if (Auth::guard('web')->user()->can('billboard.view'))
        <li>
            <a href="javascript:;" class="side-menu {{ request()->routeIs('contractors.index') || request()->routeIs('roles.index') || request()->routeIs('serviceRequest.category') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="monitor"></i> </div>
                <div class="side-menu__title">
                    Management 
                    <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs('contractors.index') || request()->routeIs('stockInventory.index') ? 'side-menu__sub-open' : '' }}">
            @if (Auth::guard('web')->user()->can('billboard.view'))
                <li>
                    <a href="{{ route('contractors.index') }}" class="side-menu {{ request()->routeIs('contractors.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                        <div class="side-menu__title"> Contractors </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stockInventory.index') }}" class="side-menu {{ request()->routeIs('stockInventory.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                        <div class="side-menu__title"> Stock Inventory </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users') }}" class="side-menu {{ request()->routeIs('users') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                        <div class="side-menu__title"> Users </div>
                    </a>
                </li>
            @endif
                <!-- @if (Auth::guard('web')->user()->can('role.view'))
                <li>
                    <a href="{{ route('roles.index') }}" class="side-menu {{ request()->routeIs('roles.index') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="server"></i> </div>
                        <div class="side-menu__title"> Roles </div>
                    </a>
                </li>
                @endif -->
                @if (Auth::guard('web')->user()->can('location.view'))
                <li>
                    <a href="{{ route('serviceRequest.category') }}" class="side-menu {{ request()->routeIs('serviceRequest.category') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="archive"></i> </div>
                        <div class="side-menu__title"> Location </div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
    </ul>
</nav>
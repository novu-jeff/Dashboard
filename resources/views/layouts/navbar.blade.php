<header class="header">
	<div class="header-content responsive-wrapper">

		{{-- LOGO --}}
		<div class="header-logo">
			<a href="#" class="nav-link text-uppercase fw-bold">
				<img src="{{ asset(config('app.product') === 'novustream'
                    ? 'images/novustreamlogo.png'
                    : 'images/novusurgelogo.png') }}"
				alt="Logo" style="width: 100px;">
			</a>
		</div>

		{{-- NAVIGATION --}}
		<div class="header-navigation">
			<div class="close-icon">
				<i class='bx bx-x'></i>
			</div>

			<nav class="header-navigation-links d-flex gap-4">

				{{-- DASHBOARD --}}
				<a href="{{ route('admin.dashboard') }}"> Dashboard </a>

				{{-- TRANSACTIONS --}}
				<a href="{{ route('admin.transactions.index') }}">
					Transactions
				</a>
                @can('super_admin')
                <a href="{{route('admin.personnel.index')}}">Personnels</a>
                @endcan

			</nav>

			{{-- RIGHT SIDE LINKS --}}
			<div class="header-navigation-links d-flex gap-4">
				<a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">Logout</a>

				<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			</div>
		</div>

		{{-- MOBILE MENU BUTTON --}}
		<a href="javascript:void(0)" class="button btn-navigate">
			<i class="ph-list-bold"></i>
			<span>Menu</span>
		</a>

	</div>
</header>

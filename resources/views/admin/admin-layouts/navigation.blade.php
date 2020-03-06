			<!-- Navigation start -->
			<nav class="navbar navbar-expand-lg custom-navbar">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#retailAdminNavbar" aria-controls="retailAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i></i>
						<i></i>
						<i></i>
					</span>
				</button>
				<div class="collapse navbar-collapse" id="retailAdminNavbar">
					<ul class="navbar-nav m-auto">
						<li class="nav-item">
							<a class="nav-link active-page" href="{{url('/admin/dashboard')}}">
								<i class="icon-devices_other nav-icon"></i>
								Dashboard
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{url('/admin/user-list')}}">
								<i class="icon-devices_other nav-icon"></i>
								Users
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{url('/admin/token-price')}}">
								<i class="icon-devices_other nav-icon"></i>
								Token Price
							</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-file nav-icon"></i>
								Withdrawal Requests 
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/admin/main-wallet-withdrawal-requests')}}">Main Wallet Withdrawal</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/admin/fix-holding-withdrawal-requests')}}">Fix Holding Withdrawal</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- Navigation end -->

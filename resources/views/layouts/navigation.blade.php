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
							<a class="nav-link active-page" href="{{route('home')}}">
								<i class="icon-devices_other nav-icon"></i>
								Dashboard
							</a>
						</li>
                    	<li class="nav-item">
							<a class="nav-link active-page" href="{{url('/profile')}}">
								<i class="icon-user1 nav-icon"></i>
								Profile
							</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-wallet nav-icon"></i>
								Main Wallet
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/buy-package')}}">Deposit</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/withdraw-main-wallet')}}">Withdraw</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/transfer-to-holding-wallet')}}">Transfer</a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-archive nav-icon"></i>
								My Packages
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/fix-plan')}}">Fix Plan</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/growth-plans')}}">Growth Plan</a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-users nav-icon"></i>
								Team
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/direct-referrals')}}">Direct Referral</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/all-referrals')}}">All Referral</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/downline')}}">Downline</a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-refresh-ccw nav-icon"></i>
								Transaction 
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/main-wallet-transaction')}}">Main Wallet Transaction</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/holding-wallet-transaction')}}">Holding Wallet Transaction</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/token-earning-report')}}">Token Wallet Transaction</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/comming-soon')}}">Token Transfer Transaction</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/comming-soon')}}">Withdrawal Transaction</a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-file nav-icon"></i>
								Reports 
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/comming-soon')}}">Transaction Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/main-wallet-transaction')}}">Withdrawal And Deposit Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/comming-soon')}}">Token Transfer Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/token-earning-report')}}">Token Earning Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/referral-income-report')}}">Referral Earning Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/comming-soon')}}">Daily Token Earning Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/comming-soon')}}">Token Sale Reports</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/token-holding-report')}}">Token Holding Reports</a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-chat nav-icon"></i>
								Support 
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="{{url('/generate-ticket')}}">Generate Ticket</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{url('/view-tickets')}}">View Tickets</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- Navigation end -->

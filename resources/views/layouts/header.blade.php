			<!-- Header start -->
			<header class="header">
				<!-- Row start -->
				<div class="row gutters">
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
						<a href="{{route('home')}}" class="logo"><img src="{{asset('img/BTC-Credit-Logo.png')}}" width="100"></a>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-6">
						<!-- Header actions start -->
						<ul class="header-actions">
							<li class="dropdown">
								<a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
									<span class="user-name">{{Auth::user()->first_name}}</span>
									<span class="avatar">{{substr(Auth::user()->first_name, 0, 1)}} {{substr(Auth::user()->last_name, 0, 1)}}<span class="status online"></span></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
									<div class="header-profile-actions">
										<div class="header-user-profile">
											<div class="header-user">
												<img src="img/user.png" alt="Reatil Admin" />
											</div>
											<h5>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h5>
											<p>Balance - ${{Auth::user()->main_wallet_balance}}</p>
										</div>
										<a href="{{url('/profile')}}"><i class="icon-user1"></i> My Profile</a>
										<a href="{{route('logout')}}"><i class="icon-log-out1"></i> Sign Out</a>
									</div>
								</div>
							</li>
						</ul>						
						<!-- Header actions end -->
					</div>
				</div>
				<!-- Row end -->
			</header>
			<!-- Header end -->

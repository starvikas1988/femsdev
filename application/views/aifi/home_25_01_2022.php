


    <div class="main-content page-content">
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">Dashboard</h5>
                        </div>
                    </div>
                </div>
            </div>

			<div class="row">
                <div class="col-xl-3 col-md-6 col-lg-12 stretched_card">
                    <div class="card mb-mob-4 icon_card primary_card_bg">
                        <div class="card-body">
                            <p class="card-title mb-0 text-white">
								Today Tickets/Flights
							</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 text-white">
									<?php foreach ($day_details as $key => $value) echo($value['count']) ;?> 
								</h3>
                                <div class="arrow_icon first-bg">
									<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
								</div>
                            </div>
                           <!--  <p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Today)</small></span></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-12 stretched_card">
                    <div class="card mb-mob-4 icon_card success_card_bg">
                        <div class="card-body">
                            <p class="card-title mb-0 text-white">
								Weekly Tickets/Flights
							</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 text-white">
									<?php foreach ($week_details as $key => $value) echo($value['count']) ;?> 
								</h3>
                                <div class="arrow_icon second-bg">
									<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
								</div>
                            </div>
                           <!--  <p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last Weekly)</small></span></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-12 stretched_card">
                    <div class="card mb-mob-4 icon_card warning_card_bg">
                        <div class="card-body">
                            <p class="card-title mb-0 text-white">
								Monthly Tickets/Flights
							</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 text-white">
								<?php foreach ($month_details as $key => $value) echo($value['count']) ;?> 
								</h3>
                                <div class="arrow_icon third-bg">
									<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
								</div>
                            </div>
                            <p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last month)</small></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-12 stretched_card">
                    <div class="card mb-mob-4 icon_card info_card_bg">
                        <div class="card-body">
                            <p class="card-title mb-0 text-white">
								Total ATH Time
							</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 text-white">
                                  <?php
                                  $time = new DateTime("0:0:0");
                                  $total_time = new DateTime("0:0:0");
                                  foreach($ath_details as $key => $value){
                                    $aht_time = new DateTime($value['total_time']);
                                    $interval = $aht_time->diff($time);
                                    $total_time->add($interval);
                                  }
                                  echo $time->diff($total_time)->format("%H:%I:%S");
                                  ?>
								</h3>
                                <div class="arrow_icon four-bg">
									<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
								</div>
                            </div>
                            <p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>
                        </div>
                    </div>
                </div>
            </div>

			<div class="common-top">
				<div class="middle-content">
					<div class="row">
						<div class="col-sm-6">
							<div class="white-dash">
								<canvas id="bar-chart" width="400" height="400"></canvas>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="white-dash">
								<canvas id="pie-chart" width="400" height="400"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="common-top">
				<div class="middle-content">
					<div class="row">
						<div class="col-sm-12">
							<div class="white-dash">
								<canvas id="full-chart" width="200" height="300"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
    </div>

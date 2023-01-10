@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

					<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-3">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__('Surveys carried out today')}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="truck"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_carry_day"></h1>
												<div class="mb-0">
													<span class="text-danger" id="survey_carry_percentatge"></span>
													<span class="text-muted">{{__("Since last day")}}</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__('Surveys carried out month')}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="dollar-sign"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_carry_month"></h1>
												<div class="mb-0">
													<span class="text-danger" id="survey_carry_percentatge_month"></span>
													<span class="text-muted">{{__("Since last month")}}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__("Surveys open today")}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_total_day"></h1>
												<div class="mb-0">
													<span class="text-success" id="survey_total_percentatge"></span>
													<span class="text-muted">{{__('Complete today')}}</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__("Surveys open month")}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="shopping-cart"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_total_month"></h1>
												<div class="mb-0">
													<span class="text-danger" id="survey_total_percentatge_month"></span>
													<span class="text-muted">{{__("Complete month")}}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__("Incidence today")}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_incidence_day"></h1>
												<div class="mb-0">
													<span class="text-success" id="survey_incidence_percentatge"></span>
													<span class="text-muted">{{__('Incidence today')}}</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__("Incidence month")}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="shopping-cart"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_incidence_month"></h1>
												<div class="mb-0">
													<span class="text-danger" id="survey_incidence_percentatge_month"></span>
													<span class="text-muted">{{__('Incidence month')}}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-xxl-3">
									<div class="card flex-fill w-100">
										<div class="card-header">

											<h5 class="card-title mb-0">{{__("Survey's status in this month")}}</h5>
										</div>
										<div class="card-body d-flex">
											<div class="align-self-center w-100">
												<div class="py-3">
													<div class="chart chart-xs">
														<canvas id="pie_answer_status"></canvas>
													</div>
												</div>

												<span id="pie_answer_body"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						

						<!--<div class="col-xl-3 col-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Recent Movement</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="chartjs-dashboard-line"></canvas>
									</div>
								</div>
							</div>
						</div>-->
					</div>

					<!--
					<div class="row">
						<div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Browser Usage</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>

										<table class="table mb-0">
											<tbody>
												<tr>
													<td>Chrome</td>
													<td class="text-end">4306</td>
												</tr>
												<tr>
													<td>Firefox</td>
													<td class="text-end">3801</td>
												</tr>
												<tr>
													<td>IE</td>
													<td class="text-end">1689</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2" id="worldMap">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0 d-flex justify-content-between align-items-center">
										Real-Time
										<button type="button" class="btn" onclick="pantallaCompleta('worldMap')"id="actworldMap" ><i class="align-middle" data-feather="maximize-2"></i></button>
										<button type="button" class="btn" onclick="pantallaCompleta('worldMap')"  style="display:none;" id="desworldMap"><i class="align-middle" data-feather="minimize-2"></i></button>
									</h5>
								</div>
								<div class="card-body px-4">
									<div id="world_map" style="height:350px;"></div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Calendar</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="chart">
											<div id="datetimepicker-dashboard"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					<div class="col-xl-12 col-xxl-12 d-flex">
						<div class="w-100">
							<div class="row">
								<div class="col-sm-3">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col mt-0">
													<h5 class="card-title">{{__('Surveys not answered this week')}}</h5>
												</div>

												<div class="col-auto">
													<div class="stat text-primary">
														<i class="align-middle" data-feather="truck"></i>
													</div>
												</div>
											</div>
											<h1 class="mt-1 mb-3" id="answers_waiting"></h1>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 col-lg-8 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<h5 class="card-title mb-0">{{__("Incidence Control Today")}}</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>{{__("Store's code")}}</th>
											<th class="d-none d-md-table-cell">{{__("Store's name")}}</th>
											<th class="d-none d-md-table-cell">{{__("Owner")}}</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="body_incidence"></tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-lg-4 col-xxl-3 d-flex" id="evolution">
							<div class="card flex-fill w-100">
								<div class="card-header" onclick="pantallaCompleta('evolution') "id="actevolution">

									<h5 class="card-title mb-0">{{__("Evolution")}}</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg" id="evolutionChart">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
@endsection

@section('javascript')
<script>
		
		/* When the openFullscreen() function is executed, open the video in fullscreen.
		Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet */
		function pantallaCompleta(element) { 
			if(element == 'evolution') {
				$('#evolutionChart').css('height',"90vh");
			}
			var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
				(document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
				(document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
				(document.msFullscreenElement && document.msFullscreenElement !== null);
			var elem = document.getElementById(element);
			if (!isInFullScreen) {
				if (elem.requestFullscreen) {
					elem.requestFullscreen();
				} else if (elem.webkitRequestFullscreen) { /* Safari */
					elem.webkitRequestFullscreen();
				} else if (elem.msRequestFullscreen) { /* IE11 */
					elem.msRequestFullscreen();
				}
				//$('#act'+element).css('display','none');
				//$('#des'+element).css('display','block');
			} else {
				if (elem.exitFullscreen) {
					elem.exitFullscreen();
				} else if (elem.webkitExitFullscreen) {
					elem.webkitExitFullscreen();
				} else if (elem.mozCancelFullScreen) {
					elem.mozCancelFullScreen();
				} else if (elem.msExitFullscreen) {
					elem.msExitFullscreen();
				}
				$('#act'+element).css('display','block');
				$('#des'+element).css('display','none');
			}
		}
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales ($)",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: [
                        2115,
                        1562,
                        1584,
                        1892,
                        1587,
                        1923,
                        2566,
                        2448,
                        2805,
                        3438,
                        2917,
                        3327
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 1000
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["Chrome", "Firefox", "IE"],
                datasets: [{
                    data: [4306, 3801, 1689],
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 75
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var markers = [{
                coords: [31.230391, 121.473701],
                name: "Shanghai"
            },
            {
                coords: [28.704060, 77.102493],
                name: "Delhi"
            },
            {
                coords: [6.524379, 3.379206],
                name: "Lagos"
            },
            {
                coords: [35.689487, 139.691711],
                name: "Tokyo"
            },
            {
                coords: [23.129110, 113.264381],
                name: "Guangzhou"
            },
            {
                coords: [40.7127837, -74.0059413],
                name: "New York"
            },
            {
                coords: [34.052235, -118.243683],
                name: "Los Angeles"
            },
            {
                coords: [41.878113, -87.629799],
                name: "Chicago"
            },
            {
                coords: [51.507351, -0.127758],
                name: "London"
            },
            {
                coords: [40.416775, -3.703790],
                name: "Madrid "
            }
        ];
        var map = new jsVectorMap({
            map: "world",
            selector: "#world_map",
            zoomButtons: true,
            markers: markers,
            markerStyle: {
                initial: {
                    r: 9,
                    strokeWidth: 7,
                    stokeOpacity: .4,
                    fill: window.theme.primary
                },
                hover: {
                    fill: window.theme.primary,
                    stroke: window.theme.primary
                }
            },
            zoomOnScroll: false
        });
        window.addEventListener("resize", () => {
            map.updateSize();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
        var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
        document.getElementById("datetimepicker-dashboard").flatpickr({
            inline: true,
            prevArrow: "<span title=\"Previous month\">&laquo;</span>",
            nextArrow: "<span title=\"Next month\">&raquo;</span>",
            defaultDate: defaultDate
        });
    });
</script>
<script>

function dashboards() {
	$.get('/api/answers/today/carried', function(data) {
		//Panel 1
		$('#survey_carry_day').html(data.finish);
		$('#survey_carry_percentatge').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.porcentage+'%');
		if(data.porcentage>=0) {
			$('#survey_carry_percentatge').removeClass();
			$('#survey_carry_percentatge').addClass('text-success');
		}
		//Panel 2
		$('#survey_total_day').html(data.total);
		$('#survey_total_percentatge').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.complete+'%');
		if(data.complete>=0) {
			$('#survey_total_percentatge').removeClass();
			$('#survey_total_percentatge').addClass('text-success');
		}
		//Panel 3
		$('#survey_incidence_day').html(data.incidence);
		$('#survey_incidence_percentatge').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.incidence_yesterday+'%');
		if(data.incidence_yesterday<0) {
			$('#survey_incidence_percentatge').removeClass();
			$('#survey_incidence_percentatge').addClass('text-success');
		}
	});
	$.get('/api/answers/month/carried', function(data) {
		//Panel 4
		$('#survey_carry_month').html(data.finish);
		$('#survey_carry_percentatge_month').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.porcentage+'%');
		if(data.porcentage>=0) {
			$('#survey_carry_percentatge_month').removeClass();
			$('#survey_carry_percentatge_month').addClass('text-success');
		}
		//Panel 5
		$('#survey_total_month').html(data.total);
		$('#survey_total_percentatge_month').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.complete+'%');
		if(data.complete>=0) {
			$('#survey_total_percentatge_month').removeClass();
			$('#survey_total_percentatge_month').addClass('text-success');
		}
		//Panel 6
		$('#survey_incidence_month').html(data.incidence);
		$('#survey_incidence_percentatge_month').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.incidence_yesterday+'%');
		if(data.incidence_yesterday<0) {
			$('#survey_incidence_percentatge_month').removeClass();
			$('#survey_incidence_percentatge_month').addClass('text-success');
		}
	});
	$.get('/api/answers/month/type', function(res) {
		new Chart(document.getElementById("pie_answer_status"), {
            type: "bar",
            data: {
                labels: ["{{__('Open')}}", "{{__('Assigned')}}", "{{__('Completed by QC')}}", "{{__('Send')}}", "{{__('Review')}}", "{{__('Complete')}}", "{{__('Cancelled')}}"],
                datasets: [{
                    data: [res.open, res.assigned, res.qc, res.send, res.review, res.complete, res.cancel],
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
						window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
						window.theme.primary,
                        window.theme.warning,
                        window.theme.danger
                    ],
                    //borderWidth: 5
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: true,
                legend: {
                    display: false
                },
                cutoutPercentage: 75
            }
        });
		
	})

	$.get('/api/answers/waiting', function(res) {
		$('#answers_waiting').html(res);
	})

	$.get('/api/incidence/today', function(res) {
		$("#body_incidence").html('');
		res.forEach(function(incidence){
			$tr = "<tr><td>"+incidence['store']+"</td><td>"+incidence['store_name']+"</td><td>"+incidence['responsable']+"</td><td><a href='/incidences/"+incidence['id']+"' class='btn btn-outline-info'>{{__('View more')}}</a></td></tr>";
			$("#body_incidence").append($tr);
		})

	});

	$.get('/api/evolution', function(res) {
		// Bar chart
        new Chart(document.getElementById("chartjs-dashboard-bar"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "General",
					borderColor: 'rgb(0, 134, 255)',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.general.results[0], res.Feb.general.results[0], res.Mar.general.results[0], res.Apr.general.results[0], res.May.general.results[0], res.Jun.general.results[0], res.Jul.general.results[0], res.Aug.general.results[0], res.Sep.general.results[0], res.Oct.general.results[0], res.Nov.general.results[0], res.Dec.general.results[0]],
                }, {
					borderColor: '#488f31',
					label: 'Equipo 1',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq1.results[0], res.Feb.eq1.results[0], res.Mar.eq1.results[0], res.Apr.eq1.results[0], res.May.eq1.results[0], res.Jun.eq1.results[0], res.Jul.eq1.results[0], res.Aug.eq1.results[0], res.Sep.eq1.results[0], res.Oct.eq1.results[0], res.Nov.eq1.results[0], res.Dec.eq1.results[0]],
				}, {
					borderColor: '#75a760',
					label: 'Equipo 2',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq2.results[0], res.Feb.eq2.results[0], res.Mar.eq2.results[0], res.Apr.eq2.results[0], res.May.eq2.results[0], res.Jun.eq2.results[0], res.Jul.eq2.results[0], res.Aug.eq2.results[0], res.Sep.eq2.results[0], res.Oct.eq2.results[0], res.Nov.eq2.results[0], res.Dec.eq2.results[0]],
				}, {
					borderColor: '#9fc08f',
					label: 'Equipo 3',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq3.results[0], res.Feb.eq3.results[0], res.Mar.eq3.results[0], res.Apr.eq3.results[0], res.May.eq3.results[0], res.Jun.eq3.results[0], res.Jul.eq3.results[0], res.Aug.eq3.results[0], res.Sep.eq3.results[0], res.Oct.eq3.results[0], res.Nov.eq3.results[0], res.Dec.eq3.results[0]],
				}, {
					borderColor: '#c8d8bf',
					label: 'Equipo 4',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq4.results[0], res.Feb.eq4.results[0], res.Mar.eq4.results[0], res.Apr.eq4.results[0], res.May.eq4.results[0], res.Jun.eq4.results[0], res.Jul.eq4.results[0], res.Aug.eq4.results[0], res.Sep.eq4.results[0], res.Oct.eq4.results[0], res.Nov.eq4.results[0], res.Dec.eq4.results[0]],
				}, {
					borderColor: '#f1f1f1',
					label: 'Equipo 5',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq5.results[0], res.Feb.eq5.results[0], res.Mar.eq5.results[0], res.Apr.eq5.results[0], res.May.eq5.results[0], res.Jun.eq5.results[0], res.Jul.eq5.results[0], res.Aug.eq5.results[0], res.Sep.eq5.results[0], res.Oct.eq5.results[0], res.Nov.eq5.results[0], res.Dec.eq5.results[0]],
				}, {
					borderColor: '#f1c6c6',
					label: 'Equipo 6',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq6.results[0], res.Feb.eq6.results[0], res.Mar.eq6.results[0], res.Apr.eq6.results[0], res.May.eq6.results[0], res.Jun.eq6.results[0], res.Jul.eq6.results[0], res.Aug.eq6.results[0], res.Sep.eq6.results[0], res.Oct.eq6.results[0], res.Nov.eq6.results[0], res.Dec.eq6.results[0]],
				}, {
					borderColor: '#ec9c9d',
					label: 'Equipo 7',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq7.results[0], res.Feb.eq7.results[0], res.Mar.eq7.results[0], res.Apr.eq7.results[0], res.May.eq7.results[0], res.Jun.eq7.results[0], res.Jul.eq7.results[0], res.Aug.eq7.results[0], res.Sep.eq7.results[0], res.Oct.eq7.results[0], res.Nov.eq7.results[0], res.Dec.eq7.results[0]],
				}, {
					borderColor: '#e27076',
					label: 'Equipo 8',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq8.results[0], res.Feb.eq8.results[0], res.Mar.eq8.results[0], res.Apr.eq8.results[0], res.May.eq8.results[0], res.Jun.eq8.results[0], res.Jul.eq8.results[0], res.Aug.eq8.results[0], res.Sep.eq8.results[0], res.Oct.eq8.results[0], res.Nov.eq8.results[0], res.Dec.eq8.results[0]],
				}, {
					borderColor: '#de425b',
					label: 'Equipo 9',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.eq9.results[0], res.Feb.eq9.results[0], res.Mar.eq9.results[0], res.Apr.eq9.results[0], res.May.eq9.results[0], res.Jun.eq9.results[0], res.Jul.eq9.results[0], res.Aug.eq9.results[0], res.Sep.eq9.results[0], res.Oct.eq9.results[0], res.Nov.eq9.results[0], res.Dec.eq9.results[0]],
				}]
            },
            options: {
				responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true
                        },
						min: 2,
                        stacked: false,
                        ticks: {
							min: 3,
                            stepSize: 0.10
                        }
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        }
                    }]
                }
            }
        });
	})



}

dashboards();
setInterval(dashboards,300000);

</script>
@endsection
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
														<h5 class="card-title">{{__("Surveys cancelled today")}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_cancel_day"></h1>
												<div class="mb-0">
													<span class="text-success" id="survey_cancel_percentatge"></span>
													<span class="text-muted">{{__('Cancelled today')}}</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{__("Surveys cancelled month")}}</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="shopping-cart"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3" id="survey_cancel_month"></h1>
												<div class="mb-0">
													<span class="text-danger" id="survey_cancel_percentatge_month"></span>
													<span class="text-muted">{{__('Cancelled month')}}</span>
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
					</div>

					<div class="row">
						<div class="col-12 col-lg-8 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Latest Projects</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Name</th>
											<th class="d-none d-xl-table-cell">Start Date</th>
											<th class="d-none d-xl-table-cell">End Date</th>
											<th>Status</th>
											<th class="d-none d-md-table-cell">Assignee</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Project Apollo</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-success">Done</span></td>
											<td class="d-none d-md-table-cell">Vanessa Tucker</td>
										</tr>
										<tr>
											<td>Project Fireball</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-danger">Cancelled</span></td>
											<td class="d-none d-md-table-cell">William Harris</td>
										</tr>
										<tr>
											<td>Project Hades</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-success">Done</span></td>
											<td class="d-none d-md-table-cell">Sharon Lessman</td>
										</tr>
										<tr>
											<td>Project Nitro</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-warning">In progress</span></td>
											<td class="d-none d-md-table-cell">Vanessa Tucker</td>
										</tr>
										<tr>
											<td>Project Phoenix</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-success">Done</span></td>
											<td class="d-none d-md-table-cell">William Harris</td>
										</tr>
										<tr>
											<td>Project X</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-success">Done</span></td>
											<td class="d-none d-md-table-cell">Sharon Lessman</td>
										</tr>
										<tr>
											<td>Project Romeo</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-success">Done</span></td>
											<td class="d-none d-md-table-cell">Christina Mason</td>
										</tr>
										<tr>
											<td>Project Wombat</td>
											<td class="d-none d-xl-table-cell">01/01/2021</td>
											<td class="d-none d-xl-table-cell">31/06/2021</td>
											<td><span class="badge bg-warning">In progress</span></td>
											<td class="d-none d-md-table-cell">William Harris</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-lg-4 col-xxl-3 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">{{__("Evolution")}}</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
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
				$('#act'+element).css('display','none');
				$('#des'+element).css('display','block');
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
/* Petición a la api: Daniel Molina */
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
		$('#survey_cancel_day').html(data.cancelled);
		$('#survey_cancel_percentatge').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.cancelled_yesterday+'%');
		if(data.cancelled_yesterday<0) {
			$('#survey_cancel_percentatge').removeClass();
			$('#survey_cancel_percentatge').addClass('text-success');
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
		$('#survey_cancel_month').html(data.cancelled);
		$('#survey_cancel_percentatge_month').html('<i class="mdi mdi-arrow-bottom-right"></i>'+data.cancelled_yesterday+'%');
		if(data.cancelled_yesterday<0) {
			$('#survey_cancel_percentatge_month').removeClass();
			$('#survey_cancel_percentatge_month').addClass('text-success');
		}
	});
	$.get('/api/answers/month/type', function(res) {
		/*text = '<table class="table mb-0"><tbody><tr><td>Abiertos</td><td class="text-end">'+res.open+'</td></tr>';
		text += '<tr><td>Asignados</td><td class="text-end">'+res.assigned+'</td></tr>';
		text += '<tr><td>Cerrados por QC</td><td class="text-end">'+res.qc+'</td></tr>';
		text += '<tr><td>Enviados</td><td class="text-end">'+res.send+'</td></tr>';
		text += '<tr><td>Pendientes Revision</td><td class="text-end">'+res.review+'</td></tr>';
		text += '<tr><td>Completados</td><td class="text-end">'+res.complete+'</td></tr>';
		text += '<tr><td>Cancelados</td><td class="text-end">'+res.cancel+'</td></tr></tbody></table>';
		$('#pie_answer_body').html(text);*/
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

	$.get('/api/evolution', function(res) {
		// Bar chart
		console.log(res.May.results[0]);
        new Chart(document.getElementById("chartjs-dashboard-bar"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "This year",
					borderColor: 'rgb(75,192,192)',
					tension: 0.1,
					fill: false,
                    data: [res.Jan.results[0], res.Feb.results[0], res.Mar.results[0], res.Apr.results[0], res.May.results[0], res.Jun.results[0], res.Jul.results[0], res.Aug.results[0], res.Sep.results[0], res.Oct.results[0], res.Nov.results[0], res.Dec.results[0]],
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 10
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
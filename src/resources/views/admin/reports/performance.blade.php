@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">System Performance</h1>
        </div>

        <!-- Performance Metrics -->
        <div class="row">
            <!-- Server Uptime -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Server Uptime</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="uptimeChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Uptime
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-danger"></i> Downtime
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Time -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Response Time (Last 30 Days)</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="responseTimeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Metrics -->
        <div class="row">
            <!-- Database Performance -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Database Performance</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Metric</th>
                                        <th>Value</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Query Response Time</td>
                                        <td>{{ $dbMetrics['query_time'] }} ms</td>
                                        <td>
                                            @if($dbMetrics['query_time'] < 100)
                                                <span class="badge badge-success">Excellent</span>
                                            @elseif($dbMetrics['query_time'] < 300)
                                                <span class="badge badge-warning">Good</span>
                                            @else
                                                <span class="badge badge-danger">Poor</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Connections</td>
                                        <td>{{ $dbMetrics['connections'] }}</td>
                                        <td>
                                            @if($dbMetrics['connections'] < 50)
                                                <span class="badge badge-success">Normal</span>
                                            @elseif($dbMetrics['connections'] < 100)
                                                <span class="badge badge-warning">High</span>
                                            @else
                                                <span class="badge badge-danger">Critical</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Resources -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">System Resources</h6>
                    </div>
                    <div class="card-body">
                        <h4 class="small font-weight-bold">CPU Usage <span class="float-right">{{ $systemMetrics['cpu'] }}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-{{ $systemMetrics['cpu'] < 60 ? 'success' : ($systemMetrics['cpu'] < 80 ? 'warning' : 'danger') }}" 
                                 role="progressbar" style="width: {{ $systemMetrics['cpu'] }}%" 
                                 aria-valuenow="{{ $systemMetrics['cpu'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Memory Usage <span class="float-right">{{ $systemMetrics['memory'] }}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-{{ $systemMetrics['memory'] < 60 ? 'success' : ($systemMetrics['memory'] < 80 ? 'warning' : 'danger') }}" 
                                 role="progressbar" style="width: {{ $systemMetrics['memory'] }}%" 
                                 aria-valuenow="{{ $systemMetrics['memory'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Disk Usage <span class="float-right">{{ $systemMetrics['disk'] }}%</span></h4>
                        <div class="progress">
                            <div class="progress-bar bg-{{ $systemMetrics['disk'] < 60 ? 'success' : ($systemMetrics['disk'] < 80 ? 'warning' : 'danger') }}" 
                                 role="progressbar" style="width: {{ $systemMetrics['disk'] }}%" 
                                 aria-valuenow="{{ $systemMetrics['disk'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Uptime Chart
        var ctx = document.getElementById("uptimeChart");
        var uptimeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Uptime", "Downtime"],
                datasets: [{
                    data: [{{ $uptimePercentage }}, {{ 100 - $uptimePercentage }}],
                    backgroundColor: ['#1cc88a', '#e74a3b'],
                    hoverBackgroundColor: ['#17a673', '#be2617'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });

        // Response Time Chart
        var ctx2 = document.getElementById("responseTimeChart");
        var responseTimeChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode($responseTimeLabels) !!},
                datasets: [{
                    label: "Response Time (ms)",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: {!! json_encode($responseTimeData) !!},
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return value + 'ms';
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + tooltipItem.yLabel + 'ms';
                        }
                    }
                }
            }
        });
    </script>
@endsection
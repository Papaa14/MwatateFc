@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Fan Details</h1>
        <div>
            <a href="{{ route('fans.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Fans
            </a>
            @if(!$fan->is_banned)
                <button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm ml-2" 
                        id="banFanBtn" data-id="{{ $fan->id }}">
                    <i class="fas fa-ban fa-sm text-white-50"></i> Ban Fan
                </button>
            @else
                <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ml-2" 
                        id="unbanFanBtn" data-id="{{ $fan->id }}">
                    <i class="fas fa-check-circle fa-sm text-white-50"></i> Unban Fan
                </button>
            @endif
            <button class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm ml-2" 
                    id="toggleStatusBtn" 
                    data-id="{{ $fan->id }}"
                    data-status="{{ $fan->is_active ? 'active' : 'inactive' }}">
                <i class="fas {{ $fan->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} fa-sm text-white-50"></i> 
                {{ $fan->is_active ? 'Deactivate' : 'Activate' }}
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                    <span class="badge badge-{{ $fan->is_banned ? 'danger' : ($fan->is_active ? 'success' : 'secondary') }}">
                        {{ $fan->is_banned ? 'Banned' : ($fan->is_active ? 'Active' : 'Inactive') }}
                    </span>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $fan->avatar_url ?: asset('images/default-avatar.png') }}" 
                         class="rounded-circle mb-3" width="150" height="150" 
                         alt="{{ $fan->name }}">
                    <h4>{{ $fan->name }}</h4>
                    <p class="text-muted">Member since {{ $fan->created_at->format('M Y') }}</p>
                    
                    <div class="text-left mt-4">
                        <p><i class="fas fa-envelope mr-2"></i> {{ $fan->email }}</p>
                        @if($fan->phone)
                            <p><i class="fas fa-phone mr-2"></i> {{ $fan->phone }}</p>
                        @endif
                        @if($fan->birthdate)
                            <p><i class="fas fa-birthday-cake mr-2"></i> {{ $fan->birthdate->format('M d, Y') }} (Age: {{ $fan->age }})</p>
                        @endif
                        @if($fan->gender)
                            <p><i class="fas fa-venus-mars mr-2"></i> {{ ucfirst($fan->gender) }}</p>
                        @endif
                        @if($fan->city && $fan->country)
                            <p><i class="fas fa-map-marker-alt mr-2"></i> {{ $fan->city }}, {{ $fan->country }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Status</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Email Verified
                            @if($fan->email_verified_at)
                                <span class="badge badge-success badge-pill">Yes</span>
                            @else
                                <span class="badge badge-warning badge-pill">No</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Last Login
                            @if($fan->last_login_at)
                                <span>{{ $fan->last_login_at->diffForHumans() }}</span>
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Login Count
                            <span>{{ $fan->login_count ?: 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            IP Address
                            <span>{{ $fan->last_login_ip ?: 'Unknown' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Activity</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="activityFilter" 
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar fa-sm fa-fw text-gray-400"></i>
                            Time Range
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                             aria-labelledby="activityFilter">
                            <a class="dropdown-item" href="#" data-range="week">Last 7 Days</a>
                            <a class="dropdown-item" href="#" data-range="month">Last 30 Days</a>
                            <a class="dropdown-item" href="#" data-range="year">Last Year</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-range="all">All Time</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Favorites</h6>
                        </div>
                        <div class="card-body">
                            @if($fan->favorites->count() > 0)
                                <div class="list-group">
                                    @foreach($fan->favorites->take(5) as $favorite)
                                        <a href="{{ $favorite->url }}" class="list-group-item list-group-item-action">
                                            {{ $favorite->name }}
                                        </a>
                                    @endforeach
                                </div>
                                @if($fan->favorites->count() > 5)
                                    <div class="text-center mt-2">
                                        <small class="text-muted">+{{ $fan->favorites->count() - 5 }} more</small>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">No favorites yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Actions</h6>
                        </div>
                        <div class="card-body">
                            @if($fan->activities->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($fan->activities->take(5) as $activity)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $activity->description }}</span>
                                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($fan->activities->count() > 5)
                                    <div class="text-center mt-2">
                                        <small class="text-muted">+{{ $fan->activities->count() - 5 }} more</small>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">No recent activity.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                </div>
                <div class="card-body">
                    <form id="notesForm" action="{{ route('fans.update-notes', $fan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $fan->notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Notes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle fan status
        $('#toggleStatusBtn').click(function() {
            const fanId = $(this).data('id');
            const currentStatus = $(this).data('status');
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            
            $.ajax({
                url: "{{ route('fans.toggle-status', '') }}/" + fanId,
                method: 'PATCH',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => { location.reload(); }, 1000);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || 'Error updating status');
                }
            });
        });

        // Ban fan
        $('#banFanBtn').click(function() {
            const fanId = $(this).data('id');
            
            if(confirm('Are you sure you want to ban this fan?')) {
                $.ajax({
                    url: "{{ route('fans.ban', '') }}/" + fanId,
                    method: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(() => { location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || 'Error banning fan');
                    }
                });
            }
        });

        // Unban fan
        $('#unbanFanBtn').click(function() {
            const fanId = $(this).data('id');
            
            if(confirm('Are you sure you want to unban this fan?')) {
                $.ajax({
                    url: "{{ route('fans.unban', '') }}/" + fanId,
                    method: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(() => { location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || 'Error unbanning fan');
                    }
                });
            }
        });

        // Activity Chart
        var ctx = document.getElementById('activityChart');
        var activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($activityData['labels']) !!},
                datasets: [{
                    label: 'Activity Count',
                    data: {!! json_encode($activityData['data']) !!},
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)"
                        }
                    }]
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
                    caretPadding: 10
                }
            }
        });

        // Filter activity by time range
        $('.dropdown-item[data-range]').click(function(e) {
            e.preventDefault();
            const range = $(this).data('range');
            
            $.ajax({
                url: "{{ route('fans.activity-data', $fan->id) }}",
                method: 'GET',
                data: {
                    range: range
                },
                success: function(response) {
                    activityChart.data.labels = response.labels;
                    activityChart.data.datasets[0].data = response.data;
                    activityChart.update();
                    toastr.success('Activity data updated');
                },
                error: function(xhr) {
                    toastr.error('Error loading activity data');
                }
            });
        });
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Training Sessions</h1>
            <p class="lead">Manage and review team training activities</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('trainings.create') }}" class="btn btn-primary">Schedule New Session</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Upcoming Sessions</h3>
                <a href="{{ route('trainings.calendar') }}" class="btn btn-sm btn-outline-secondary">View Calendar</a>
            </div>
        </div>
        <div class="card-body">
            @if($upcomingSessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Duration</th>
                                <th>Focus Area</th>
                                <th>Location</th>
                                <th>Coach</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingSessions as $session)
                            <tr>
                                <td>
                                    {{ $session->datetime->format('D, M j, Y') }}<br>
                                    <small>{{ $session->datetime->format('g:i a') }}</small>
                                </td>
                                <td>{{ $session->duration }} mins</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $session->focus == 'fitness' ? 'danger' : 
                                        ($session->focus == 'technical' ? 'info' : 
                                        ($session->focus == 'tactical' ? 'warning' : 'success')) 
                                    }}">
                                        {{ ucfirst($session->focus) }}
                                    </span>
                                </td>
                                <td>{{ $session->location }}</td>
                                <td>{{ $session->coach->name }}</td>
                                <td>
                                    <a href="{{ route('trainings.show', $session->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('trainings.attendance', $session->id) }}" class="btn btn-sm btn-outline-success">Attendance</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No upcoming training sessions scheduled.</div>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Recent Sessions</h3>
        </div>
        <div class="card-body">
            @if($recentSessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Focus Area</th>
                                <th>Attendance</th>
                                <th>Intensity</th>
                                <th>Coach Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSessions as $session)
                            <tr>
                                <td>{{ $session->datetime->format('M j, Y') }}</td>
                                <td>{{ ucfirst($session->focus) }}</td>
                                <td>
                                    {{ $session->attendance_count }}/{{ $session->expected_players }}
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-{{ $session->attendance_percentage >= 80 ? 'success' : ($session->attendance_percentage >= 60 ? 'warning' : 'danger') }}" 
                                             style="width: {{ $session->attendance_percentage }}%">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-{{ $i <= $session->intensity ? 'fire' : 'fire-alt' }} text-{{ $i <= $session->intensity ? 'danger' : 'secondary' }}"></i>
                                    @endfor
                                </td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-{{ $i <= $session->coach_rating ? 'warning' : 'secondary' }}"></i>
                                    @endfor
                                </td>
                                <td>
                                    <a href="{{ route('trainings.review', $session->id) }}" class="btn btn-sm btn-outline-info">Review</a>
                                    <a href="{{ route('trainings.drills', $session->id) }}" class="btn btn-sm btn-outline-primary">Drills</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No recent training sessions found.</div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Training Focus Distribution</h4>
                </div>
                <div class="card-body">
                    <canvas id="focusChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Attendance Trends</h4>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Focus Distribution Chart
    const focusCtx = document.getElementById('focusChart').getContext('2d');
    new Chart(focusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($focusStats->pluck('focus')),
            datasets: [{
                data: @json($focusStats->pluck('count')),
                backgroundColor: [
                    '#FF6384', // fitness
                    '#36A2EB', // technical
                    '#FFCE56', // tactical
                    '#4BC0C0'  // other
                ]
            }]
        },
        options: {
            responsive: true
        }
    });

    // Attendance Trends Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: @json($attendanceTrends->pluck('month')),
            datasets: [{
                label: 'Attendance Rate %',
                data: @json($attendanceTrends->pluck('attendance_rate')),
                borderColor: '#4BC0C0',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>
@endpush
@endsection
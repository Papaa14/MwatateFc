@extends('layouts.coach')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Match Analysis: {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
        <div>
            <a href="{{ route('coach.matches.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Matches
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Match Overview</h6>
                    <span class="badge badge-light">
                        {{ $match->match_date->format('M j, Y H:i') }} | {{ $match->competition->name }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-5">
                            <img src="{{ $match->homeTeam->logo_url }}" width="80" height="80" class="mb-2">
                            <h4>{{ $match->homeTeam->name }}</h4>
                            @if($match->status == 'completed')
                                <h2 class="font-weight-bold">{{ $match->result->home_team_score }}</h2>
                            @endif
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <h3 class="font-weight-bold">VS</h3>
                        </div>
                        <div class="col-md-5">
                            <img src="{{ $match->awayTeam->logo_url }}" width="80" height="80" class="mb-2">
                            <h4>{{ $match->awayTeam->name }}</h4>
                            @if($match->status == 'completed')
                                <h2 class="font-weight-bold">{{ $match->result->away_team_score }}</h2>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $match->venue->name ?? $match->homeTeam->stadium }}</p>
                            <p class="mb-1"><i class="fas fa-whistle"></i> Referee: {{ $match->referee ?? 'TBD' }}</p>
                            <p class="mb-0"><i class="fas fa-info-circle"></i> Status: 
                                <span class="badge badge-{{ $match->status == 'scheduled' ? 'primary' : ($match->status == 'in_progress' ? 'warning' : ($match->status == 'completed' ? 'success' : 'secondary')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $match->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Team Statistics</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" data-stat="possession">Possession</a>
                            <a class="dropdown-item" href="#" data-stat="shots">Shots</a>
                            <a class="dropdown-item" href="#" data-stat="passes">Passes</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-stat="all">All Statistics</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="teamStatsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Key Moments</h6>
                </div>
                <div class="card-body">
                    @if($match->keyMoments->count() > 0)
                        <div class="timeline">
                            @foreach($match->keyMoments as $moment)
                            <div class="timeline-item {{ $moment->is_home_team ? 'home-team' : 'away-team' }}">
                                <div class="timeline-time">
                                    {{ $moment->minute }}'
                                    @if($moment->added_time)
                                        +{{ $moment->added_time }}
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-icon">
                                        @if($moment->event_type == 'goal')
                                            <i class="fas fa-futbol text-success"></i>
                                        @elseif($moment->event_type == 'yellow_card')
                                            <i class="fas fa-square text-warning"></i>
                                        @elseif($moment->event_type == 'red_card')
                                            <i class="fas fa-square text-danger"></i>
                                        @elseif($moment->event_type == 'substitution')
                                            <i class="fas fa-exchange-alt text-info"></i>
                                        @else
                                            <i class="fas fa-flag text-primary"></i>
                                        @endif
                                    </div>
                                    <div class="timeline-text">
                                        <strong>{{ $moment->player->name ?? 'Team' }}</strong> - 
                                        {{ ucfirst(str_replace('_', ' ', $moment->event_type)) }}
                                        @if($moment->event_type == 'goal' && $moment->assist_player_id)
                                            (Assist: {{ $moment->assistPlayer->name }})
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No key moments recorded for this match.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Player Performance</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th title="Rating">⭐</th>
                                    <th title="Goals">⚽</th>
                                    <th title="Assists">🅰️</th>
                                    <th title="Pass Accuracy">%</th>
                                    <th title="Distance (km)">🏃</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($match->playerPerformances as $performance)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $performance->player->photo_url }}" width="30" height="30" class="rounded-circle mr-2">
                                            {{ $performance->player->name }}
                                        </div>
                                    </td>
                                    <td>{{ $performance->rating }}</td>
                                    <td>{{ $performance->goals }}</td>
                                    <td>{{ $performance->assists }}</td>
                                    <td>{{ $performance->pass_accuracy }}%</td>
                                    <td>{{ $performance->distance_covered }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Heatmap</h6>
                </div>
                <div class="card-body">
                    <div class="pitch-container">
                        <div class="pitch">
                            <div class="heatmap-overlay" style="background-image: url('{{ asset('images/pitch.png') }}')">
                                <!-- Heatmap data would be rendered here -->
                            </div>
                        </div>
                        <div class="heatmap-legend">
                            <span>Low</span>
                            <div class="legend-gradient"></div>
                            <span>High</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Match Notes</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('coach.matches.save-notes', $match->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" id="match_notes" name="notes" rows="5">{{ old('notes', $match->coach_notes) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Notes</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-item.home-team:before {
        background-color: #4e73df;
    }
    .timeline-item.away-team:before {
        background-color: #e74a3b;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }
    .timeline-time {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .timeline-content {
        background-color: #f8f9fc;
        padding: 10px;
        border-radius: 5px;
        position: relative;
    }
    .timeline-icon {
        position: absolute;
        left: -40px;
        top: 5px;
    }
    .timeline-text {
        margin-left: 10px;
    }
    .pitch-container {
        position: relative;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }
    .pitch {
        position: relative;
        padding-bottom: 66.67%; /* 3:2 aspect ratio */
        background-color: #2e8b57;
        overflow: hidden;
    }
    .heatmap-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        opacity: 0.7;
    }
    .heatmap-legend {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
    }
    .legend-gradient {
        width: 200px;
        height: 20px;
        margin: 0 10px;
        background: linear-gradient(to right, blue, green, yellow, red);
    }
</style>
@endsection

@section('scripts')
<script>
    // Team Statistics Chart
    var ctx = document.getElementById("teamStatsChart");
    var teamStatsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Possession", "Shots", "Shots on Target", "Passes", "Pass Accuracy", "Fouls", "Corners"],
            datasets: [
                {
                    label: "{{ $match->homeTeam->short_name }}",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [{{ $match->stats->home_possession }}, 
                           {{ $match->stats->home_shots }}, 
                           {{ $match->stats->home_shots_on_target }}, 
                           {{ $match->stats->home_passes }}, 
                           {{ $match->stats->home_pass_accuracy }}, 
                           {{ $match->stats->home_fouls }}, 
                           {{ $match->stats->home_corners }}]
                },
                {
                    label: "{{ $match->awayTeam->short_name }}",
                    backgroundColor: "#e74a3b",
                    hoverBackgroundColor: "#be2617",
                    borderColor: "#e74a3b",
                    data: [{{ $match->stats->away_possession }}, 
                           {{ $match->stats->away_shots }}, 
                           {{ $match->stats->away_shots_on_target }}, 
                           {{ $match->stats->away_passes }}, 
                           {{ $match->stats->away_pass_accuracy }}, 
                           {{ $match->stats->away_fouls }}, 
                           {{ $match->stats->away_corners }}]
                }
            ]
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
                        beginAtZero: true
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)"
                    }
                }]
            },
            legend: {
                display: true,
                position: 'top'
            }
        }
    });

    // Filter statistics
    $('.dropdown-item[data-stat]').click(function(e) {
        e.preventDefault();
        const stat = $(this).data('stat');
        
        // This would typically be an AJAX call to filter the data
        // For now, we'll just show an alert
        toastr.info('Filtering by: ' + stat);
    });
</script>
@endsection
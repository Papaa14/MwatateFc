@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Team Performance Report</h1>
            <p class="lead">Comparative analysis of team statistics</p>
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-success" onclick="window.print()">Print Report</button>
            <a href="{{ route('reports.individual-stats') }}" class="btn btn-info">View Player Report</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Report Filters</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.team-performance') }}">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="season">Season</label>
                        <select class="form-control" id="season" name="season">
                            <option value="">All Seasons</option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}" {{ request('season') == $season->id ? 'selected' : '' }}>
                                    {{ $season->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="competition">Competition</label>
                        <select class="form-control" id="competition" name="competition">
                            <option value="">All Competitions</option>
                            @foreach($competitions as $competition)
                                <option value="{{ $competition->id }}" {{ request('competition') == $competition->id ? 'selected' : '' }}>
                                    {{ $competition->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sort">Sort By</label>
                        <select class="form-control" id="sort" name="sort">
                            <option value="points" {{ request('sort') == 'points' ? 'selected' : '' }}>Points</option>
                            <option value="goals_for" {{ request('sort') == 'goals_for' ? 'selected' : '' }}>Goals Scored</option>
                            <option value="goal_difference" {{ request('sort') == 'goal_difference' ? 'selected' : '' }}>Goal Difference</option>
                            <option value="wins" {{ request('sort') == 'wins' ? 'selected' : '' }}>Wins</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('reports.team-performance') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Team Performance Summary</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Rank</th>
                            <th>Team</th>
                            <th>Played</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>GD</th>
                            <th>Points</th>
                            <th>Form</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $index => $team)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($team->logo)
                                        <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="team-logo mr-2">
                                    @endif
                                    <strong>{{ $team->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $team->matches_played }}</td>
                            <td>{{ $team->wins }}</td>
                            <td>{{ $team->draws }}</td>
                            <td>{{ $team->losses }}</td>
                            <td>{{ $team->goals_for }}</td>
                            <td>{{ $team->goals_against }}</td>
                            <td class="{{ $team->goal_difference > 0 ? 'text-success' : ($team->goal_difference < 0 ? 'text-danger' : '') }}">
                                {{ $team->goal_difference > 0 ? '+' : '' }}{{ $team->goal_difference }}
                            </td>
                            <td class="font-weight-bold">{{ $team->points }}</td>
                            <td>
                                @foreach($team->recent_form as $result)
                                    <span class="badge badge-{{ $result == 'W' ? 'success' : ($result == 'D' ? 'warning' : 'danger') }}">
                                        {{ $result }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Attack Statistics</h4>
                </div>
                <div class="card-body">
                    <canvas id="attackStatsChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Defense Statistics</h4>
                </div>
                <div class="card-body">
                    <canvas id="defenseStatsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3>Team Comparison</h3>
        </div>
        <div class="card-body">
            <canvas id="teamComparisonChart" height="300"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attack Stats Chart
    const attackCtx = document.getElementById('attackStatsChart').getContext('2d');
    new Chart(attackCtx, {
        type: 'bar',
        data: {
            labels: @json($teams->pluck('name')),
            datasets: [
                {
                    label: 'Goals Scored',
                    data: @json($teams->pluck('goals_for')),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Shots per Game',
                    data: @json($teams->pluck('shots_per_game')),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Defense Stats Chart
    const defenseCtx = document.getElementById('defenseStatsChart').getContext('2d');
    new Chart(defenseCtx, {
        type: 'bar',
        data: {
            labels: @json($teams->pluck('name')),
            datasets: [
                {
                    label: 'Goals Conceded',
                    data: @json($teams->pluck('goals_against')),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Clean Sheets',
                    data: @json($teams->pluck('clean_sheets')),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Team Comparison Chart
    const comparisonCtx = document.getElementById('teamComparisonChart').getContext('2d');
    new Chart(comparisonCtx, {
        type: 'radar',
        data: {
            labels: ['Attack', 'Defense', 'Possession', 'Pass Accuracy', 'Discipline', 'Set Pieces'],
            datasets: @json($radarChartData)
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    angleLines: {
                        display: true
                    },
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            }
        }
    });
</script>
@endpush

<style>
    .team-logo {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }
</style>
@endsection
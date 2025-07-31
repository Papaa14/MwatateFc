@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Individual Player Statistics Report</h1>
            <p class="lead">Detailed performance metrics for players</p>
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-success" onclick="window.print()">Print Report</button>
            <a href="{{ route('reports.team-performance') }}" class="btn btn-info">View Team Report</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Report Filters</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.individual-stats') }}">
                <div class="form-row">
                    <div class="form-group col-md-3">
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
                    <div class="form-group col-md-3">
                        <label for="team">Team</label>
                        <select class="form-control" id="team" name="team">
                            <option value="">All Teams</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ request('team') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="position">Position</label>
                        <select class="form-control" id="position" name="position">
                            <option value="">All Positions</option>
                            <option value="Goalkeeper" {{ request('position') == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                            <option value="Defender" {{ request('position') == 'Defender' ? 'selected' : '' }}>Defender</option>
                            <option value="Midfielder" {{ request('position') == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                            <option value="Forward" {{ request('position') == 'Forward' ? 'selected' : '' }}>Forward</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="min_matches">Min Matches Played</label>
                        <input type="number" class="form-control" id="min_matches" name="min_matches" 
                               value="{{ request('min_matches', 5) }}" min="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('reports.individual-stats') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Player Statistics</h3>
                <span class="badge badge-primary">Total Players: {{ $players->total() }}</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th rowspan="2">Player</th>
                            <th rowspan="2">Team</th>
                            <th rowspan="2">Pos</th>
                            <th rowspan="2">Matches</th>
                            <th colspan="3" class="text-center">Goals</th>
                            <th colspan="3" class="text-center">Assists</th>
                            <th rowspan="2">Avg Rating</th>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>Per Match</th>
                            <th>Penalty</th>
                            <th>Total</th>
                            <th>Per Match</th>
                            <th>Key Passes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                        <tr>
                            <td>
                                <a href="{{ route('players.show', $player->id) }}">
                                    {{ $player->name }}
                                </a>
                            </td>
                            <td>{{ $player->team->name ?? 'N/A' }}</td>
                            <td>{{ $player->position }}</td>
                            <td>{{ $player->matches_played }}</td>
                            <td>{{ $player->total_goals }}</td>
                            <td>{{ number_format($player->goals_per_match, 2) }}</td>
                            <td>{{ $player->penalty_goals }}</td>
                            <td>{{ $player->total_assists }}</td>
                            <td>{{ number_format($player->assists_per_match, 2) }}</td>
                            <td>{{ $player->key_passes }}</td>
                            <td>
                                <span class="badge badge-{{ $player->avg_rating >= 7.5 ? 'success' : ($player->avg_rating >= 6 ? 'warning' : 'danger') }}">
                                    {{ number_format($player->avg_rating, 1) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $players->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Top Scorers</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topScorers as $index => $player)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <span class="font-weight-bold">{{ $index + 1 }}.</span>
                                {{ $player->name }} ({{ $player->team->short_name ?? 'N/A' }})
                            </span>
                            <span class="badge badge-primary badge-pill">{{ $player->total_goals }} goals</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Top Assists</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topAssists as $index => $player)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <span class="font-weight-bold">{{ $index + 1 }}.</span>
                                {{ $player->name }} ({{ $player->team->short_name ?? 'N/A' }})
                            </span>
                            <span class="badge badge-success badge-pill">{{ $player->total_assists }} assists</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
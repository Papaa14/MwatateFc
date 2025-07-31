@extends('layouts.coach')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Match Management</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addMatchModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Match
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Upcoming Matches</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingMatchesCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Matches This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyMatchesCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Win Rate</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $winRate }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                             style="width: {{ $winRate }}%" 
                                             aria-valuenow="{{ $winRate }}" 
                                             aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Goals Scored</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGoals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-futbol fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Match Schedule</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter fa-sm fa-fw text-gray-400"></i> Filter
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('coach.matches.index', ['filter' => 'upcoming']) }}">Upcoming</a>
                    <a class="dropdown-item" href="{{ route('coach.matches.index', ['filter' => 'past']) }}">Past Matches</a>
                    <a class="dropdown-item" href="{{ route('coach.matches.index', ['filter' => 'home']) }}">Home Matches</a>
                    <a class="dropdown-item" href="{{ route('coach.matches.index', ['filter' => 'away']) }}">Away Matches</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('coach.matches.index') }}">All Matches</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="matchesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Match</th>
                            <th>Competition</th>
                            <th>Venue</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                        <tr>
                            <td>
                                {{ $match->match_date->format('M j, Y') }}<br>
                                <small class="text-muted">{{ $match->match_date->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $match->homeTeam->logo_url }}" width="30" height="30" class="mr-2">
                                    {{ $match->homeTeam->short_name }} vs 
                                    <img src="{{ $match->awayTeam->logo_url }}" width="30" height="30" class="ml-2 mr-2">
                                    {{ $match->awayTeam->short_name }}
                                </div>
                            </td>
                            <td>{{ $match->competition->name }}</td>
                            <td>{{ $match->venue->name ?? $match->homeTeam->stadium }}</td>
                            <td>
                                @if($match->status == 'scheduled')
                                    <span class="badge badge-primary">Scheduled</span>
                                @elseif($match->status == 'in_progress')
                                    <span class="badge badge-warning">In Progress</span>
                                @elseif($match->status == 'completed')
                                    <span class="badge badge-{{ $match->result->is_win ? 'success' : ($match->result->is_draw ? 'info' : 'danger') }}">
                                        {{ $match->result->full_time_score }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">Postponed</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('coach.matches.prepare', $match->id) }}" class="btn btn-info btn-sm" title="Prepare">
                                        <i class="fas fa-clipboard-list"></i>
                                    </a>
                                    <a href="{{ route('coach.matches.lineup', $match->id) }}" class="btn btn-warning btn-sm" title="Lineup">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <a href="{{ route('coach.matches.analyze', $match->id) }}" class="btn btn-primary btn-sm" title="Analyze">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Match Modal -->
<div class="modal fade" id="addMatchModal" tabindex="-1" role="dialog" aria-labelledby="addMatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMatchModalLabel">Add New Match</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('coach.matches.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="match_date">Date & Time *</label>
                                <input type="datetime-local" class="form-control" id="match_date" name="match_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="competition_id">Competition *</label>
                                <select class="form-control" id="competition_id" name="competition_id" required>
                                    @foreach($competitions as $competition)
                                        <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="home_team_id">Home Team *</label>
                                <select class="form-control" id="home_team_id" name="home_team_id" required>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ $team->id == auth()->user()->team_id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="away_team_id">Away Team *</label>
                                <select class="form-control" id="away_team_id" name="away_team_id" required>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ $team->id == auth()->user()->team_id ? 'disabled' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="venue_id">Venue</label>
                                <select class="form-control" id="venue_id" name="venue_id">
                                    <option value="">Use Home Team Stadium</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="referee">Referee</label>
                                <input type="text" class="form-control" id="referee" name="referee">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Match</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#matchesTable').DataTable({
            responsive: true,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [5] }
            ]
        });

        // Set default datetime to now + 1 hour
        const now = new Date();
        now.setHours(now.getHours() + 1);
        document.getElementById('match_date').value = now.toISOString().slice(0, 16);
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Performance Stats: {{ $player->name }}</h1>
            <p class="lead">{{ $player->position }} | {{ $player->team->name ?? 'N/A' }} | #{{ $player->jersey_number }}</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('players.index') }}" class="btn btn-secondary">Back to Players</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Season Statistics</h3>
        </div>
        <div class="card-body">
            @if($player->performances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Match Date</th>
                                <th>Opponent</th>
                                <th>Goals</th>
                                <th>Assists</th>
                                <th>Minutes Played</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($player->performances as $performance)
                            <tr>
                                <td>{{ $performance->match_date->format('M d, Y') }}</td>
                                <td>{{ $performance->opponent }}</td>
                                <td>{{ $performance->goals }}</td>
                                <td>{{ $performance->assists }}</td>
                                <td>{{ $performance->minutes_played }}</td>
                                <td>{{ number_format($performance->rating, 1) }}/10</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="2"><strong>Season Totals/Averages</strong></td>
                                <td><strong>{{ $player->performances->sum('goals') }}</strong></td>
                                <td><strong>{{ $player->performances->sum('assists') }}</strong></td>
                                <td><strong>{{ $player->performances->sum('minutes_played') }}</strong></td>
                                <td><strong>{{ number_format($player->performances->avg('rating'), 1) }}/10</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No performance records found for this player.</div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Performance Record</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('players.performance.store', $player->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="match_date">Match Date</label>
                            <input type="date" class="form-control" id="match_date" name="match_date" required>
                        </div>
                        <div class="form-group">
                            <label for="opponent">Opponent</label>
                            <input type="text" class="form-control" id="opponent" name="opponent" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="goals">Goals</label>
                                <input type="number" class="form-control" id="goals" name="goals" min="0" value="0">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="assists">Assists</label>
                                <input type="number" class="form-control" id="assists" name="assists" min="0" value="0">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="minutes_played">Minutes Played</label>
                                <input type="number" class="form-control" id="minutes_played" name="minutes_played" min="0" max="120" value="90">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating (1-10)</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" step="0.1" value="6.0">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Performance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
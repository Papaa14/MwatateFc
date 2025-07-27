@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Tactics Dashboard</h1>
            <p class="lead">Manage your team's tactical approach</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('tactics.formations.create') }}" class="btn btn-primary">New Formation</a>
            <a href="{{ route('tactics.strategies.create') }}" class="btn btn-success ml-2">New Strategy</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Favorite Formations</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($favoriteFormations as $formation)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h5>{{ $formation->name }}</h5>
                                    <div class="formation-preview mt-2 mb-3">
                                        {!! $formation->visual_pattern !!}
                                    </div>
                                    <a href="{{ route('tactics.formations.show', $formation->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('tactics.formations.index') }}" class="btn btn-primary">View All Formations</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Recent Strategies</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($recentStrategies as $strategy)
                        <a href="{{ route('tactics.strategies.show', $strategy->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $strategy->title }}</h5>
                                <small>{{ $strategy->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($strategy->description, 100) }}</p>
                            <small>Used with: {{ $strategy->formation->name }}</small>
                        </a>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('tactics.strategies.index') }}" class="btn btn-success">View All Strategies</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Tactical Analysis</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h2 class="display-4">{{ $stats['most_used_formation_count'] }}</h2>
                            <p class="lead">Matches with<br>{{ $stats['most_used_formation'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h2 class="display-4">{{ $stats['win_rate'] }}%</h2>
                            <p class="lead">Win Rate with<br>{{ $stats['best_formation'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h2 class="display-4">{{ $stats['goals_per_match'] }}</h2>
                            <p class="lead">Avg Goals with<br>Attacking Strategies</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .formation-preview {
        font-family: monospace;
        white-space: pre;
        line-height: 1;
        font-size: 12px;
    }
</style>
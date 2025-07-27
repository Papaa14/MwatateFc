@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Player Details</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('players.index') }}" class="btn btn-secondary">Back to Players</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($player->photo)
                        <img src="{{ asset('storage/' . $player->photo) }}" alt="{{ $player->name }}" class="img-fluid rounded mb-3" style="max-height: 300px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px; width: 100%;">
                            <span class="text-muted">No photo available</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h2>{{ $player->name }}</h2>
                    <p class="lead">
                        {{ $player->position }} | 
                        {{ $player->team->name ?? 'N/A' }} | 
                        #{{ $player->jersey_number }}
                    </p>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <ul class="list-unstyled">
                                <li><strong>Date of Birth:</strong> {{ $player->date_of_birth->format('F j, Y') }}</li>
                                <li><strong>Age:</strong> {{ $player->date_of_birth->age }}</li>
                                <li><strong>Nationality:</strong> {{ $player->nationality }}</li>
                                <li><strong>Height:</strong> {{ $player->height }} cm</li>
                                <li><strong>Weight:</strong> {{ $player->weight }} kg</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Career Information</h5>
                            <ul class="list-unstyled">
                                <li><strong>Contract Start:</strong> {{ $player->contract_start->format('F j, Y') }}</li>
                                <li><strong>Contract End:</strong> {{ $player->contract_end->format('F j, Y') }}</li>
                                <li><strong>Salary:</strong> ${{ number_format($player->salary, 2) }}</li>
                                <li><strong>Preferred Foot:</strong> {{ ucfirst($player->preferred_foot) }}</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>About</h5>
                        <p>{{ $player->bio ?? 'No biography available.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Performance Summary</h3>
                <a href="{{ route('players.performance', $player->id) }}" class="btn btn-sm btn-primary">View Full Performance</a>
            </div>
        </div>
        <div class="card-body">
            @if($player->performances->count() > 0)
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="display-4">{{ $player->performances->sum('goals') }}</div>
                        <div class="text-muted">Goals</div>
                    </div>
                    <div class="col-md-3">
                        <div class="display-4">{{ $player->performances->sum('assists') }}</div>
                        <div class="text-muted">Assists</div>
                    </div>
                    <div class="col-md-3">
                        <div class="display-4">{{ $player->performances->count() }}</div>
                        <div class="text-muted">Matches Played</div>
                    </div>
                    <div class="col-md-3">
                        <div class="display-4">{{ number_format($player->performances->avg('rating'), 1) }}</div>
                        <div class="text-muted">Average Rating</div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">No performance records found for this player.</div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning">Edit Player</a>
        <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this player?')">Delete Player</button>
        </form>
    </div>
</div>
@endsection
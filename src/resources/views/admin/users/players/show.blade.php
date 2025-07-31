@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Player Details</h1>
        <div>
            <a href="{{ route('players.edit', $player->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Player
            </a>
            <a href="{{ route('players.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Players
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                    <span class="badge badge-{{ $player->status == 'active' ? 'success' : 
                                              ($player->status == 'injured' ? 'warning' : 
                                              ($player->status == 'suspended' ? 'danger' : 'secondary')) }}">
                        {{ ucfirst($player->status) }}
                    </span>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $player->photo_url ?: asset('images/default-player.png') }}" 
                         class="rounded-circle mb-3" width="150" height="150" 
                         alt="{{ $player->full_name }}">
                    <h3>{{ $player->full_name }}</h3>
                    <h5 class="text-primary mb-3">#{{ $player->jersey_number }} | {{ $player->position }}</h5>
                    
                    @if($player->team)
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <img src="{{ $player->team->logo_url ?: asset('images/default-team.png') }}" 
                                 class="mr-2" width="30" height="30" alt="{{ $player->team->name }}">
                            <span>{{ $player->team->name }}</span>
                            @if($player->is_captain)
                                <span class="badge badge-warning ml-2">Captain</span>
                            @endif
                        </div>
                    @endif

                    <div class="text-left mt-4">
                        <p><i class="fas fa-birthday-cake mr-2"></i> 
                            {{ $player->birth_date->format('F j, Y') }} (Age: {{ $player->age }})
                        </p>
                        <p><i class="fas fa-flag mr-2"></i> {{ $player->nationality }}</p>
                        @if($player->height)
                            <p><i class="fas fa-ruler-vertical mr-2"></i> {{ $player->height }} cm</p>
                        @endif
                        <p><i class="fas fa-calendar-alt mr-2"></i> 
                            Joined {{ $player->created_at->format('M j, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h5 font-weight-bold">{{ $player->goals ?? 0 }}</div>
                                <div class="text-muted small">Goals</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h5 font-weight-bold">{{ $player->assists ?? 0 }}</div>
                                <div class="text-muted small">Assists</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h5 font-weight-bold">{{ $player->matches_played ?? 0 }}</div>
                                <div class="text-muted small">Matches</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h5 font-weight-bold">{{ $player->yellow_cards ?? 0 }}</div>
                                <div class="text-muted small">Yellow Cards</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h5 font-weight-bold">{{ $player->red_cards ?? 0 }}</div>
                                <div class="text-muted small">Red Cards</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h5 font-weight-bold">{{ $player->clean_sheets ?? 0 }}</div>
                                <div class="text-muted small">Clean Sheets</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biography</h6>
                </div>
                <div class="card-body">
                    @if($player->biography)
                        {!! nl2br(e($player->biography)) !!}
                    @else
                        <p class="text-muted">No biography available for this player.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Matches</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($player->recentMatches->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Match</th>
                                        <th>Result</th>
                                        <th>Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($player->recentMatches as $match)
                                    <tr>
                                        <td>{{ $match->date->format('M j, Y') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $match->homeTeam->logo_url }}" width="20" height="20" class="mr-1">
                                                {{ $match->homeTeam->short_name }} vs 
                                                <img src="{{ $match->awayTeam->logo_url }}" width="20" height="20" class="ml-1 mr-1">
                                                {{ $match->awayTeam->short_name }}
                                            </div>
                                        </td>
                                        <td>{{ $match->home_goals }} - {{ $match->away_goals }}</td>
                                        <td>
                                            @if($match->pivot->rating >= 8)
                                                <span class="badge badge-success">Excellent</span>
                                            @elseif($match->pivot->rating >= 6)
                                                <span class="badge badge-primary">Good</span>
                                            @elseif($match->pivot->rating >= 4)
                                                <span class="badge badge-warning">Average</span>
                                            @else
                                                <span class="badge badge-danger">Poor</span>
                                            @endif
                                            ({{ $match->pivot->rating }}/10)
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No recent matches found for this player.</p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Strengths</h6>
                        </div>
                        <div class="card-body">
                            @if($player->strengths->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($player->strengths as $strength)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $strength->name }}
                                            <span class="badge badge-primary badge-pill">{{ $strength->pivot->rating }}/10</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No strengths recorded.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Injury History</h6>
                        </div>
                        <div class="card-body">
                            @if($player->injuries->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($player->injuries as $injury)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $injury->type }}</span>
                                                <small class="text-muted">{{ $injury->pivot->start_date->format('M Y') }}</small>
                                            </div>
                                            <small class="text-muted">{{ $injury->pivot->duration }} weeks</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No injury history.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
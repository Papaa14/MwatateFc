@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Coach Details</h1>
        <div>
            <a href="{{ route('coaches.edit', $coach->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Coach
            </a>
            <a href="{{ route('coaches.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Coaches
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $coach->photo_url ?: asset('images/default-coach.png') }}" alt="{{ $coach->name }}" class="rounded-circle mb-3" width="150" height="150">
                    <h4>{{ $coach->name }}</h4>
                    <p class="text-primary">{{ $coach->specialization }}</p>
                    <p>
                        <span class="badge badge-{{ $coach->is_active ? 'success' : 'secondary' }}">
                            {{ $coach->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <hr>
                    <div class="text-left">
                        <p><i class="fas fa-envelope mr-2"></i> {{ $coach->email }}</p>
                        @if($coach->phone)
                            <p><i class="fas fa-phone mr-2"></i> {{ $coach->phone }}</p>
                        @endif
                        @if($coach->years_experience)
                            <p><i class="fas fa-clock mr-2"></i> {{ $coach->years_experience }} years experience</p>
                        @endif
                        @if($coach->certifications)
                            <p><i class="fas fa-certificate mr-2"></i> {{ $coach->certifications }}</p>
                        @endif
                        <p><i class="fas fa-calendar-alt mr-2"></i> Joined {{ $coach->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">About</h6>
                </div>
                <div class="card-body">
                    @if($coach->bio)
                        <p>{{ $coach->bio }}</p>
                    @else
                        <p class="text-muted">No bio information available.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Clients</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Sessions</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">156</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Rating</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">4.8/5</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-star fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
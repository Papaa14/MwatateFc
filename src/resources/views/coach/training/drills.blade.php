@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Training Drills</h1>
            <p class="lead">Session: {{ $training->datetime->format('l, F j, Y') }} - {{ $training->focus }}</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('trainings.show', $training->id) }}" class="btn btn-secondary">Back to Session</a>
            <button class="btn btn-primary ml-2" data-toggle="modal" data-target="#addDrillModal">Add Drill</button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Drill Plan</h3>
                <span class="badge badge-primary">Total Duration: {{ $totalDuration }} mins</span>
            </div>
        </div>
        <div class="card-body">
            @if($drills->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Drill Name</th>
                                <th>Category</th>
                                <th>Duration</th>
                                <th>Intensity</th>
                                <th>Setup</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drills as $drill)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#drillDetailModal{{ $drill->id }}">
                                        <strong>{{ $drill->name }}</strong>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $drill->category == 'warmup' ? 'secondary' : 
                                        ($drill->category == 'fitness' ? 'danger' : 
                                        ($drill->category == 'technical' ? 'info' : 
                                        ($drill->category == 'tactical' ? 'warning' : 'success'))) 
                                    }}">
                                        {{ ucfirst($drill->category) }}
                                    </span>
                                </td>
                                <td>{{ $drill->duration }} mins</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-{{ $i <= $drill->intensity ? 'fire' : 'fire-alt' }} text-{{ $i <= $drill->intensity ? 'danger' : 'secondary' }}"></i>
                                    @endfor
                                </td>
                                <td>
                                    <span class="badge badge-light">{{ $drill->players_needed }} players</span>
                                    <span class="badge badge-light">{{ $drill->field_size }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#editDrillModal{{ $drill->id }}">Edit</button>
                                        <form action="{{ route('trainings.drills.destroy', ['training' => $training->id, 'drill' => $drill->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Remove this drill?')">Remove</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Drill Detail Modal -->
                            <div class="modal fade" id="drillDetailModal{{ $drill->id }}" tabindex="-1" role="dialog" aria-labelledby="drillDetailModalLabel{{ $drill->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="drillDetailModalLabel{{ $drill->id }}">{{ $drill->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Details</h6>
                                                    <ul class="list-unstyled">
                                                        <li><strong>Category:</strong> {{ ucfirst($drill->category) }}</li>
                                                        <li><strong>Duration:</strong> {{ $drill->duration }} minutes</li>
                                                        <li><strong>Intensity:</strong> 
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-{{ $i <= $drill->intensity ? 'fire' : 'fire-alt' }} text-{{ $i <= $drill->intensity ? 'danger' : 'secondary' }}"></i>
                                                            @endfor
                                                        </li>
                                                        <li><strong>Players Needed:</strong> {{ $drill->players_needed }}</li>
                                                        <li><strong>Field Size:</strong> {{ $drill->field_size }}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    @if($drill->diagram)
                                                    <div class="text-center mb-3">
                                                        <img src="{{ asset('storage/' . $drill->diagram) }}" alt="Drill Diagram" class="img-fluid rounded border">
                                                        <small class="text-muted">Drill Diagram</small>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <h6 class="mt-3">Description</h6>
                                            <p>{{ $drill->description }}</p>
                                            
                                            <h6>Coaching Points</h6>
                                            <ul>
                                                @foreach(explode("\n", $drill->coaching_points) as $point)
                                                    @if(trim($point))
                                                        <li>{{ $point }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            
                                            <h6>Variations</h6>
                                            <p>{{ $drill->variations ?: 'None specified' }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Drill Modal -->
                            <div class="modal fade" id="editDrillModal{{ $drill->id }}" tabindex="-1" role="dialog" aria-labelledby="editDrillModalLabel{{ $drill->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDrillModalLabel{{ $drill->id }}">Edit Drill</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('trainings.drills.update', ['training' => $training->id, 'drill' => $drill->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                @include('trainings.partials.drill_form', ['drill' => $drill, 'editMode' => true])
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No drills have been added to this session yet.</div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Session Timeline</h3>
        </div>
        <div class="card-body">
            @if($drills->count() > 0)
                <div class="timeline">
                    @php
                        $startTime = \Carbon\Carbon::parse($training->datetime);
                        $currentTime = $startTime->copy();
                    @endphp
                    
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-event">
                            <div class="timeline-header">
                                {{ $currentTime->format('g:i A') }} - Session Starts
                            </div>
                        </div>
                    </div>
                    
                    @foreach($drills as $drill)
                        @php
                            $endTime = $currentTime->copy()->addMinutes($drill->duration);
                        @endphp
                        
                        <div class="timeline-item">
                            <div class="timeline-point timeline-point-{{ 
                                $drill->category == 'warmup' ? 'secondary' : 
                                ($drill->category == 'fitness' ? 'danger' : 
                                ($drill->category == 'technical' ? 'info' : 
                                ($drill->category == 'tactical' ? 'warning' : 'success'))) 
                            }}"></div>
                            <div class="timeline-event">
                                <div class="timeline-header">
                                    {{ $currentTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
                                    <span class="badge badge-{{ 
                                        $drill->category == 'warmup' ? 'secondary' : 
                                        ($drill->category == 'fitness' ? 'danger' : 
                                        ($drill->category == 'technical' ? 'info' : 
                                        ($drill->category == 'tactical' ? 'warning' : 'success'))) 
                                    }}">
                                        {{ ucfirst($drill->category) }}
                                    </span>
                                </div>
                                <div class="timeline-body">
                                    <h6>{{ $drill->name }}</h6>
                                    <p class="mb-1">{{ Str::limit($drill->description, 100) }}</p>
                                    <small class="text-muted">
                                        Intensity: 
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-{{ $i <= $drill->intensity ? 'fire' : 'fire-alt' }} text-{{ $i <= $drill->intensity ? 'danger' : 'secondary' }}"></i>
                                        @endfor
                                        | Players: {{ $drill->players_needed }} | Field: {{ $drill->field_size }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        @php
                            $currentTime = $endTime;
                        @endphp
                    @endforeach
                    
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-event">
                            <div class="timeline-header">
                                {{ $currentTime->format('g:i A') }} - Session Ends
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">No timeline available. Add drills to visualize the session flow.</div>
            @endif
        </div>
    </div>
</div>

<!-- Add Drill Modal -->
<div class="modal fade" id="addDrillModal" tabindex="-1" role="dialog" aria-labelledby="addDrillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDrillModalLabel">Add New Drill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('trainings.drills.store', $training->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('trainings.partials.drill_form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Drill</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-point {
        position: absolute;
        left: -25px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #6c757d;
        z-index: 2;
    }
    
    .timeline-point-secondary { background-color: #6c757d; }
    .timeline-point-danger { background-color: #dc3545; }
    .timeline-point-info { background-color: #17a2b8; }
    .timeline-point-warning { background-color: #ffc107; }
    .timeline-point-success { background-color: #28a745; }
    
    .timeline-event {
        position: relative;
        padding: 15px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background-color: #fff;
    }
    
    .timeline-header {
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .timeline-body {
        margin-bottom: 0;
    }
    
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: -16px;
        top: 20px;
        height: calc(100% - 20px);
        width: 2px;
        background-color: #dee2e6;
        z-index: 1;
    }
</style>
@endpush
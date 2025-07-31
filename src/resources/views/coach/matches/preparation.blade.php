@extends('layouts.coach')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Match Preparation: {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
        <div>
            <a href="{{ route('coach.matches.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Matches
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Match Information</h6>
            <span class="badge badge-light">
                {{ $match->match_date->format('M j, Y H:i') }} | {{ $match->competition->name }}
            </span>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-5">
                    <img src="{{ $match->homeTeam->logo_url }}" width="80" height="80" class="mb-2">
                    <h4>{{ $match->homeTeam->name }}</h4>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <h3 class="font-weight-bold">VS</h3>
                </div>
                <div class="col-md-5">
                    <img src="{{ $match->awayTeam->logo_url }}" width="80" height="80" class="mb-2">
                    <h4>{{ $match->awayTeam->name }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Opponent Analysis</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $match->awayTeam->logo_url }}" width="100" height="100" class="mb-3">
                        <h4>{{ $match->awayTeam->name }}</h4>
                        <p class="text-muted">Manager: {{ $match->awayTeam->manager }}</p>
                    </div>
                    
                    <h5 class="font-weight-bold">Recent Form</h5>
                    <div class="form-indicator mb-3">
                        @foreach($opponentRecentForm as $result)
                            <span class="form-result form-result-{{ $result }}"></span>
                        @endforeach
                    </div>
                    
                    <h5 class="font-weight-bold">Preferred Formation</h5>
                    <p>{{ $opponentPreferredFormation }}</p>
                    
                    <h5 class="font-weight-bold">Key Players</h5>
                    <div class="list-group mb-3">
                        @foreach($opponentKeyPlayers as $player)
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <img src="{{ $player->photo_url }}" width="40" height="40" class="rounded-circle mr-3">
                                <div>
                                    <div class="font-weight-bold">{{ $player->name }} #{{ $player->jersey_number }}</div>
                                    <small class="text-muted">{{ $player->position }} | {{ $player->goals_this_season }} goals</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <h5 class="font-weight-bold">Strengths</h5>
                    <div class="mb-3">
                        @foreach($opponentStrengths as $strength)
                        <span class="badge badge-success mr-1 mb-1">{{ $strength }}</span>
                        @endforeach
                    </div>
                    
                    <h5 class="font-weight-bold">Weaknesses</h5>
                    <div class="mb-3">
                        @foreach($opponentWeaknesses as $weakness)
                        <span class="badge badge-danger mr-1 mb-1">{{ $weakness }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Tactical Plan</h6>
                    <button class="btn btn-sm btn-primary" id="saveTacticalPlan">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
                <div class="card-body">
                    <form id="tacticalPlanForm" action="{{ route('coach.matches.save-preparation', $match->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="game_strategy">Game Strategy</label>
                            <textarea class="form-control" id="game_strategy" name="game_strategy" rows="3">{{ old('game_strategy', $preparation->game_strategy ?? '') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="offensive_tactics">Offensive Tactics</label>
                            <textarea class="form-control" id="offensive_tactics" name="offensive_tactics" rows="3">{{ old('offensive_tactics', $preparation->offensive_tactics ?? '') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="defensive_tactics">Defensive Tactics</label>
                            <textarea class="form-control" id="defensive_tactics" name="defensive_tactics" rows="3">{{ old('defensive_tactics', $preparation->defensive_tactics ?? '') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="set_pieces">Set Pieces</label>
                            <textarea class="form-control" id="set_pieces" name="set_pieces" rows="3">{{ old('set_pieces', $preparation->set_pieces ?? '') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="special_instructions">Special Instructions</label>
                            <textarea class="form-control" id="special_instructions" name="special_instructions" rows="3">{{ old('special_instructions', $preparation->special_instructions ?? '') }}</textarea>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Training Sessions</h6>
                        </div>
                        <div class="card-body">
                            @if($trainingSessions->count() > 0)
                                <div class="list-group">
                                    @foreach($trainingSessions as $session)
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $session->topic }}</h6>
                                            <small>{{ $session->date->format('M j') }}</small>
                                        </div>
                                        <p class="mb-1">{{ Str::limit($session->description, 100) }}</p>
                                        <small>Focus: {{ $session->focus_area }}</small>
                                    </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No training sessions planned for this match.</p>
                            @endif
                            <button class="btn btn-sm btn-success mt-3" data-toggle="modal" data-target="#addTrainingSessionModal">
                                <i class="fas fa-plus"></i> Add Training Session
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Team Meeting Notes</h6>
                        </div>
                        <div class="card-body">
                            <form id="meetingNotesForm" action="{{ route('coach.matches.save-meeting-notes', $match->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" id="meeting_notes" name="meeting_notes" rows="6">{{ old('meeting_notes', $preparation->meeting_notes ?? '') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Notes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Training Session Modal -->
<div class="modal fade" id="addTrainingSessionModal" tabindex="-1" role="dialog" aria-labelledby="addTrainingSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTrainingSessionModalLabel">Add Training Session</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTrainingSessionForm" action="{{ route('coach.matches.add-training-session', $match->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="session_date">Date</label>
                        <input type="date" class="form-control" id="session_date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="session_topic">Topic</label>
                        <input type="text" class="form-control" id="session_topic" name="topic" required>
                    </div>
                    <div class="form-group">
                        <label for="session_focus">Focus Area</label>
                        <select class="form-control" id="session_focus" name="focus_area" required>
                            <option value="offense">Offense</option>
                            <option value="defense">Defense</option>
                            <option value="set_pieces">Set Pieces</option>
                            <option value="fitness">Fitness</option>
                            <option value="tactics">Tactics</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="session_description">Description</label>
                        <textarea class="form-control" id="session_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-indicator {
        display: flex;
        gap: 5px;
        margin-bottom: 15px;
    }
    .form-result {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 3px;
    }
    .form-result-W {
        background-color: #1cc88a; /* Green for win */
    }
    .form-result-D {
        background-color: #f6c23e; /* Yellow for draw */
    }
    .form-result-L {
        background-color: #e74a3b; /* Red for loss */
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Set default session date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('session_date').valueAsDate = tomorrow;
        
        // Save tactical plan button
        $('#saveTacticalPlan').click(function() {
            $('#tacticalPlanForm').submit();
        });
        
        // Initialize any rich text editors if needed
        // Example: CKEditor or TinyMCE
        // CKEDITOR.replace('game_strategy');
        // CKEDITOR.replace('offensive_tactics');
        // CKEDITOR.replace('defensive_tactics');
        // CKEDITOR.replace('set_pieces');
        // CKEDITOR.replace('special_instructions');
        // CKEDITOR.replace('meeting_notes');
    });
</script>
@endsection
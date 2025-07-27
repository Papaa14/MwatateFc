@extends('layouts.coach')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Match Lineup: {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
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
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Starting XI</h6>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addPlayerModal">
                        <i class="fas fa-plus"></i> Add Player
                    </button>
                </div>
                <div class="card-body">
                    <form id="lineupForm" action="{{ route('coach.matches.save-lineup', $match->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="formation" id="formationInput" value="{{ $lineup->formation ?? '4-4-2' }}">
                        
                        <div class="formation-selector mb-4 text-center">
                            <label for="formation" class="mr-2">Formation:</label>
                            <select id="formation" class="form-control d-inline-block w-auto">
                                <option value="4-4-2">4-4-2</option>
                                <option value="4-3-3">4-3-3</option>
                                <option value="4-2-3-1">4-2-3-1</option>
                                <option value="3-5-2">3-5-2</option>
                                <option value="5-3-2">5-3-2</option>
                            </select>
                        </div>
                        
                        <div class="pitch-container mb-4">
                            <div class="pitch">
                                <div class="formation-preview" id="formationPreview">
                                    <!-- Formation will be rendered here by JavaScript -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="lineupTable">
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Player</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($positions as $position)
                                    <tr data-position="{{ $position->code }}">
                                        <td>{{ $position->name }}</td>
                                        <td>
                                            <select class="form-control player-select" name="players[{{ $position->code }}]">
                                                <option value="">Select Player</option>
                                                @foreach($availablePlayers as $player)
                                                    <option value="{{ $player->id }}" 
                                                        {{ isset($lineup->players[$position->code]) && $lineup->players[$position->code]->id == $player->id ? 'selected' : '' }}>
                                                        {{ $player->name }} ({{ $player->jersey_number }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-player" 
                                                    data-position="{{ $position->code }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group">
                            <label for="strategy">Match Strategy</label>
                            <textarea class="form-control" id="strategy" name="strategy" rows="3">{{ old('strategy', $lineup->strategy ?? '') }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Lineup</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Substitutes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="substitutesTable">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Position</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($substitutes as $substitute)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $substitute->player->photo_url }}" width="30" height="30" class="rounded-circle mr-2">
                                            {{ $substitute->player->name }} ({{ $substitute->player->jersey_number }})
                                        </div>
                                    </td>
                                    <td>{{ $substitute->position->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" title="Move to Starting XI">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Remove from Lineup">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-sm btn-success mt-2" data-toggle="modal" data-target="#addSubstituteModal">
                        <i class="fas fa-plus"></i> Add Substitute
                    </button>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Available Players</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="availablePlayersTable">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availablePlayers as $player)
                                    @if(!$lineup->containsPlayer($player->id) && !$substitutes->contains('player_id', $player->id))
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $player->photo_url }}" width="30" height="30" class="rounded-circle mr-2">
                                                {{ $player->name }} ({{ $player->jersey_number }})
                                            </div>
                                        </td>
                                        <td>{{ $player->position }}</td>
                                        <td>
                                            <span class="badge badge-{{ $player->status == 'active' ? 'success' : 
                                                                      ($player->status == 'injured' ? 'warning' : 
                                                                      ($player->status == 'suspended' ? 'danger' : 'secondary')) }}">
                                                {{ ucfirst($player->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Player Modal -->
<div class="modal fade" id="addPlayerModal" tabindex="-1" role="dialog" aria-labelledby="addPlayerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlayerModalLabel">Add Player to Lineup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addPlayerForm">
                    <div class="form-group">
                        <label for="addPlayerPosition">Position</label>
                        <select class="form-control" id="addPlayerPosition">
                            @foreach($positions as $position)
                                <option value="{{ $position->code }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="addPlayerSelect">Player</label>
                        <select class="form-control" id="addPlayerSelect">
                            <option value="">Select Player</option>
                            @foreach($availablePlayers as $player)
                                <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->jersey_number }})</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddPlayer">Add Player</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Substitute Modal -->
<div class="modal fade" id="addSubstituteModal" tabindex="-1" role="dialog" aria-labelledby="addSubstituteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubstituteModalLabel">Add Substitute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubstituteForm">
                    <div class="form-group">
                        <label for="addSubstitutePosition">Position</label>
                        <select class="form-control" id="addSubstitutePosition">
                            @foreach($positions as $position)
                                <option value="{{ $position->code }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="addSubstituteSelect">Player</label>
                        <select class="form-control" id="addSubstituteSelect">
                            <option value="">Select Player</option>
                            @foreach($availablePlayers as $player)
                                @if(!$lineup->containsPlayer($player->id) && !$substitutes->contains('player_id', $player->id))
                                    <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->jersey_number }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddSubstitute">Add Substitute</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .pitch-container {
        position: relative;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }
    .pitch {
        position: relative;
        padding-bottom: 66.67%; /* 3:2 aspect ratio */
        background-color: #2e8b57;
        background-image: url('{{ asset('images/pitch.png') }}');
        background-size: cover;
        background-position: center;
        border-radius: 5px;
    }
    .formation-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .player-circle {
        position: absolute;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #4e73df;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        cursor: move;
        border: 2px solid white;
        transform: translate(-50%, -50%);
    }
    .player-circle:hover {
        z-index: 100;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    .formation-selector {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Set initial formation
        const initialFormation = "{{ $lineup->formation ?? '4-4-2' }}";
        $('#formation').val(initialFormation);
        renderFormation(initialFormation);
        
        // Formation change handler
        $('#formation').change(function() {
            const formation = $(this).val();
            $('#formationInput').val(formation);
            renderFormation(formation);
        });
        
        // Player select change handler
        $('.player-select').change(function() {
            const position = $(this).closest('tr').data('position');
            const playerId = $(this).val();
            updateFormationPlayer(position, playerId);
        });
        
        // Remove player button handler
        $('.remove-player').click(function() {
            const position = $(this).data('position');
            $(`select.player-select[name="players[${position}]"]`).val('').trigger('change');
        });
        
        // Add player modal handler
        $('#confirmAddPlayer').click(function() {
            const position = $('#addPlayerPosition').val();
            const playerId = $('#addPlayerSelect').val();
            
            if(playerId) {
                $(`select.player-select[name="players[${position}]"]`).val(playerId).trigger('change');
                $('#addPlayerModal').modal('hide');
                $('#addPlayerForm')[0].reset();
            }
        });
        
        // Add substitute modal handler
        $('#confirmAddSubstitute').click(function() {
            // This would typically be an AJAX call to add the substitute
            const position = $('#addSubstitutePosition').val();
            const playerId = $('#addSubstituteSelect').val();
            
            if(playerId) {
                // Add to substitutes table
                toastr.success('Substitute added successfully');
                $('#addSubstituteModal').modal('hide');
                $('#addSubstituteForm')[0].reset();
            }
        });
        
        // Function to render formation on pitch
        function renderFormation(formation) {
            const formationPreview = $('#formationPreview');
            formationPreview.empty();
            
            // These positions would be calculated based on the formation
            const positions = {
                'GK': { top: '90%', left: '50%' },
                // Defenders
                'LB': { top: '70%', left: '15%' },
                'CB1': { top: '70%', left: '35%' },
                'CB2': { top: '70%', left: '65%' },
                'RB': { top: '70%', left: '85%' },
                // Midfielders
                'LM': { top: '50%', left: '20%' },
                'CM1': { top: '50%', left: '40%' },
                'CM2': { top: '50%', left: '60%' },
                'RM': { top: '50%', left: '80%' },
                // Forwards
                'CF1': { top: '30%', left: '40%' },
                'CF2': { top: '30%', left: '60%' }
            };
            
            // Adjust positions based on formation
            if(formation === '4-3-3') {
                positions['CM1'].left = '50%';
                delete positions['CM2'];
                positions['LW'] = { top: '30%', left: '20%' };
                positions['CF1'] = { top: '30%', left: '50%' };
                positions['RW'] = { top: '30%', left: '80%' };
            }
            // Add more formation adjustments as needed
            
            // Render players on pitch
            for(const [position, coords] of Object.entries(positions)) {
                const playerSelect = $(`select.player-select[name="players[${position}]"]`);
                const playerId = playerSelect.val();
                const playerName = playerSelect.find('option:selected').text().split(' (')[0];
                const jerseyNumber = playerSelect.find('option:selected').text().match(/\((\d+)\)/)?.[1] || '';
                
                formationPreview.append(`
                    <div class="player-circle" style="top: ${coords.top}; left: ${coords.left};" 
                         data-position="${position}">
                        ${jerseyNumber}
                        <div class="player-tooltip">${position}: ${playerName || 'Empty'}</div>
                    </div>
                `);
            }
        }
        
        // Function to update player in formation
        function updateFormationPlayer(position, playerId) {
            // This would update the formation display
            renderFormation($('#formation').val());
        }
    });
</script>
@endsection
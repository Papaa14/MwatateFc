@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Tactical Strategies</h1>
            <p class="lead">Manage your team's strategic approaches</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('tactics.strategies.create') }}" class="btn btn-primary">New Strategy</a>
            <a href="{{ route('tactics.index') }}" class="btn btn-secondary ml-2">Back to Tactics</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Strategy Playbook</h3>
                <div class="form-inline">
                    <select class="form-control mr-2" id="formationFilter">
                        <option value="">All Formations</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}">{{ $formation->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control" id="phaseFilter">
                        <option value="">All Phases</option>
                        <option value="attack">Attacking</option>
                        <option value="defense">Defensive</option>
                        <option value="transition">Transition</option>
                        <option value="set_piece">Set Pieces</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="strategiesTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Formation</th>
                            <th>Phase</th>
                            <th>Complexity</th>
                            <th>Last Used</th>
                            <th>Success Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($strategies as $strategy)
                        <tr data-formation="{{ $strategy->formation_id }}" data-phase="{{ $strategy->phase }}">
                            <td>
                                <a href="{{ route('tactics.strategies.show', $strategy->id) }}">
                                    <strong>{{ $strategy->title }}</strong>
                                </a>
                            </td>
                            <td>{{ $strategy->formation->name }}</td>
                            <td>
                                <span class="badge badge-{{ 
                                    $strategy->phase == 'attack' ? 'danger' : 
                                    ($strategy->phase == 'defense' ? 'info' : 
                                    ($strategy->phase == 'transition' ? 'warning' : 'success')) 
                                }}">
                                    {{ ucfirst(str_replace('_', ' ', $strategy->phase)) }}
                                </span>
                            </td>
                            <td>
                                @for($i = 0; $i < $strategy->complexity; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                                @for($i = $strategy->complexity; $i < 5; $i++)
                                    <i class="far fa-star text-warning"></i>
                                @endfor
                            </td>
                            <td>{{ $strategy->last_used ? $strategy->last_used->diffForHumans() : 'Never' }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-{{ $strategy->success_rate >= 70 ? 'success' : ($strategy->success_rate >= 40 ? 'warning' : 'danger') }}" 
                                         role="progressbar" 
                                         style="width: {{ $strategy->success_rate }}%" 
                                         aria-valuenow="{{ $strategy->success_rate }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $strategy->success_rate }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('tactics.strategies.edit', $strategy->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('tactics.strategies.destroy', $strategy->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this strategy?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Most Successful Strategies</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topStrategies as $strategy)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $strategy->title }}</strong><br>
                                <small class="text-muted">
                                    {{ $strategy->formation->name }} | 
                                    {{ ucfirst(str_replace('_', ' ', $strategy->phase)) }}
                                </small>
                            </div>
                            <span class="badge badge-primary badge-pill">{{ $strategy->success_rate }}%</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Strategy Effectiveness by Phase</h4>
                </div>
                <div class="card-body">
                    <canvas id="phaseEffectivenessChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Strategy filtering
    document.getElementById('formationFilter').addEventListener('change', function() {
        filterStrategies();
    });
    
    document.getElementById('phaseFilter').addEventListener('change', function() {
        filterStrategies();
    });
    
    function filterStrategies() {
        const formationId = document.getElementById('formationFilter').value;
        const phase = document.getElementById('phaseFilter').value;
        const rows = document.querySelectorAll('#strategiesTable tbody tr');
        
        rows.forEach(row => {
            const rowFormation = row.dataset.formation;
            const rowPhase = row.dataset.phase;
            
            const formationMatch = !formationId || rowFormation === formationId;
            const phaseMatch = !phase || rowPhase === phase;
            
            if (formationMatch && phaseMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Phase Effectiveness Chart
    const phaseCtx = document.getElementById('phaseEffectivenessChart').getContext('2d');
    new Chart(phaseCtx, {
        type: 'bar',
        data: {
            labels: @json($phaseStats->pluck('phase')),
            datasets: [{
                label: 'Success Rate %',
                data: @json($phaseStats->pluck('success_rate')),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>
@endpush
@endsection
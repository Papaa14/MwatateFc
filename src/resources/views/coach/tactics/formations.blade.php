@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Formations Management</h1>
            <p class="lead">Create and organize team formations</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('tactics.formations.create') }}" class="btn btn-primary">New Formation</a>
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
                <h3 class="mb-0">Available Formations</h3>
                <div class="form-group mb-0">
                    <select class="form-control" id="formationFilter">
                        <option value="all">All Formations</option>
                        <option value="defensive">Defensive</option>
                        <option value="balanced">Balanced</option>
                        <option value="attacking">Attacking</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="formationsContainer">
                @foreach($formations as $formation)
                <div class="col-md-4 mb-4 formation-card" data-style="{{ $formation->style }}">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $formation->name }}</h5>
                            <span class="badge badge-{{ 
                                $formation->style == 'defensive' ? 'info' : 
                                ($formation->style == 'balanced' ? 'warning' : 'danger') 
                            }}">
                                {{ ucfirst($formation->style) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="formation-visual text-center mb-3">
                                {!! $formation->visual_pattern !!}
                            </div>
                            <p>{{ $formation->description }}</p>
                            <div class="formation-stats">
                                <small class="text-muted">
                                    <strong>Used:</strong> {{ $formation->matches_count }} matches | 
                                    <strong>Win Rate:</strong> {{ $formation->win_rate }}%
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('tactics.formations.show', $formation->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('tactics.formations.edit', $formation->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('tactics.formations.destroy', $formation->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this formation?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Formation Statistics</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <canvas id="formationUsageChart" height="250"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="formationPerformanceChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Formation filtering
    document.getElementById('formationFilter').addEventListener('change', function() {
        const style = this.value;
        const cards = document.querySelectorAll('.formation-card');
        
        cards.forEach(card => {
            if (style === 'all' || card.dataset.style === style) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Formation Usage Chart
    const usageCtx = document.getElementById('formationUsageChart').getContext('2d');
    new Chart(usageCtx, {
        type: 'doughnut',
        data: {
            labels: @json($formationStats->pluck('name')),
            datasets: [{
                data: @json($formationStats->pluck('usage_count')),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                    '#9966FF', '#FF9F40', '#8AC24A', '#607D8B'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Formation Usage Distribution'
                }
            }
        }
    });

    // Formation Performance Chart
    const performanceCtx = document.getElementById('formationPerformanceChart').getContext('2d');
    new Chart(performanceCtx, {
        type: 'bar',
        data: {
            labels: @json($formationStats->pluck('name')),
            datasets: [
                {
                    label: 'Win Rate %',
                    data: @json($formationStats->pluck('win_rate')),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Avg Goals For',
                    data: @json($formationStats->pluck('avg_goals_for')),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Avg Goals Against',
                    data: @json($formationStats->pluck('avg_goals_against')),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Formation Performance Metrics'
                }
            }
        }
    });
</script>
@endpush

<style>
    .formation-visual {
        font-family: monospace;
        white-space: pre;
        line-height: 1;
        font-size: 14px;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
    }
    
    .formation-card {
        transition: transform 0.2s;
    }
    
    .formation-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
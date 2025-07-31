@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Players List</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('players.create') }}" class="btn btn-primary">Add New Player</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Team</th>
                    <th>Jersey Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($players as $player)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->position }}</td>
                    <td>{{ $player->team->name ?? 'N/A' }}</td>
                    <td>{{ $player->jersey_number }}</td>
                    <td>
                        <a href="{{ route('players.show', $player->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('players.performance', $player->id) }}" class="btn btn-success btn-sm">Performance</a>
                        <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $players->links() }}
</div>
@endsection
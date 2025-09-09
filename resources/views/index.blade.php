@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Audit Logs</h2>

    <!-- 🔹 Filter Form -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="model" value="{{ request('model') }}" class="form-control" placeholder="Model Name">
        </div>

        <div class="col-md-2">
            <select name="action" class="form-control">
                <option value="">-- Action --</option>
                <option value="created" {{ request('action')=='created'?'selected':'' }}>Created</option>
                <option value="updated" {{ request('action')=='updated'?'selected':'' }}>Updated</option>
                <option value="deleted" {{ request('action')=='deleted'?'selected':'' }}>Deleted</option>
            </select>
        </div>

        <div class="col-md-2">
            <input type="number" name="user_id" value="{{ request('user_id') }}" class="form-control" placeholder="User ID">
        </div>

        <div class="col-md-2">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- 🔹 Logs Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Model</th>
                <th>Model ID</th>
                <th>Action</th>
                <th>User</th>
                <th>Old Values</th>
                <th>New Values</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ class_basename($log->model) }}</td>
                    <td>{{ $log->model_id }}</td>
                    <td><span class="badge bg-info">{{ $log->action }}</span></td>
                    <td>{{ $log->user?->name ?? 'System' }}</td>
                    <td><pre>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre></td>
                    <td><pre>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre></td>
                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">No logs found</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $logs->withQueryString()->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Career Paths - WatyAssessment')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-glow-cyan">Career Paths</h1>
        <p class="text-muted">Manage the technical career profiles used to generate student recommendations.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.careers.create') }}" class="btn btn-premium">
            <i class="fa-solid fa-plus me-2"></i> Add Career Path
        </a>
    </div>
</div>

<div class="glass-card p-4">
    @if($careers->isEmpty())
        <div class="text-center py-5">
            <i class="fa-solid fa-briefcase fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-muted">No Career Paths Found</h4>
            <p class="text-muted mb-4">Start by adding your first career path profile.</p>
            <a href="{{ route('admin.careers.create') }}" class="btn btn-premium btn-sm">Add Career Path</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Salary Range</th>
                        <th>Demand</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($careers as $career)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $career->code }}</span></td>
                            <td><span class="fw-semibold text-white">{{ $career->name }}</span></td>
                            <td>{{ $career->salary_range }}</td>
                            <td><span class="badge-premium-cyan">{{ $career->demand_status }}</span></td>
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('admin.careers.show', $career->id) }}" class="btn btn-glass-secondary btn-sm py-1 px-3">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.careers.edit', $career->id) }}" class="btn btn-premium-cyan btn-sm py-1 px-3">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.careers.destroy', $career->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this career path? Existing question weightings referencing it will remain but no longer resolve.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-1 px-3">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $careers->links() }}
        </div>
    @endif
</div>
@endsection

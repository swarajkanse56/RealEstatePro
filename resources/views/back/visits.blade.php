@extends('back.master')

@section('title', 'Visit Property')

@section('content') 

<div class="container my-5">
    <h2 class="text-center mb-4" style="color: #8B4513;">Visit Data</h2>

    <!-- Check if there are any visits -->
    @if($visits->isEmpty())
        <div class="alert alert-warning">No visits scheduled yet.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Property</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Visit Date</th>
                      <th>Category</th>
                      <th>Actions</th>
                </tr>
            </thead>
         <tbody>
    @foreach($visits as $index => $visit)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $visit->property->name ?? 'N/A' }}</td>
            <td>{{ $visit->name }}</td>
            <td>{{ $visit->email }}</td>
            <td>{{ $visit->phone }}</td>
            <td>{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M, Y h:i A') }}</td>
            <td>{{ $visit->category->name ?? 'No Category' }}</td>
            <td>
                <form action="{{ route('visit.destroy', $visit->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this visit?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    @endif
</div>

@endsection

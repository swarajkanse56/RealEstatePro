@extends('back.master')

@section('title', 'All Properties')

@section('content')
<div class="container-fluid mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">All Properties</h5>
        <a href="{{ route('property.create') }}" class="btn btn-primary btn-sm">
            + Add New Property
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success py-2 small">
            {{ session('success') }}
        </div>
    @endif

    @if ($properties->isEmpty())
        <div class="alert alert-info py-2 small">No properties found.</div>
    @else

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle compact-table">
            <thead class="table-light small">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Property Name</th>
                    <th>Subname</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>City</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach ($properties as $index => $property)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $property->user->name ?? 'No User' }}</td>
                    <td>{{ $property->name }}</td>
                    <td>{{ $property->subname }}</td>
                    <td>₹{{ number_format($property->price, 0) }}</td>
                    <td>{{ $property->category->name ?? 'No Category' }}</td>
                    <td>{{ $property->city->name ?? 'No City' }}</td>

                    <td class="text-center">
                        @if($property->image)
                            <img src="{{ asset('uploads/'.$property->image) }}"
                                 style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>

                    <td>{{ \Illuminate\Support\Str::limit($property->description, 35) }}</td>
                    <td>{{ $property->address ?? 'N/A' }}</td>

                    <td class="text-nowrap text-center">
                        <a href="{{ route('property.show', $property->propertysid) }}"
                           class="btn btn-info btn-sm px-2 py-1">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('property.edit', $property->propertysid) }}"
                           class="btn btn-warning btn-sm px-2 py-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('property.destroy', $property->propertysid) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm px-2 py-1"
                                onclick="return confirm('Delete this property ?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- ✅ EXTRA COMPACT CSS --}}
<style>
    .compact-table th,
    .compact-table td {
        padding: 6px 8px !important;
        vertical-align: middle;
    }

    .compact-table th {
        font-size: 13px;
        font-weight: 600;
    }

    .compact-table td {
        font-size: 12px;
    }
</style>
@endsection

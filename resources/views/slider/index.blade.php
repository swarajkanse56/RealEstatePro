@extends('back.master')

@section('content')
<div class="container mt-7">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 20px;">
        <h2 class="fw-bold">Slider List</h2>
        <a href="{{ route('sliders.create') }}" class="btn btn-primary shadow-sm px-4 py-2">
            + Add New Slider
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Slider Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Discount</th>
                        <th>Property ID</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sliders as $slider)
                        <tr>
                            <td>{{ $slider->id }}</td>

                            <td>
                                @if($slider->image)
                                    <img src="{{ asset('uploads/'.$slider->image) }}" width="120" height="70" style="object-fit: cover;" class="rounded">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>{{ $slider->title ?? '-' }}</td>
                            <td>{{ $slider->subtitle ?? '-' }}</td>
                            <td><strong class="text-success">{{ $slider->discount ?? '-' }}</strong></td>
 <td>{{ $slider->property->name ?? 'General Slider' }}</td>

                            <td>
                                <form action="{{ route('sliders.delete', $slider->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm w-100">Delete</button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No Sliders Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection

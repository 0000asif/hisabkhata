@extends('admin.masterAdmin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>ক্যাটাগরির লিস্ট</h5>
        <a href="{{ route('category.create') }}" class="btn btn-primary">নতুন যুক্ত করুন</a>
    </div>

    <div class="card-body">
        @include('components.alert')
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="dt-responsive">
                <thead>
                    <tr>
                        <th>ক্রমিক</th>
                        <th>নাম</th>
                        <th>টাইপ</th>
                        <th>স্ট্যাটাস</th>
                        <th>একশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ ucfirst($category->type) }}</td>
                        <td>
                            @if ($category->status == 1)
                                <span class="badge badge-success">সক্রিয়</span>
                            @else
                                <span class="badge badge-danger">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

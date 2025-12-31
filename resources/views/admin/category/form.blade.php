@extends('admin.masterAdmin')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>ক্যাটাগরি {{ isset($category) ? 'এডিট' : 'যুক্ত ' }} করুন </h5>
    </div>

    <div class="card-body">
        @include('components.alert')

        <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}" method="POST">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name ?? old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="income" {{ (isset($category) && $category->type == 'income') ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ (isset($category) && $category->type == 'expense') ? 'selected' : '' }}>Expense</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="1" {{ (isset($category) && $category->status == 1) ? 'selected' : '' }}>Active</option>
                    <option value="2" {{ (isset($category) && $category->status == 2) ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">{{ isset($category) ? 'Update' : 'Save' }}</button>
        </form>
    </div>
</div>
@endsection

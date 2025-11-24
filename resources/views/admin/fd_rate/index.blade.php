@extends('admin.masterAdmin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>FD Rate List</h4>
            <a href="{{ route('fd.rate.create') }}" class="btn btn-primary btn-sm">Add New Rate</a>
        </div>

        <div class="card-body">
            @include('components.alert')

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Months</th>
                        <th>Interest Rate (%)</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rates as $rate)
                        <tr>
                            <td>{{ $rate->months }}</td>
                            <td>{{ $rate->rate }}%</td>
                            <td>
                                <a href="{{ route('fd.rate.edit', $rate->id) }}" class="btn btn-info btn-sm">Edit</a>

                                <form method="POST" action="{{ route('fd.rate.delete', $rate->id) }}"
                                    style="display:inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete?')"
                                        class="btn btn-danger btn-sm">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

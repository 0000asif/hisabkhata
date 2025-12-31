@extends('admin.masterAdmin')
@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="box-title">Income & Expense List</h5>
            <a href="{{ route('income-expense.create') }}" class="btn btn-primary">Add New</a>
        </div>

        <div class="card-body">
            @include('components.alert')
            <div class="table-responsive">

                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($incomeExpenses as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->date)->format('d-m-Y') }}</td>
                                <td>{{ $data->category->name }}</td>

                                <td>
                                    @if($data->type == 'income')
                                        <span class="badge badge-success">Income</span>
                                    @else
                                        <span class="badge badge-danger">Expense</span>
                                    @endif
                                </td>

                                <td>{{ number_format($data->amount, 2) }}</td>
                                <td>{{ $data->note ?? '—' }}</td>
                                <td>{{ $data->user->name ?? 'N/A' }}</td>

                                <td>
                                    <div class="btn-group">

                                        <a href="{{ route('income-expense.edit', $data->id) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm"
                                                data-toggle="modal"
                                                data-target="#deleteModal{{ $data->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $data->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">ডিলিট নিশ্চিত করুন</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            আপনি কি নিশ্চিতভাবে <strong>{{ $data->category->name }}</strong> রেকর্ডটি ডিলিট করতে চান?
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-dismiss="modal">না</button>

                                            <form action="{{ route('income-expense.destroy', $data->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">হ্যাঁ, ডিলিট করুন</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>
@endsection

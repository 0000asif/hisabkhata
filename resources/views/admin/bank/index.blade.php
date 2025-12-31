@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>সকল ব্যাংকের তালিকা</h4>
        <a href="{{ route('bank.create') }}" class="btn btn-primary">ব্যাংক এড করুন</a>
    </div>

    <div class="card-body">
        @include('components.alert')

        <table class="table table-bordered w-100" id="dt-responsive">
            <thead class="thead-light">
                <tr>
                    <th>SL</th>
                    <th>ব্যাংকের নাম</th>
                    <th>ব্রাঞ্চ</th>
                    <th>একাউন্টের নাম</th>
                    <th>অ্যাকাউন্ট টাইপ</th>
                    <th>অ্যাকাউন্ট নং</th>
                    <th>ওপেনিং ব্যালেন্স</th>
                    <th>স্ট্যাটাস</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($banks as $bank)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bank->bank_name }}</td>
                    <td>{{ $bank->branch_name }}</td>
                    <td>{{ $bank->account_name }}</td>
                    <td>{{ $bank->account_type }}</td>
                    <td>{{ $bank->account_number }}</td>
                    <td>{{ number_format($bank->opening_balance,2) }}</td>
                    <td>
                        @if($bank->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('bank.edit',$bank->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('bank.destroy',$bank->id) }}" method="post" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection


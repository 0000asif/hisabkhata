@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Select Member for Ledger</h4>
        </div>
        <div class="card-body">
            <form action="" method="get">
                <select class="form-control"
                    onchange="if(this.value) window.location='{{ url('members/ledger') }}/'+this.value;">
                    <option value="">-- Select Member --</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
@endsection

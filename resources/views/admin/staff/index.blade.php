@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="box-title">স্টাফ তালিকা</h5>
                <a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> নতুন স্টাফ যোগ করুন
                </a>
            </div>

            <div class="card-body">
                @include('components.alert')

                <div class="table-responsive mt-3">
                    <table class="table table-bordered w-100" id="dt-responsive">
                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>তারিখ</th>
                                <th>নাম</th>
                                <th>ইমেইল</th>
                                <th>ফোন</th>
                                <th>পদবি</th>
                                <th>ফিল্ড</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($staffs as $person)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $person->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $person->name }}</td>
                                    <td>{{ $person->email }}</td>
                                    <td>{{ $person->phone }}</td>
                                    <td>{{ $person->position->name ?? 'N/A' }}</td>

                                    <td>
                                        @if ($person->feild == 1)
                                            <span class="badge badge-success">হ্যাঁ</span>
                                        @else
                                            <span class="badge badge-danger">না</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($person->status == 1)
                                            <span class="badge badge-success">সক্রিয়</span>
                                        @else
                                            <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('staff.edit', $person->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <!-- Delete Button triggers modal -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal{{ $person->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $person->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel{{ $person->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $person->id }}">ডিলিট
                                                    নিশ্চিত করুন</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                আপনি কি নিশ্চিতভাবে <strong>{{ $person->name }}</strong> স্টাফ ডিলিট করতে
                                                চান?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">না</button>
                                                <form action="{{ route('staff.destroy', $person->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">হ্যাঁ, ডিলিট করুন</button>
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
    <!-- END: Page content-->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#branch_id').on('change', function() {
                $('#filter_branch').submit();
            });
        });
    </script>
@endsection

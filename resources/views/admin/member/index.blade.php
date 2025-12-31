@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="box-title">মেম্বার তালিকা</h5>

                <!-- Area Filter -->
                <div>
                    <form action="{{ route('member.index') }}" id="filter_area" method="get">
                        <select name="area_id" class="form-control select2_demo" id="area_id">
                            <option value="">সব এরিয়া</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <a href="{{ route('member.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> নতুন মেম্বার যোগ করুন
                </a>
                <a href="{{ route('member.export') }}" class="btn btn-info btn-sm">
                    <i class="fa fa-file-excel-o"></i> এক্সেল ডাউনলোড
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
                                <th>এরিয়া</th>
                                <th>নাম</th>
                                <th>মোবাইল</th>
                                <th>NID</th>
                                <th>নোমিনি</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $member->area->name ?? 'N/A' }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->nid }}</td>
                                    <td>{{ $member->nominee ?? 'N/A' }}</td>

                                    <td>
                                        @if ($member->status == 1)
                                            <span class="badge badge-success">সক্রিয়</span>
                                        @else
                                            <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group">

                                            <!-- Edit -->
                                            <a href="{{ route('member.show', $member->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('member.edit', $member->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal{{ $member->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel{{ $member->id }}" aria-hidden="true">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $member->id }}">
                                                    ডিলিট নিশ্চিত করুন
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                আপনি কি নিশ্চিতভাবে <strong>{{ $member->name }}</strong> মেম্বার ডিলিট করতে
                                                চান?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">না</button>

                                                <form action="{{ route('member.destroy', $member->id) }}" method="POST">
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
            $('#area_id').on('change', function() {
                $('#filter_area').submit();
            });
        });
    </script>
@endsection

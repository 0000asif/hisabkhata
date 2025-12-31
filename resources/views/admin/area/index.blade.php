@extends('admin.masterAdmin')
@section('content')
<!-- BEGIN: Page content-->
<div>
  <div class="card">
    <div class="card-header">
      <h5 class="box-title">Area List</h5>
      <a href="{{ route('area.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <div class="card-body">
      <br>
      @include('components/alert')
      <div class="table-responsive">
        <table class="table table-bordered w-100" id="dt-responsive">

          <thead class="thead-light">
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Added By</th>
              <th>Area</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($areas as $area)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $area->created_at->format('d-m-y') }}</td>
              <td>{{ $area->user->name }}</td>
              <td>{{ $area->name }}</td>
              <td>
                @if ($area->status == 1)
                <span class="badge badge-success">Active</span>
                @else
                <span class="badge badge-danger">Inactive</span>
                @endif
              </td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('area.edit',$area->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <form action="{{ route('area.destroy',$area->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                      data-target="#deleteModal{{ $area->id }}">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
              <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal{{ $area->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteModalLabel">ডিলিট নিশ্চিত করুন</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          আপনি কি নিশ্চিতভাবে <strong>{{ $area->name }}</strong> এলাকা ডিলিট করতে চান?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">না</button>
          <form action="{{ route('area.destroy', $area->id) }}" method="post">
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
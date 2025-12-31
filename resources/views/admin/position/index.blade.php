@extends('admin.masterAdmin')
@section('content')
<!-- BEGIN: Page content-->
<div>
  <div class="card">
    <div class="card-header">
      <h5 class="box-title">পদবি তালিকা</h5>
      <a href="{{ route('position.create') }}" class="btn btn-primary">Add New</a>
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
              <th>Position</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($positions as $position)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $position->created_at->format('d-m-y') }}</td>
              <td>{{ $position->user->name }}</td>
              <td>{{ $position->name }}</td>
              <td>
                {{ $position->description }}
              </td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('position.edit',$position->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                  </a>

                  <form action="{{ route('position.destroy',$position->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                      data-target="#deleteModal{{ $position->id }}">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            
            
  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal{{ $position->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteModalLabel">ডিলিট নিশ্চিত করুন</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          আপনি কি নিশ্চিতভাবে <strong>{{ $position->name }}</strong> ডিলিট করতে চান?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">না</button>
          <form action="{{ route('area.destroy', $position->id) }}" method="post">
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
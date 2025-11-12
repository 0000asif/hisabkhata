@extends('admin.masterAdmin')
@section('content')
<!-- BEGIN: Page content-->
<div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-fullheight">
        <div class="card-header">
          <h5 class="box-title">
            {{ isset($position) ? 'পদবি সম্পাদনা করুন' : 'পদবি এড করুন' }}
          </h5>
        </div>

        <div class="card-body">
          @include('components.alert')

          <!-- Dynamic Form: store or update -->
          <form action="{{ isset($position) ? route('position.update', $position->id) : route('position.store') }}"
            method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($position))
            @method('PUT')
            @endif

            <div class="row">
              <!-- পদবির নাম -->
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                  <label>পদবির নাম <span style="color: red;">*</span></label>
                  <input type="text" name="name" class="form-control" placeholder="পদবির নাম লিখুন"
                    value="{{ old('name', $position->name ?? '') }}" required>
                </div>
              </div>

              <!-- বিবরণ -->
              <div class="col-12">
                <div class="form-group mb-4">
                  <label>বিবরণ</label>
                  <textarea name="description" class="form-control" rows="4"
                    placeholder="পদবির বিস্তারিত বিবরণ লিখুন...">{{ old('description', $position->description ?? '') }}</textarea>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                {{ isset($position) ? 'আপডেট করুন' : 'জমা দিন' }}
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- END: Page content-->
@endsection
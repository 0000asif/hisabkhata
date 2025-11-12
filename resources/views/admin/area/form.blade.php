@extends('admin.masterAdmin')
@section('content')
<!-- BEGIN: Page content-->
<div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-fullheight">
        <div class="card-header">
          <h5 class="box-title">
            {{ isset($area) ? 'এলাকা সম্পাদনা করুন' : 'এলাকা এড করুন' }}
          </h5>
        </div>
        <div class="card-body">
          @include('components.alert')

          <!-- Dynamic Form: store or update -->
          <form action="{{ isset($area) ? route('area.update', $area->id) : route('area.store') }}"
            enctype="multipart/form-data" method="post">
            @csrf
            @if(isset($area))
            @method('PUT')
            @endif

            <div class="row">
              <!-- এলাকা নাম -->
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                  <label>এলাকার নাম <span style="color: red;">*</span></label>
                  <input class="form-control" type="text" name="name" placeholder="এলাকার নাম লিখুন"
                    value="{{ old('name', $area->name ?? '') }}" required>
                </div>
              </div>

              <!-- স্ট্যাটাস -->
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                  <label>স্ট্যাটাস <span style="color: red;">*</span></label>
                  <select class="form-control select2_demo" id="status" name="status" required>
                    <option value="">স্ট্যাটাস নির্বাচন করুন</option>
                    <option value="1" {{ old('status', $area->status ?? '') == '1' ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="0" {{ old('status', $area->status ?? '') == '0' ? 'selected' : '' }}>নিষ্ক্রিয়
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <button class="btn btn-primary mr-2" type="submit" id="collection_button">
                {{ isset($area) ? 'আপডেট করুন' : 'জমা দিন' }}
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
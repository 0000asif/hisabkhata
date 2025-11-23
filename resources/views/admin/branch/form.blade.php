@extends('admin.masterAdmin')
@section('content')
<!-- BEGIN: Page content-->
<div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-fullheight">
        <div class="card-header">
          <h5 class="box-title">
            {{ isset($branch) ? 'ব্রাঞ্চ এডিট করুন' : 'ব্রাঞ্চ এড করুন' }}
          </h5>
          <a href="{{ route('branch.index') }}" class="btn btn-success btn-sm">Black</a>
        </div>

        <div class="card-body">
          @include('components.alert')

          <form action="{{ isset($branch) ? route('branch.update', $branch->id) : 
            route('branch.store') }}"
            method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($branch))
            @method('PUT')
            @endif

            <div class="row">
              <!-- পদবির নাম -->
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                  <label>নাম <span style="color: red;">*</span></label>
                  <input type="text" name="name" class="form-control" placeholder="ব্রাঞ্চের নাম লিখুন"
                    value="{{ old('name', $branch->name ?? '') }}" required>
                </div>
              </div>

              
              <!-- পদবির নাম -->
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                   <label>স্ট্যাটাস <span class="text-danger">*</span></label>
                <select name="status" class="form-control select2_demo" required>
                  <option value="">স্ট্যাটাস নির্বাচন করুন</option>
                  <option value="1" {{ old('status', $branch->status ?? '') == 1 ? 'selected' : '' }}>সক্রিয়</option>
                  <option value="0" {{ old('status', $branch->status ?? '') == 0 ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
                </div>
              </div>
              

              <!-- ঠিকানা -->
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                  <label>ঠিকানা</label>
                  <textarea name="address" class="form-control" rows="4"
                    placeholder="ঠিকানা বিস্তারিত ভাবে লিখুন...">{{ old('address', $branch->address ?? '') }}</textarea>
                </div>
              </div>

              @if (!isset($branch))
                  <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group mb-4">
                  <label>ওপেনিং টাকা<span style="color: red;">*</span></label>
                  <input type="number" name="balance" class="form-control" placeholder="ওপেনিং টাকা"
                    value="{{ old('number') }}" required>
                </div>
              </div>
              @endif
              

            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                {{ isset($branch) ? 'আপডেট করুন' : 'জমা দিন' }} 
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
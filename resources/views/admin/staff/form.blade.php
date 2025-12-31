@extends('admin.masterAdmin')
@section('content')
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">
                            {{ isset($staff) ? 'স্টাফ সম্পাদনা করুন' : 'স্টাফ এড করুন' }}
                        </h5>
                    </div>

                    <div class="card-body">
                        @include('components.alert')

                        <form action="{{ isset($staff) ? route('staff.update', $staff->id) : route('staff.store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($staff))
                                @method('PUT')
                            @endif

                            <div class="row">

                                <!-- নাম -->
                                <div class="col-md-6 mb-3">
                                    <label>নাম <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $staff->name ?? '') }}" required>
                                </div>

                                <!-- ইমেইল -->
                                <div class="col-md-6 mb-3">
                                    <label>ইমেইল <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $staff->email ?? '') }}" required>
                                </div>

                                <!-- ফোন -->
                                <div class="col-md-6 mb-3">
                                    <label>ফোন <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $staff->phone ?? '') }}" required>
                                </div>

                                <!-- ঠিকানা -->
                                <div class="col-md-6 mb-3">
                                    <label>ঠিকানা <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $staff->address ?? '') }}" required>
                                </div>

                                <!-- পদবি -->
                                <div class="col-md-6 mb-3">
                                    <label>পদবি <span class="text-danger">*</span></label>
                                    <select name="position_id" class="form-control" required>
                                        <option value="">পদবি নির্বাচন করুন</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ old('position_id', $staff->position_id ?? '') == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- স্ট্যাটাস -->
                                <div class="col-md-6 mb-3">
                                    <label>স্ট্যাটাস <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="">স্ট্যাটাস নির্বাচন করুন</option>
                                        <option value="1"
                                            {{ old('status', $staff->status ?? '') == 1 ? 'selected' : '' }}>সক্রিয়</option>
                                        <option value="0"
                                            {{ old('status', $staff->status ?? '') == 0 ? 'selected' : '' }}>নিষ্ক্রিয়
                                        </option>
                                    </select>
                                </div>

                                <!-- ফিল্ড -->
                                <div class="col-md-6 mb-3">
                                    <label>ফিল্ড <span class="text-danger">*</span></label>
                                    <select name="feild" class="form-control" required>
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="1"
                                            {{ old('feild', $staff->feild ?? '') == 1 ? 'selected' : '' }}>হ্যাঁ</option>
                                        <option value="0"
                                            {{ old('feild', $staff->feild ?? '') == 0 ? 'selected' : '' }}>না</option>
                                    </select>
                                </div>

                                <!-- পাসওয়ার্ড (only in create or optional in edit) -->
                                <div class="col-md-6 mb-3">
                                    <label>পাসওয়ার্ড {{ isset($staff) ? '(প্রয়োজনে পরিবর্তন করুন)' : '' }} <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control"
                                        {{ isset($staff) ? '' : 'required' }}>
                                </div>

                                <!-- কনফার্ম পাসওয়ার্ড -->
                                <div class="col-md-6 mb-3">
                                    <label>পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        {{ isset($staff) ? '' : 'required' }}>
                                </div>

                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($staff) ? 'আপডেট করুন' : 'জমা দিন' }}
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

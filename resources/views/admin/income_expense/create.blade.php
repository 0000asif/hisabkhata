@extends('admin.masterAdmin')
@section('content')
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-fullheight">
                <div class="card-header">
                    <h5 class="box-title">
                        {{ isset($incomeExpense) ? 'ইনকাম / খরচ সম্পাদনা করুন' : 'ইনকাম / খরচ যোগ করুন' }}
                    </h5>
                </div>

                <div class="card-body">
                    @include('components.alert')

                    <form action="{{ isset($incomeExpense) ? route('income-expense.update', $incomeExpense->id) : route('income-expense.store') }}"
                          method="POST" enctype="multipart/form-data">

                        @csrf
                        @if(isset($incomeExpense))
                            @method('PUT')
                        @endif

                        <div class="row">

                            {{-- Date --}}
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>তারিখ <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control"
                                           value="{{ old('date', $incomeExpense->date ?? date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>ক্যাটাগরি <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control select2_demo" required>
                                        <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $incomeExpense->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>পরিমাণ <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="amount" class="form-control"
                                           placeholder="পরিমাণ লিখুন" required
                                           value="{{ old('amount', $incomeExpense->amount ?? '') }}">
                                </div>
                            </div>

                            {{-- Type --}}
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>টাইপ <span class="text-danger">*</span></label>
                                    <select name="type" class="form-control" required>
                                        <option value="">টাইপ নির্বাচন করুন</option>
                                        <option value="income" {{ old('type', $incomeExpense->type ?? '') == 'income' ? 'selected' : '' }}>ইনকাম</option>
                                        <option value="expense" {{ old('type', $incomeExpense->type ?? '') == 'expense' ? 'selected' : '' }}>খরচ</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Note --}}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label>নোট</label>
                                    <textarea name="note" class="form-control" rows="3" placeholder="নোট লিখুন">{{ old('note', $incomeExpense->note ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">
                            {{ isset($incomeExpense) ? 'আপডেট করুন' : 'জমা দিন' }}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

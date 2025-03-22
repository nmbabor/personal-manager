@extends('backend.master')

@section('title', 'গ্রাহক এর তথ্য আপডেট করুন')
@section('title_button')
    <a href="{{ route('customers.index') }}" class="btn bg-gradient-primary" >
        <i class="fas fa-list"></i>
        সব গ্রাহক দেখুন
    </a>
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
        {!! Form::open(['method' => 'put', 'route' => ['customers.update', $customer->id]]) !!}
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fullName" class="form-label">গ্রাহকের নাম<span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" id="fullName" placeholder="সম্পুর্ন নাম লিখুন"
                                name="name" value="{{ $customer->name }}" required>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="mobileNumber" class="form-label">মোবাইল নাম্বার<span class="text-danger">*</span> :</label>
                            <input type="number" min="0" class="form-control" id="mobileNumber" placeholder="মোবাইল নাম্বার"
                                name="mobile_no" value="{{ $customer->mobile_no }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address" class="form-label">ঠিকানা : </label>
                            <textarea class="form-control" id="address" placeholder="ঠিকানা লিখুন"
                                name="address">{{ $customer->address }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="word_no" class="form-label"> ওয়ার্ড নং :</label>
                            {{Form::select('word_no',$words,$customer->word_no??'',['class'=>'form-control','placeholder'=>'ওয়ার্ড নির্বাচন করুন'])}}
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="father_name" class="form-label">পিতার নাম : </label>
                            <input type="text" class="form-control" id="father_name" placeholder="পিতার নাম লিখুন"
                                name="father_name" value="{{ $customer->father_name }}">
                        </div>
                        <div class="col-3 pl-0">
                            <button type="submit" class="btn btn-block bg-gradient-primary">সাবমিট করুন</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="status" class="form-label"> স্ট্যাটাস :</label>
                            {{Form::select('status',[1=>'একটিভ',0=>'ইনেক্টিভ'],$customer->status,['class'=>'form-control'])}}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

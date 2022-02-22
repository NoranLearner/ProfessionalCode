@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-success" id="success_msg" style="display: none;"> تم الحفظ بنجاح </div>
    <form method="POST" id="offerForm" action="" enctype="multipart/form-data">
        {{-- <input name="_token" value="{{ csrf_token() }}"> --}}
        @csrf
        <div class="form-group">
            <label for="offername"> {{ __('messages.offernameAR') }} </label>
            <input type="text" class="form-control" id="offername" name="name_ar">
            @error('name_ar')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="offername"> {{ __('messages.offernameEN') }} </label>
            <input type="text" class="form-control" id="offername" name="name_en">
            @error('name_en')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="offerprice" class="form-label">{{ __('messages.offerprice') }}</label>
            <input type="text" class="form-control" id="offerprice" name="price">
            @error('price')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="offerdetails" class="form-label">{{ __('messages.offerdetailsAR') }}</label>
            <input type="text" class="form-control" id="offerdetails" name="details_ar">
            @error('details_ar')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="offerdetails" class="form-label">{{ __('messages.offerdetailsEN') }}</label>
            <input type="text" class="form-control" id="offerdetails" name="details_en">
            @error('details_en')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="offerphoto"> {{ __('messages.offerphoto') }} </label>
            <input type="file" class="form-control" id="offerphoto" name="photo">
            @error('photo')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button id="save_offer" class="btn btn-primary">{{ __('messages.saveoffer') }}</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '#save_offer', function (e) {
        e.preventDefault();

        var formData = new FormData($('#offerForm')[0]);

        $.ajax({
        type: 'post',
        enctype: 'multipart/form-data',
        url: "{{route('ajaxoffers-store')}}",
        /* data: {
            '_token' : "{{ csrf_token() }}",
            'name_ar' : $("input[name='name_ar']").val(),
            'name_en' : $("input[name='name_en']").val(),
            'price' : $("input[name='price']").val(),
            'details_ar' : $("input[name='details_ar']").val(),
            'details_en' : $("input[name='details_en']").val(),
            // 'photo' : $("input[name='photo']").val(),
        }, */
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success:function(data){
            if (data.status == true) {
                //alert(data.msg)
                $('#success_msg').show();
            }
        },

        });
    });
</script>
@endsection


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
            <small id="name_ar_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="offername"> {{ __('messages.offernameEN') }} </label>
            <input type="text" class="form-control" id="offername" name="name_en">
            <small id="name_en_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="offerprice" class="form-label">{{ __('messages.offerprice') }}</label>
            <input type="text" class="form-control" id="offerprice" name="price">
            <small id="price_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="offerdetails" class="form-label">{{ __('messages.offerdetailsAR') }}</label>
            <input type="text" class="form-control" id="offerdetails" name="details_ar">
            <small id="details_ar_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="offerdetails" class="form-label">{{ __('messages.offerdetailsEN') }}</label>
            <input type="text" class="form-control" id="offerdetails" name="details_en">
            <small id="details_en_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="offerphoto"> {{ __('messages.offerphoto') }} </label>
            <input type="file" class="form-control" id="offerphoto" name="photo">
            <small id="photo_error"class="form-text text-danger"></small>
        </div>
        <button id="save_offer" class="btn btn-primary">{{ __('messages.saveoffer') }}</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '#save_offer', function (e) {
        e.preventDefault();

        $('#photo_error').text('');
        $('#name_ar_error').text('');
        $('#name_en_error').text('');
        $('#price_error').text('');
        $('#details_ar_error').text('');
        $('#details_en_error').text('')

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
        error: function (reject) {
            var response = $.parseJSON(reject.responseText);
            $.each(response.errors, function (key, val) {
                $("#" + key + "_error").text(val[0]);
            });
        }
        });
    });
</script>
@endsection


@extends('theme.default')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">仪表板</a></li>
            <li class="breadcrumb-item">商品</li>
            <li class="breadcrumb-item active">上传Excel</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
        <div class="card add-category">
            <div class="card-body">
                <div class="container-fluid">
                    <span id="message"></span>
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="add_category" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <span id="msg"></span>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('上传Excel文件')}}</label>
                                            <input type="file" id="excelfile_selector" name="uploaded_file" class="form-control d-block">
                                            <span class="mt-2 text-danger"><strong>{{ $errors->first('excelfile') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <button id="file_submit" type="submit" class="btn btn-primary btn-block add-category-btn mt-4">
                                           {{__('上传')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- #/ container -->
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        if($('#excelfile_selector')[0].files.length === 0) $('#file_submit').prop('disabled', true);

        $("#excelfile_selector").on("change", function(e){
            if($('#excelfile_selector')[0].files.length === 0) $('#file_submit').prop('disabled', true);
            else $('#file_submit').prop('disabled', false);
        });
        
        $('#add_category').on('submit', function(event){
            event.preventDefault();
            var form_data = new FormData(this);
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/excel/upload') }}",
                method:"POST",
                data:form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(result) {
                    $("#preloader").hide();
                    var msg = '';
                    
                    if(result.error.length > 0)
                    {
                        for(var count = 0; count < result.error.length; count++)
                        {
                            msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                        }
                        $('#msg').html(msg);
                    }
                    else
                    {
                        msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                        $('#message').html(msg);
                        $("#add_category")[0].reset();
    
                        setTimeout(function(){
                        $('#message').html('');
                        }, 3000);
                    }
                },
            })
        });
    });
</script>
@endsection
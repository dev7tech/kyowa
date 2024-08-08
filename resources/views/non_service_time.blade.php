@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Set Service Time</a></li>
        </ol>
    </div>
</div> -->

<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="example">
                                <h5 class="box-title m-t-30">选择时间范围</h5>
                                <br>
                                <form method="post" id="get_report">
                                {{csrf_field()}}
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <input type="time" class="form-control" name="starttime" id="starttime" placeholder="Start Time" value="{{$servicetime->fromtime}}">
                                            <input type="hidden" class="form-control" name="timeinfo" id="timeinfo" value="{{$servicetime->id}}">
                                            </div>
                                            <div class="col-md-4">
                                            <input type="time" class="form-control" name="endtime" id="endtime" placeholder="End Time" value="{{$servicetime->totime}}">
                                            </div>
                                            <div class="col-md-4">
                                            <button type="button" class="btn mb-1 btn-flat btn-primary" onclick="SetReport()">提交</button>
                                            </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
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
    var pageVal = localStorage.getItem('pagination');
    if (pageVal < 10) {
        pageVal = 10;
    }
    $('.table').dataTable({
        pageLength: pageVal
    });

    $(document).ready(function(){
        $("#headerUrl").html("<h3>设置 > 服务时间</h3>");
    });

function SetReport() {
    var starttime = $("#starttime").val();
    var endtime   = $("#endtime").val();
    var id   = $("#timeinfo").val();
    
    $('#preloader').show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/servicetime/store') }}",
        method:'POST',
        data:{'startime':starttime,'endtime':endtime,'id':id},
        dataType: "json",
        success:function(data){
            $('#preloader').hide();
            var msg = '';
            if(data.error.length > 0)
            {
                for(var count = 0; count < result.error.length; count++)
                {
                    msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                }
                $('#message').html(msg);
                setTimeout(function(){
                    $('#message').html('');
                }, 5000);
            }else {
                msg += '<div class="alert alert-success mt-1">'+data.success+'</div>';
                $('#message').html(msg);
                setTimeout(function(){
                    $('#message').html('');
                }, 5000);
            }
           
        },
        error: function(error) {
            $('#preloader').hide();
        }
    });
}

</script>
@endsection
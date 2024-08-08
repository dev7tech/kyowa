@extends('theme.default')

@section('content')

<div class="w3-modal" style= "padding-top:0 !important" id="editPurse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editPurse').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Edit Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editPurse').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="edit_purse" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg"></span>
                <span id="message"></span>
                @csrf
                <input type="hidden" name="id" id="editid" ></input>

                <div class="form-group">
                    <label for="name" class="col-form-label" style="font-weight: bold;color:black">Point </label>
                    <input type="text" class="form-control" name="point" id="point" placeholder="">
                </div>
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editPurse').style.display='none'">取消</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                定制列
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" id="assign">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="form-group table-column-group" style="display: flex;justify-content: space-between;flex-wrap: wrap;">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="column_visible()" data-dismiss="modal">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
            </form>
        </div>

    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12"  style="padding:0;min-height:1460px">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <button id="edit_purse_btn" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" disabled onclick="GetData()">编辑</button>
                        </div>
                        
                        <div id="table-display">
                            @include('theme.pursetable')
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

    $('#purse_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {
    $("#headerUrl").html("<h3>设置 > 钱包</h3>");

    $('#advance').on('click', function(event){
         event.preventDefault();
         var form_data = new FormData(document.getElementById('edit_purse'));
         $('#preloader').show();
         $.ajax({
             url:"{{ URL::to('admin/purse/update') }}",
             method:'POST',
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
                     $("#edit_purse")[0].reset();

                     setTimeout(function(){
                       $('#msg').html('');
                     }, 3000);
                 }
                 else
                 {
                     msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                     $('#message').html(msg);
                     $("#edit_purse")[0].reset();
 
                     setTimeout(function(){
                       $('#message').html('');
                     }, 3000);
                     PurseTable();
                 }
             },
         });
     });

     $('#usual').on('click', function(event){
         event.preventDefault();
         var form_data = new FormData(document.getElementById('edit_purse'));
         $('#preloader').show();
         $.ajax({
             url:"{{ URL::to('admin/purse/update') }}",
             method:'POST',
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
                     $("#edit_purse")[0].reset();

                     setTimeout(function(){
                       $('#msg').html('');
                     }, 3000);
                 }
                 else
                 {
                     msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                     $('#message').html(msg);
                     $("#editPurse").css('display', 'none');
                     $("#edit_purse")[0].reset();
 
                     setTimeout(function(){
                       $('#message').html('');
                     }, 3000);
                     PurseTable();
                 }
             },
         });
     });

});

function clickCheckbox() {
    var $box = $(this);
    var groups = [];

    $.each($("input[name='purse_check']:checked"), function() {
        groups.push($(this).val());
    });

    if (groups.length == 0 ) {
        $('#edit_purse_btn').prop('disabled', true);
    } else if (groups.length == 1) {
        $('#edit_purse_btn').prop('disabled', false);
    } else {
        $('#edit_purse_btn').prop('disabled', true);
    }
}

function GetData() {
    var id = 0;
    $.each($("input[name='purse_check']:checked"), function() {
        id = $(this).val();
    });
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/purse/show') }}",
        data: {
            id: id
        },
        method: 'GET',
        success: function(response) {
            $('#preloader').hide();
            $("#editPurse").css('display', 'block');
            $('#editid').val(response.id);
            $('#point').val(response.point);
        },
        error: function(error) {
            $('#preloader').hide();
        }
    });

}

function PurseTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/purse/list') }}",
        method:"GET",
        success:function(data){
            $('#preloader').hide();
            $('#table-display').html(data);
            var pageVal = localStorage.getItem('pagination');
            if (pageVal < 10) {
                pageVal = 10;
            }
            $(".zero-configuration").DataTable({
                pageLength: pageVal
            });
            $('#purse_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#edit_purse_btn').prop('disabled', true);
        },
    });
}

</script>
@endsection
@extends('theme.default')

@section('content')

<div class="w3-modal" style= "padding-top:0 !important" id="editConversation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editConversation').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Set service man</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editConversation').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="edit_conversation" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg"></span>
                <span id="message"></span>
                @csrf
                <input type="hidden" name="id" id="editid" ></input>

                <div class="form-group">
                    <label for="user" class="col-form-label">User</label>
                    <select name="user" class="form-control" id="user">
                        <option value="">Select User :</option>
                        <?php
                        foreach ($users as $user) {
                        ?>
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>   
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <!-- <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button> -->
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editConversation').style.display='none'">取消</button>
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
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12"  style="padding:0; min-height:1460px">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <!-- <button id="edit_conversation_btn" type="button" disabled class="btn btn-secondary" onclick="GetData()">Edit</button> -->
                            <button id="edit_conversation_btn" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GetData()">编辑</button>
                        </div>

                        <div class="toolbar-container" style="display:flex;justify-content:space-between;padding:0 30px;">
                            <div class="search-container">
                                <input id="search_value" type="text" style="height:35px;text-indent:35px;width:500px;" placeholder="输入关键字，回车">
                                    <i class="fa-solid fa-magnifying-glass" style="margin-left:-485px;"></i>
                                </input>
                            </div>
                            <div class="table-column-container">
                                <span id="column-visible-contorol" class="column-control" style="cursor:pointer;font-size:15px;color:#545499;">
                                    <i class="fa-solid fa-gear">
                                        定制列
                                    </i>
                                </span>
                            </div>
                        </div>

                        <div id="table-display">
                            @include('theme.servicetable')
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

    $('#conversation_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {
    $("#headerUrl").html("<h3>服务</h3>");

    $('#master_checkbox').click(function(){
        $("#conversation_table #conversation_check").prop('checked',$(this).prop('checked'));
    });

    $('#master_checkbox').change(function(){
        if (!$(this).prop('checked')) {
            $('#master_checkbox').prop('checked', false);
        } else if ($('#conversation_table #conversation_check:not(:checked)').length == 0) {
            $('#master_checkbox').prop('checked', true);
        }
    });

    $('#conversation_table_filter').hide();
    $('#conversation_table_length').hide();
    $('#search_value').keyup(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if(keyCode == '13'){
            search_value = $(this).val();
            id = $('#subcateId').val();
            if(search_value == ''){
                msg = '<div class="alert alert-danger mt-1">请输入搜索值</div>';
                $('#message').html(msg);
                setTimeout(function(){
                    $('#message').html('');
                }, 3000);
                $('.table').DataTable().search('').columns().search('').draw();
            }else{
                $('.table').DataTable().search(search_value).draw();
            }
        }
    });

    $('#column-visible-contorol').on("click",function(){
        $("#myModal .table-column-group").empty();
        var columns = $(".table").DataTable().columns();
        columns.every(function(){
            if(this.index() != 0){
                var header_str = $(".table").DataTable().column(this.index()).header().textContent.trim();
                var check_box_str = '<div class="form-check">';
                if(this.visible()) check_box_str += '<input class="form-check-input" type="checkbox" class="text-center" value='+this.index()+' checked></input>';
                else check_box_str += '<input class="form-check-input" type="checkbox" class="text-center" value='+this.index()+'></input>';
                check_box_str += '<label class="form-check-label">'+header_str+'</label>';
                check_box_str += '</div>';

                $("#myModal .table-column-group").append(check_box_str);
            }
        });
        $("#myModal").modal('show');
    });

    $('#edit_conversation').on('submit', function(event){
         event.preventDefault();
         var form_data = new FormData(this);
         $('#preloader').show();
         $.ajax({
             url:"{{ URL::to('admin/service/update') }}",
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
                     $("#edit_conversation")[0].reset();

                     setTimeout(function(){
                       $('#msg').html('');
                     }, 3000);
                 }
                 else
                 {
                     msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                     $('#message').html(msg);
                     $("#editConversation").modal('hide');
                     $("#edit_conversation")[0].reset();
 
                     setTimeout(function(){
                       $('#message').html('');
                     }, 3000);
                     ConversationTable();
                 }
             },
         });
     });

});

function clickCheckbox() {
    var $box = $(this);
    var groups = [];

    $.each($("input[name='conversation_check']:checked"), function() {
        groups.push($(this).val());
    });

    if (groups.length == 0 ) {
        $('#edit_conversation_btn').prop('disabled', true);
    } else if (groups.length == 1) {
        $('#edit_conversation_btn').prop('disabled', false);
    } else {
        $('#edit_conversation_btn').prop('disabled', true);
    }
}

function GetData() {
    var id = 0;
    $.each($("input[name='conversation_check']:checked"), function() {
        id = $(this).val();
    });
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/service/show') }}",
        data: {
            id: id
        },
        method: 'GET',
        success: function(response) {
            $('#preloader').hide();
            $("#editConversation").css('display', 'block');
            $('#editid').val(response.id);
            $('#user').val(response.user_two);
        },
        error: function(error) {
            $('#preloader').hide();
        }
    })
}

function ConversationTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/service/list') }}",
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
            $('#conversation_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#edit_conversation_btn').prop('disabled', true);
        },
    });
}

function column_visible(){
    // Get the value of the checked input element
    // var checkedValue = $('.table-column-group input[type="checkbox"]:checked').val();
    var checkedValue = [];
    $.each($(".table-column-group input[type='checkbox']:checked"), function() {
        checkedValue.push($(this).val()*1);
    });

    // Log the value to the console
    // console.log(checkedValue);
    var columns = $(".table").DataTable().columns();
    columns.every(function(){
        if(this.index() != 0){
            if(checkedValue.indexOf(this.index())!== -1) this.visible(true);
            else this.visible(false);
        }
    });
    $('table#conversation_table').css('width','100%');
}

</script>
@endsection
@extends('theme.default')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="example">
                                <h5 class="box-title m-t-30">选择月</h5>
                                <form method="post" id="get_report">
                                {{csrf_field()}}
                                    <div class="input-daterange input-group" id="date-range" style="justify-content:center;align-items: center;">
                                        <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}" style="text-align: center;" presentation="YYYY-mm-dd" format="YYYY MMMM D"/>
                                        <h5 class="box-title m-t-30">日</h5>
                                        <button type="button" class="btn mb-1 btn-flat btn-primary" onclick="GetReport()">提交</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div id="table-display">
                            @include('theme.reporttable')
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
        $("#headerUrl").html("<h3>时期分析</h3>");

        $('#report_table_filter').hide();
        $('#report_table_length').hide();
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
    });

    function GetReport() {
        var date = $('#date').val();
        
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('admin/reportDay/showDay') }}",
            method:'POST',
            data:{'day':date},
            success:function(data){
                $('#preloader').hide();
                $('#table-display').html(data);
                var table = $('#report_table').DataTable( {
                    lengthChange: false,
                    buttons: [ 'excel']
                } );
            },
            error: function(error) {
                $('#preloader').hide();
            }
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
        $('table#report_table').css('width','100%');
    }

</script>
@endsection
<table id="payment_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th><input type="checkbox" class="text-center" name="master_checkbox" id="master_checkbox"></input></th>
            <th>姓名</th>
            <th>状态</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($payments as $payment) {
        ?>
        <tr id="dataid{{$payment->id}}">
            <td><input type="checkbox" class="text-center" id="payment_check" name="payment_check" value='{{$payment->id}}'></input></td>
            <td>{{$payment->name}}</td>
            <td>
                @if ($payment->status == 1)
                    <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">
                        可用的
                    </span>
                @else
                    <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">
                        不可用  
                    </span>
                @endif
                
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
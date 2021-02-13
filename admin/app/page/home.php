<?php

require_once "./app/component/import.php";

$meta_title = "Home - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

?>

<link rel="stylesheet" href="<?= $BASE ?>static/lib/datatables.min.css">
<link rel="stylesheet" href="<?= $BASE ?>static/css/table.css">
<script src="<?= $BASE ?>static/lib/datatables.min.js"></script>    

<Style> td, th { white-space: nowrap; } </style>

<div class="main">
    <div class="row">
        <div class="col s12 table-wrap z-depth-1">
        
            <table id="paymentTable" class="white">
                <thead>
                    <tr>
                        <th>
                        <a href="#add-category" class="btn modal-trigger waves-effect"><i class="material-icons">add</i></a>
                        <input id="paymentTableSearch" class="browser-default" type="text" placeholder="Search" style="width: 170px" /></th>
                        <th>User</th>
                        <th>Description</th>
                        <th>Transaction Status</th>
                        <th>Open / View / Featured</th>
                        <th>Request Date</th>
                        <th>Label / Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ajax Content -->
                </tbody>
            </table>

        </div>
    </div>
</div>


<script src="<?= $BASE ?>static/js/services/table.js?v=78"></script>
<script>
    $(function(){
        paymentTable();
        updatePayment();
    })

    function updatePayment(){
        $('body').on('change', '.account-status', function(){
            var id = $(this).data('target');  
            var tid = $(this).data('tid');  
            var v = $(this).val();

            var current = $(this).data('current');

            var message = "";

            if(v == current){
                return
            }

            switch(v){
                case "3":
                case 3:
                    message = "Proceed to delete this transaction?";
                    break;
                case "2":
                case 2:
                    message = "Proceed to set this transaction as 'expired'?";
                    break;
                case "1":
                case 1:
                    message = "Mark this user's plan as paid? if yes, the user will be granted premium priviledges for up to one year from now.";
                    break;
                case "0":
                case 0:
                    message = "Revert this transaction to 'processing'?";
                    break;
            }

            if(!confirm(message)){
                $(this).val(current);
                return;
            }

            $.ajax({
                url : root + "app/controller/post/post.payment.php?mode=update&uid="+id+"&val="+v+"&tid="+tid,
                type : 'GET',
                processData: false,
                contentType: false,  
                success : function(data) {
                    var parsedData = JSON.parse(data);
                    M.toast({
                        html: parsedData.message,
                        classes: "green white-text"
                    })
                    $("#paymentTable")
                    .DataTable()
                    .ajax.reload();

                }
            });
        })
    }

</script>    
<?php

require_once "./app/component/footer.php";
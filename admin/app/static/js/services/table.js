$(function() {
    initTables();
    uptoPro();
});


function initTables() {
    sampleTable();
}

function sampleTable() {
    $('#dataTable').DataTable({
        "pagingType": "simple",
        "bLengthChange": false
    });
    
    $('#dataTable input').keyup(function(){
        $('#dataTable').DataTable().search($(this).val()).draw();
    })
}

function reloadTables() {
    var i;
    var tables = [
        "#categoryTable",
        "#locationTable",
        "#blogTable"
    ];

    for (i = 0; i < tables.length; ++i) {
        $("" + tables[i] + "")
        .DataTable()
        .ajax.reload();
    }
}

function categoryTable() {
    $('#categoryTable').DataTable({
        "pagingType": "simple",
        "bLengthChange": false,
        
        "ajax" : root + "app/controller/get/get.category.php?mode=table",        
        "columns" : [
            { "data" : "cs_category_name"},
            { "data" : "cs_category_desciption"},
            { "data" : "cs_category_action"},
        ]
    });
    
    $('#categoryTableSearch').keyup(function(){
        $('#categoryTable').DataTable().search($(this).val()).draw();
    })
}

function userTable(type) {
    var filter = "&t=1";
    var cols = [
        { "data" : "cs_user_id"},
        { "data" : "cs_user_name"},
        { "data" : "cs_user_email"},
        { "data" : "cs_user_role"},
        { "data" : "cs_rate"},
        { "data" : "cs_account_status"},
        { "data" : "cs_account_statuss"}
    ]
    if(type == "suppliers") {
        filter = "&t=2"
        var cols = [
            { "data" : "cs_user_id"},
            { "data" : "cs_user_name"},
            { "data" : "cs_user_email"},
            { "data" : "cs_user_role"},
            { "data" : "cs_rate"},
            { "data" : "cs_account_status"},
            { "data" : "cs_account_statuss"}
        ]
    }
    $('#userTable').DataTable({
        "pagingType": "simple",
        "bLengthChange": false,
        
        "ajax" : root + "app/controller/get/get.user.php?mode=table"+filter,        
        "columns" : cols
    });
    
    $('#userTableSearch').keyup(function(){
        $('#userTable').DataTable().search($(this).val()).draw();
    })
}

function locationTable() {
    $('#locationTable').DataTable({
        "pagingType": "simple",
        "bLengthChange": false,
        
        "ajax" : root + "app/controller/get/get.location.php?mode=table",        
        "columns" : [
            { "data" : "cs_location"},
            { "data" : "cs_location_action"},
        ]
    });
    
    $('#locationTableSearch').keyup(function(){
        $('#locationTable').DataTable().search($(this).val()).draw();
    })
}

function blogTable() {
    $('#blogTable').DataTable({
        "pagingType": "simple",
        "bLengthChange": false,
        
        "ajax" : root + "app/controller/get/get.blog.php?mode=table",        
        "columns" : [
            { "data" : "cs_blog_title"},
            { "data" : "cs_blog_category"},
            { "data" : "cs_blog_added"},
            { "data" : "cs_blog_action"},
        ]
    });
    
    $('#blogTableSearch').keyup(function(){
        $('#blogTable').DataTable().search($(this).val()).draw();
    })
}

function paymentTable() {
    $('#paymentTable').DataTable({
        "pagingType": "simple",
        "bLengthChange": false,
        
        "ajax" : root + "app/controller/get/get.payment.php?mode=table",        
        "columns" : [
            { "data" : "cs_plan_id"},
            { "data" : "user"},
            { "data" : "cs_plan_payment"},
            { "data" : "statuss"},
            { "data" : "cs_plan_to"},
            { "data" : "date_added"},

            { "data" : "cs_gateway_comment"},
        ]
    });
    
    $('#paymentTableSearch').keyup(function(){
        $('#paymentTable').DataTable().search($(this).val()).draw();
    })
}


function uptoPro(){
    $('body').on('click', '.uptopro', function(){
        var id = $(this).data('target');
        if(!confirm("upgrade this user to pro for one year?")) {
            return
        }
        var v = 1;
        $.ajax({
            url : root + "app/controller/post/post.payment.php?mode=new&uid="+id+"&val="+v,
            type : 'GET',
            processData: false,
            contentType: false,  
            success : function(data) {
                var parsedData = JSON.parse(data);
                M.toast({
                    html: parsedData.message,
                    classes: "green white-text"
                })
                $("#userTable")
                .DataTable()
                .ajax.reload();

            }
        });
    })

    $('body').on('click', '.todefault', function(){
        var id = $(this).data('target');
        if(!confirm("Demote this user to free tier?")) {
            return
        }
        var v = 1;
        $.ajax({
            url : root + "app/controller/post/post.payment.php?mode=free&uid="+id+"&val="+v,
            type : 'GET',
            processData: false,
            contentType: false,  
            success : function(data) {
                var parsedData = JSON.parse(data);
                M.toast({
                    html: parsedData.message,
                    classes: "green white-text"
                })
                $("#userTable")
                .DataTable()
                .ajax.reload();

            }
        });
    })
}
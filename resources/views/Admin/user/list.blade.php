<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('PROJECT_NAME')}} | Users</title>
    @include('Admin.template.headerlink')
</head>
<body>
    <div id="wrapper">
       {{-- Sidebar goes here --}}
       @include('Admin.template.sidebar')
        <div id="page-wrapper" class="gray-bg">
            {{-- Header goes here --}}
            @include('Admin.template.header')
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>User List</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Device Type</th>
                                            <th>Social Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Footer goes here --}}
            @include('Admin.template.footer')
        </div>
    </div>
    @include('Admin.template.footerlink')
</body>
</html>
<script type="text/javascript">
var table;
$(function()
{
    // var base_url = "{{ url('/') }}";
    // var url = base_url + '/admin/user/user_list';
    var url = "{{ url('admin/user') }}";
    
    table = $('.dataTables-example').DataTable({
        'serverSide': true,
        'ajax': {
            url: url
        },
        "order": [[ 1, 'asc' ]],
        'columns': [
            {data: 'ProfilePicture', name: 'ProfilePicture', orderable: false, searchable: false,width:"10%",render:function (data, type, row) {return  "<img style='height:50px;width:50px;' src='"+data+"'>";}},
            {data: 'Name', name: 'Name'},
            {data: "Email", name: 'Email'},
            {data: "DeviceType", name: 'DeviceType'},
            {data: "SocialType", name: 'SocialType'},
            {data: 'action', name: 'action', orderable: false, searchable: false,width:"5%"},
        ]
    });
});
function DeleteUser(UserId)
{
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this user!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if(isConfirm)
        {
            var delurl = "{{url('admin/user')}}"+ "/" +UserId;
            $.ajax({
                type: "DELETE",
                url: delurl,
                data: {"_token": "{{ csrf_token() }}",'id': UserId},
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.flag == true)
                    {
                        swal("Deleted!", "User has been deleted successfully.", "success");
                        table.draw(false);
                    } else {
                        swal("Something went wrong");
                    }
                }
            });
            // $.ajax({
            //     type: "DELETE",
            //     data: {
            //         "_token": "{{ csrf_token() }}",
            //         'UserId': UserId,
            //     },
            //     url: delurl,
            //     dataType: "JSON",
            //     success: function(data) {
            //         swal("Deleted!", "User has been deleted successfully.", "success");
            //         table.draw('false');
            //     }
            // });
        }
    });
}
</script>

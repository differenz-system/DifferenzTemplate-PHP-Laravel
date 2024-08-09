$(document).ready(function () {
    let dataTable = $(".dataTables-example").DataTable({
        processing: false,
        serverSide: true,
        responsive: true,
        bDestroy: true,
        "order": [[ 1, 'asc' ]],
        ajax: {
            url: base_url + "/admin/user/user_list",
            type: "post",
        },
        columns: [
            {
                data: "ProfilePicture",
                name: "ProfilePicture",
                orderable: false,
                searchable: false,
                width: "10%",
                render: function (data, type, row) {
                    return (
                        "<img style='height:50px;width:50px;' src='" + data + "'>"
                    );
                },
            },
            {
                data: "Name",
                name: "Name",
            },
            {
                data: "Email",
                name: "Email",
            },
            {
                data: "DeviceType",
                name: "DeviceType",
            },
            {
                data: "SocialType",
                name: "SocialType",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
                width: "5%",
            },
        ],
    });

    dataTable.on("click", ".delete-link", function (e) {
        e.preventDefault();
        let link = this;

        swal(
            {
                title: "Are you suree?",
                text: "You will not be able to recover this user!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: link.href,
                        type: "DELETE",
                        dataType: "json",
                        success: function (data) {
                            if (data.flag == true) {
                                swal(
                                    "Deleted!",
                                    "User has been deleted successfully.",
                                    "success"
                                );
                                dataTable.draw(false);
                            } else {
                                swal("Something went wrong");
                            }
                        },
                    });
                }
            }
        );
    });
});

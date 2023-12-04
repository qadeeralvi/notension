<style>

img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  padding: 30px 15px 0 25px;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet" />




<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>{{$title}}</h2>
                @if($user->user_type=="user")
                    <div class="d-flex flex-row-reverse"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="createNewUser"><i
                                class="fas fa-plus"></i>add data </button>
                                </div>
                     @endif                    
                     </div>
               
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tableUser">
                            <thead class="font-weight-bold text-center">
                                <tr>
                                    {{-- <th>No.</th> --}}
                                    <th>Complain Type</th>
                                    <th>Complain Details</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th style="width:90px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="modal-user" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Add Complaint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCourse" name="formCourse"  method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_complain_id" id="user_complaint">
                    <div class="form-group">
                        <lable>Complaint Type</lable>
                        <select class="form-control" name="complaint_type" id="complaint_type">
                            <option selected disabled>Choose Complaint Type</option>
                            <option value="order">Order</option>
                            <option value="service">Services Provider</option>
                            <option value="system">System</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <lable>Complaint Detail</lable>
                        <textarea class="form-control" rows="5" name="complaint_detail" id="complaint_detail"></textarea>
                    </div>

                    <div class="form-group">
                    <lable>Image</lable>
                        <input type="file" class="form-control" name="img">
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal-user-chat" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Chat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="sendMsg" name="SendMsg"  method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="complaint_id" id="complaint_id"  />
                    <input type="hidden" name="user_id" id="user_id"  />
                <div class="messaging">
                    <div class="inbox_msg">
                        <div class="mesgs">
                            
                            <div class="msg_history">

                            </div>

                            <div class="type_msg">
                                <div class="input_msg_write">
                                <input type="text" class="write_msg" placeholder="Type a message" name="msg"/>
                                <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                </form>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="modal-complaint-status" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Complaint Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="changeStatus-form" name="changeStatus-form"  method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="complaint_id" id="complaint_id-status"  />
                    <input type="hidden" name="user_id" id="user_id-status"  />
                    <input type="hidden" name="status" value="yes"   />
                    <div class="form-group">
                        <lable>Complaint Status</lable>
                        <select class="form-control" name="complaint_status" id="complaint_status">
                            <option selected disabled>Choose Complaint Status</option>
                            <option value="Solved">Solved</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary font-weight-bold" id="changeStatus-btn">Save changes</button>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
</div>





@push('scripts')
<script>
    $('document').ready(function () {

        function swal_success() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1000
            })
        }
        // error alert
        function swal_error() {
            Swal.fire({
                position: 'centered',
                icon: 'error',
                title: 'Something goes wrong !',
                showConfirmButton: true,
            })
        }
        // table serverside
        var table = $('#tableUser').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            ajax: "{{ route('jb.index') }}",
            columns: [{
                    data: 'complaint_type',
                    },
                    {
                    data: 'complaint_detail',
                    },
                    {
                    data: 'status',
                    },
                    {
                        data:'image',
                    },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        
        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // initialize btn add
        $('#createNewUser').click(function () {
            $('#saveBtn').val("create course");
            $('#course_id').val('');
            $('#formCourse').trigger("reset");
            $('#modal-user').modal('show');
        });
        // initialize btn edit
        $('body').on('click', '.editCourse', function () {
            var course_id = $(this).data('id');
            $.get("{{route('jb.index')}}" + '/' + course_id + '/edit', function (data) {
                $('#saveBtn').val("edit-user");
                $('#modal-user').modal('show');
                $('#user_complaint').val(data.id);
                $('#complaint_type').val(data.complaint_type);
                $('#complaint_detail').val(data.complaint_detail);
            })
        });

        //show status modal

        $('body').on('click', '.changeStatus-modal', function () {
             complaint_id = $(this).data('id');
             $.get("{{route('jb.index')}}" + '/' + complaint_id , function (data) {
                $('#modal-complaint-status').modal('show');
                    console.log(data.id);

                $('#complaint_id-status').val(data.id);
                $('#user_id-status').val(data.user_id);

            })
            
        });

            //show chat
        let complaint_id =0
        $('body').on('click', '.showChat', function () {
             complaint_id = $(this).data('id');
             showChat(complaint_id)
            
        });


        function showChat(complaint_id) {

            $.get("{{route('jb.index')}}" + '/' + complaint_id , function (data) {

                    $('#modal-user-chat').modal('show');
                    $('#complaint_id').val(data.id);
                    $('#user_id').val(data.user_id);
                    let message = ''
                    for (const iterator of data.complaint_chat) {
                    message += showSms(iterator); 
                    }
                    $('.msg_history').html(message);
                    $('.write_msg').val('');

                     })
        }


        function showSms(message) {

            const mainClass =(message.send_by=="user")?'outgoing_msg':'incoming_msg';
            const secondClass =(message.send_by=="user")?'sent_msg':'received_msg';
            const thirdClass =(message.send_by=="admin")?'received_withd_msg':'';
            const html =`<div class="${mainClass}">
                                    <div class="${secondClass}">
                                        <div class="${thirdClass}">
                                        <p>${message?.message}</p>
                                        <span class="time_date"> ${message?.time}   |   ${message?.date}</span></div>
                                    </div>
                                </div>`
            return html
            
        }


        // initialize btn save
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save');
            var formData = new FormData($('#formCourse')[0]);
            $.ajax({
                // data: $('#formCourse').serialize(),
                url: "{{ route('jb.store') }}",
                method:"POST",
                data:formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#formCourse').trigger("reset");
                    $('#modal-user').modal('hide');
                    swal_success();
                    table.draw();
                },
                error: function (data) {
                    swal_error();
                    $('#saveBtn').html('Save Changes');
                }
            });

        });


    $(document).on("keydown", ".write_msg", function(event) { 
        
        e.preventDefault();
                $(this).html('Save');
                var formData = new FormData($('#sendMsg')[0]);
    
                $.ajax({
                    url: "{{ route('jb.store') }}",
                    method:"POST",
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
    
                    success: function (data) {
    
                            swal_success();
                            table.draw();
                            showChat(complaint_id)
                    },
    
                    error: function (data) {
    
                        swal_error();
                        $('#saveBtn').html('Save Changes');
    
                    }
    
                });
                
            });
        
        
        $('.msg_send_btn').click(function (e) {

            e.preventDefault();
            $(this).html('Save');
            var formData = new FormData($('#sendMsg')[0]);

            $.ajax({
                url: "{{ route('jb.store') }}",
                method:"POST",
                data:formData,
                contentType: false,
                cache: false,
                processData: false,

                success: function (data) {

                        swal_success();
                        table.draw();
                        showChat(complaint_id)
                },

                error: function (data) {

                    swal_error();
                    $('#saveBtn').html('Save Changes');

                }

            });

        });


        $('#changeStatus-btn').click(function (e) {

                e.preventDefault();
                $(this).html('Save');
                var formData = new FormData($('#changeStatus-form')[0]);

                $.ajax({
                    url: "{{ route('jb.store') }}",
                    method:"POST",
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function (data) {

                        $('#modal-complaint-status').modal('hide');
                        swal_success();
                        table.draw();
                    },

                    error: function (data) {

                        swal_error();
                        $('#saveBtn').html('Save Changes');

                    }

                });

        });


        
        
        // initialize btn delete
        $('body').on('click', '.deleteCourse', function () {
            var course_id = $(this).data("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{route('jb.store')}}" + '/' + course_id,
                        success: function (data) {
                            swal_success();
                            table.draw();
                        },
                        error: function (data) {
                            swal_error();
                        }
                    });
                }
            })
        });

        // statusing


    });

</script>
@endpush

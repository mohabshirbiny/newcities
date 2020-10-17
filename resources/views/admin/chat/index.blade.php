@extends("layouts.admin")
@section("page_title", "Create City")
@section("content")
    
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    
    <div class="content-wrapper">
        @include('layouts.alerts')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid"></div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="row">
            
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inbox</h3>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                @foreach ($messages as $message)                                    
                                    <tr>
                                        <td class="mailbox-name">
                                            <a href="javascript:;" class="customer_chat" data-customer_id="{{ $message->customer_id }}" data-toggle="modal" data-target="#modal-default">
                                                {{ $message->customer->name }}
                                            </a>
                                        </td>
                                        <td class="mailbox-subject">{{ $message->content }}</td>
                                        <td class="mailbox-date">{{ date("Y-m-d h:i A", strtotime($message->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>

                <!-- /.card-body -->
                {{ $messages->links() }}
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Default Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                            </div>
                            <!--/.direct-chat-messages-->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <form action="#" id="send-message-form" method="post">
                                <div class="input-group">
                                    <input type="hidden" name="" id="sender_customer_id" value="">
                                    <input type="text" id="message_input" name="message" required placeholder="Type Message ..." class="form-control" />
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>        

    </div>


@endsection

@section("js")
    <script>
        let url = "{{ url('/get-chat-history') }}";
        $(document).on("click", ".customer_chat", function(e) {
            $("#message_input").val("");
            let customer_id = $(this).data("customer_id");
            $("#sender_customer_id").val(customer_id);
            $.ajax({
                url: url + "/" + customer_id,
                type: "get",
                success: function(result) {
                    $(".direct-chat-messages").html(result);
                }
            });
        })

        let send_message = "{{ url('send-admin-message') }}";
        $(document).on("submit", "#send-message-form", function(e) {
            e.preventDefault();
            let message = $("#message_input").val();
            $.ajax({
                url: send_message,
                type: "post",
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                },
                data: {
                    customer_id: $("#sender_customer_id").val(),
                    content: message
                },
                success: function(result) {
                    $(".direct-chat-messages").html(result);
                    $("#message_input").val("");
                    toastr.success("Message Send successfully.");
                    $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
                }
            });
        });
    </script>
@endsection
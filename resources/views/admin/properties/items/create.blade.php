@extends("layouts.admin")
@section("page_title", "compounds")
@section("content")

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid"></div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add new gallery</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('properties.items.store', $property_id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="property_id" value="{{ $property_id }}">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label>
                                        <select name="property_item_id" class="form-control">
                                            <option value="image">Choose Item</option>
                                            @foreach ($property_items as $record)
                                                <option value="{{ $record->id }}">{{ json_decode($record->name, true)['ar'] . " - " . json_decode($record->name, true)['en']  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputFile">Count</label>
                                            <input type="number" name="count_of_items" class="form-control" placeholder="Enter count" />
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


@endsection

@section("js")
    <script src="{{ asset('admin_assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#quickForm').validate({
            rules: {
                article_category_id: {
                    required: true,
                },
                name_en: {
                    required: true,
                },
                name_ar: {
                    required: true,
                },
                brief_en: {
                    required: true,
                },
                brief_ar: {
                    required: true,
                },
                image: {
                    required: true,
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(document).on("change", "#file_type", function() {
        let file_type = $(this).val();
        if(file_type == "youtube_video") {
            $("#youtube_video_block").removeClass("d-none");
            $("#youtube_video_block input").attr("required", "required");
            $("#uploaded_file_block input").removeAttr("required");
            $("#uploaded_file_block").addClass("d-none");
        } else {
            $("#youtube_video_block").addClass("d-none");
            $("#uploaded_file_block").removeClass("d-none");
            $("#uploaded_file_block input").attr("required", "required");
            $("#youtube_video_block input").removeAttr("required");
        }
    });
    </script>
@endsection
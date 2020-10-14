@extends("layouts.admin")
@section("page_title", "cities")
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
                            <form role="form" id="quickForm" method="post" action="{{ route('cities.gallery.store', $city_id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label>
                                        <select id="file_type" name="file_type" class="form-control">
                                            <option value="image">Image</option>
                                            <option value="video">Upload Video</option>
                                            <option value="youtube_video">Youtube Video</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row" id="uploaded_file_block">
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputFile">File</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='gallery' required class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-none" id="uploaded_video_thumbnail">
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputFile">thumbnail</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='thumbnail' required class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-none" id="youtube_video_block">
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputFile">Youtube Video ID</label>
                                            <input type="text" name="gallery" class="form-control" placeholder="Enter youtube video ID" />
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

        if(file_type == "video") {
            $("#uploaded_video_thumbnail").removeClass("d-none");
            $("#uploaded_video_thumbnail input").attr("required", "required");
        } else {
            $("#uploaded_video_thumbnail").addClass("d-none");
        }
    });
    </script>
@endsection
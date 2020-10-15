@extends("layouts.admin")
@section("page_title", "Articles")
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
                                <h3 class="card-title">Edit article</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('articles.update', $article->id) }}">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select name="article_category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title_en . " - " . $category->title_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title (en)</label>
                                        <input type="text" name="title_en" class="form-control" placeholder="Enter title en" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title (ar)</label>
                                        <input type="text" name="title_ar" class="form-control" placeholder="Enter title ar" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">image</label>
                                        <input type="file" name="image" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Brief (en)</label>
                                        <textarea name="brief_en" class="form-control" id="" cols="30" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Brief (ar)</label>
                                        <textarea name="brief_ar" class="form-control" id="" cols="30" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Body (en)</label>
                                        <textarea name="body_en" class="form-control" id="" cols="30" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Body (ar)</label>
                                        <textarea name="body_ar" class="form-control" id="" cols="30" rows="2"></textarea>
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
    <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#quickForm').validate({
            rules: {
                name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter a name",
                }
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
    </script>
@endsection
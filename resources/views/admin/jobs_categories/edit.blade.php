@extends("layouts.admin")
@section("page_title", "Edit job Category")
@section("content")

    <div class="content-wrapper">
        @include('layouts.alerts')
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
                                <h3 class="card-title">Edit job Category</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('jobs-categories.update', $jobCategory->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (ar)</label>
                                            <input type="text" name="name[ar]" value='{{$jobCategory->name_ar}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('name.ar'))
                                                <span class="text-danger">{{ $errors->first('name.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (en)</label>
                                            <input type="text" name="name[en]" value='{{$jobCategory->name_en}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('name.en'))
                                                <span class="text-danger">{{ $errors->first('name.en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <img src="{{$jobCategory->icon_path}}" alt="" style="max-width: 100px;max-height: 100px;">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputFile">Icon</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='icon' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @if ($errors->has('icon'))
                                                <span class="text-danger">{{ $errors->first('icon') }}</span>
                                            @endif
                                                </div>
                                            </div>
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
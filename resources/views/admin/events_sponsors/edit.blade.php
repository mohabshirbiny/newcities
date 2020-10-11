@extends("layouts.admin")
@section("page_title", "Edit event Sponsor")
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
                                <h3 class="card-title">Edit event Sponsor</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('events-sponsors.update', $eventSponsor->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (ar)</label>
                                            <input type="text" name="title_ar" value='{{$eventSponsor->title_ar}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('title_ar'))
                                                <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (en)</label>
                                            <input type="text" name="title_en" value='{{$eventSponsor->title_en}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('title_en'))
                                                <span class="text-danger">{{ $errors->first('title_en') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (ar)</label>
                                            <input type="text" name="phone" value='{{$eventSponsor->phone}}' class="form-control" placeholder="Enter phone" />
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">website</label>
                                            <input type="text" name="website" value='{{$eventSponsor->website}}' class="form-control" placeholder="Enter website" />
                                            @if ($errors->has('website'))
                                                <span class="text-danger">{{ $errors->first('website') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <img src="{{$eventSponsor->logo_path}}" alt="" style="max-width: 100px;max-height: 100px;">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputFile">Icon</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='logo' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @if ($errors->has('logo'))
                                                <span class="text-danger">{{ $errors->first('logo') }}</span>
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
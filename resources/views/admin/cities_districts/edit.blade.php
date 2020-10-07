@extends("layouts.admin")
@section("page_title", "Edit city district")
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
                                <h3 class="card-title">Edit city district</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('city-districts.update', $cityDistrict->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label>
                                        <select name="city_id" class="form-control">
                                            <option value="">Select City1</option>
                                            <option value="">Select City2</option>
                                            <option value="">Select City3</option>
                                            @foreach ($cities as $city)
                                                <option  value="{{ $city->id }}" @if ($city->id == $cityDistrict->city_id ) selected='selected' @endif>{{ $city->name_en . " - " . $city->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (ar)</label>
                                            <input type="text" name="name_ar" value='{{ $cityDistrict->name_ar}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (en)</label>
                                            <input type="text" name="name_en" value='{{ $cityDistrict->name_en}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('name_en'))
                                                <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Location url</label>
                                            <input type="text" value="{{ $cityDistrict->location_url}}" name="location_url" class="form-control" placeholder="Enter location url  " />
                                            @if ($errors->has('location_url'))
                                                <span class="text-danger">{{ $errors->first('location_url') }}</span>
                                            @endif
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
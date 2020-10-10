@extends("layouts.admin")
@section("page_title", "Edit job")
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
                                <h3 class="card-title">Edit job</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('jobs.update', $job->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vendor</label>
                                        <select name="vendor_id" class="form-control">
                                            <option value="">Select vendor</option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" @if ($vendor->id == $job->vendor_id ) selected='selected' @endif>{{ $vendor->name_en . " - " . $vendor->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select name="job_category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($JobCategories as $category)
                                                <option value="{{ $category->id }}" @if ($category->id == $job->job_category_id ) selected='selected' @endif>{{ $category->name_en . " - " . $category->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    

                                    
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">location (ar)</label>
                                            <input type="text" name="location[ar]" value='{{$job->location_ar}}' class="form-control" placeholder="Enter location ar" />
                                            @if ($errors->has('location.ar'))
                                                <span class="text-danger">{{ $errors->first('location.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">location (en)</label>
                                            <input type="text" name="location[en]" value='{{$job->location_en}}' class="form-control" placeholder="Enter location en" />
                                            @if ($errors->has('location.en'))
                                                <span class="text-danger">{{ $errors->first('location.en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">attachment url</label>
                                                    <input type="url" value='{{$job->attachment_url}}' name='attachment_url' class="form-control" id="exampleInputFile" >
                                                    
                                                    @if ($errors->has('attachment_url'))
                                                        <span class="text-danger">{{ $errors->first('attachment_url') }}</span>
                                                    @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post title (ar)</label>
                                            <input type="text" name="post_title[ar]" value='{{$job->post_title_ar}}' class="form-control" placeholder="Enter post title ar" />
                                            @if ($errors->has('post_title.ar'))
                                                <span class="text-danger">{{ $errors->first('post_title.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post title (en)</label>
                                            <input type="text" name="post_title[en]" value='{{$job->post_title_en}}' class="form-control" placeholder="Enter post title en" />
                                            @if ($errors->has('post_title.en'))
                                                <span class="text-danger">{{ $errors->first('post_title.en') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Post date</label>
                                            <input type="date" value='{{$job->post_date}}' name="post_date" class="form-control" placeholder="Enter post date" />
                                            @if ($errors->has('post_date'))
                                                <span class="text-danger">{{ $errors->first('post_date') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post description (en)</label>
                                            <textarea name="post_description[en]" class="form-control" id="" cols="30" rows="2">{{$job->post_description_en}}</textarea>
                                            @if ($errors->has('post_description.en'))
                                                <span class="text-danger">{{ $errors->first('post_description.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post description (ar)</label>
                                            <textarea name="post_description[ar]" class="form-control" id="" cols="30" rows="2">{{$job->post_description_ar}}</textarea>
                                            @if ($errors->has('post_description.ar'))
                                                <span class="text-danger">{{ $errors->first('post_description.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">job requirements (en)</label>
                                            <textarea name="job_requirements[en]" class="form-control" id="" cols="30" rows="2">{{$job->job_requirements_en}}</textarea>
                                            @if ($errors->has('job_requirements.en'))
                                                <span class="text-danger">{{ $errors->first('post_dejob_requirementsription.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">job requirements (ar)</label>
                                            <textarea name="job_requirements[ar]" class="form-control" id="" cols="30" rows="2">{{$job->job_requirements_ar}}</textarea>
                                            @if ($errors->has('job_requirements.ar'))
                                                <span class="text-danger">{{ $errors->first('job_requirements.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">email </label>
                                            <input type="email" value="{{$job->email}}" name="email" class="form-control" placeholder="Enter email" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">mobile</label>
                                            <input type="number" value="{{$job->mobile}}" name="mobile" class="form-control" placeholder="Enter mobile" />
                                            @if ($errors->has('mobile'))
                                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
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
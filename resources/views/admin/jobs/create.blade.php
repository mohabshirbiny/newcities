@extends("layouts.admin")
@section("page_title", "Create Job")
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
                                <h3 class="card-title">Add new job</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('jobs.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vendor</label>
                                        <select name="vendor_id" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name_en . " - " . $vendor->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select name="job_category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name_en . " - " . $category->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    

                                    
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">location (ar)</label>
                                            <input type="text" name="location[ar]" value='{{old('location.ar')}}' class="form-control" placeholder="Enter location ar" />
                                            @if ($errors->has('location.ar'))
                                                <span class="text-danger">{{ $errors->first('location.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">location (en)</label>
                                            <input type="text" name="location[en]" value='{{old('location.en')}}' class="form-control" placeholder="Enter location en" />
                                            @if ($errors->has('location.en'))
                                                <span class="text-danger">{{ $errors->first('location.en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">attachment url</label>
                                                    <input type="url" name='attachment_url' class="form-control" id="exampleInputFile" >
                                                    
                                                    @if ($errors->has('attachment_url'))
                                                        <span class="text-danger">{{ $errors->first('attachment_url') }}</span>
                                                    @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post title (ar)</label>
                                            <input type="text" name="post_title[ar]" value='{{old('post_title.ar')}}' class="form-control" placeholder="Enter post title ar" />
                                            @if ($errors->has('post_title.ar'))
                                                <span class="text-danger">{{ $errors->first('post_title.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post title (en)</label>
                                            <input type="text" name="post_title[en]" value='{{old('post_title.en')}}' class="form-control" placeholder="Enter post title en" />
                                            @if ($errors->has('post_title.en'))
                                                <span class="text-danger">{{ $errors->first('post_title.en') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Post date</label>
                                            <input type="date" value='{{old('post_date')}}' name="post_date" class="form-control" placeholder="Enter post date" />
                                            @if ($errors->has('post_date'))
                                                <span class="text-danger">{{ $errors->first('post_date') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post description (en)</label>
                                            <textarea name="post_description[en]" class="form-control" id="" cols="30" rows="2">{{old('post_description.en')}}</textarea>
                                            @if ($errors->has('post_description.en'))
                                                <span class="text-danger">{{ $errors->first('post_description.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">post description (ar)</label>
                                            <textarea name="post_description[ar]" class="form-control" id="" cols="30" rows="2">{{old('post_description.ar')}}</textarea>
                                            @if ($errors->has('post_description.ar'))
                                                <span class="text-danger">{{ $errors->first('post_description.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">job requirements (en)</label>
                                            <textarea name="job_requirements[en]" class="form-control" id="" cols="30" rows="2">{{old('job_requirements.en')}}</textarea>
                                            @if ($errors->has('job_requirements.en'))
                                                <span class="text-danger">{{ $errors->first('post_dejob_requirementsription.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">job requirements (ar)</label>
                                            <textarea name="job_requirements[ar]" class="form-control" id="" cols="30" rows="2">{{old('job_requirements.ar')}}</textarea>
                                            @if ($errors->has('job_requirements.ar'))
                                                <span class="text-danger">{{ $errors->first('job_requirements.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">email </label>
                                            <input type="email" value="{{old('bookemailvalue')}}" name="email" class="form-control" placeholder="Enter email" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">mobile</label>
                                            <input type="number" value="{{old('mobile')}}" name="mobile" class="form-control" placeholder="Enter mobile" />
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
    </script>
@endsection
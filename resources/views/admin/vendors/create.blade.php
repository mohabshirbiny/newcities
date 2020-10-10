@extends("layouts.admin")
@section("page_title", "vendors")
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
                                <h3 class="card-title">Add new vendor</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select name="vendor_category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ json_decode($category->name, true)['en'] . " - " . json_decode($category->name, true)['ar'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">City</label>
                                            <select name="city_id" class="form-control" id="city_id">
                                                <option value="">Select city</option>
                                                @foreach ($cities as $record)
                                                    <option value="{{ $record->id }}">{{ $record->name_en . " - " . $record->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Parent</label>
                                            <select name="parent_id" class="form-control" id="city_id">
                                                <option value="">Select parent</option>
                                                @foreach ($vendors as $record)
                                                    <option value="{{ $record->id }}">{{ json_decode($record->name, true)['en'] . " - " . json_decode($record->name, true)['ar'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Facebook</label>
                                            <input type="text" name="social_media[facebook]" value='{{old('social_media.facebook')}}' class="form-control" placeholder="Enter facebook" />                                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Twitter</label>
                                            <input type="text" name="social_media[twitter]" value='{{old('social_media.twitter')}}' class="form-control" placeholder="Enter twitter" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Instagram</label>
                                            <input type="text" name="social_media[instagram]" value='{{old('social_media.instagram')}}' class="form-control" placeholder="Enter instagram" />                                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Youtube</label>
                                            <input type="text" name="social_media[youtube]" value='{{old('social_media.youtube')}}' class="form-control" placeholder="Enter youtube" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (ar)</label>
                                            <input type="text" name="name[ar]" value='{{old('name.ar')}}' class="form-control" placeholder="Enter name ar" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (en)</label>
                                            <input type="text" name="name[en]" value='{{old('name.en')}}' class="form-control" placeholder="Enter name en" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">about (ar)</label>
                                            <textarea name="about[ar]" class="form-control" id="" cols="30" rows="2">{{old('about.ar')}}</textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">about (en)</label>
                                            <textarea name="about[en]" class="form-control" id="" cols="30" rows="2">{{old('about.en')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">email</label>
                                            <input type="text" name="contact_details[email]" value='{{old('contact_details.email')}}' class="form-control" placeholder="Enter email" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">website</label>
                                            <input type="text" name="contact_details[website]" value='{{old('contact_details.website')}}' class="form-control" placeholder="Enter website" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">mobile</label>
                                            <input type="text" name="contact_details[mobile]" value='{{old('contact_details.mobile')}}' class="form-control" placeholder="Enter mobile" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">phone</label>
                                            <input type="text" name="contact_details[phone]" value='{{old('contact_details.phone')}}' class="form-control" placeholder="Enter phone" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">whatsapp</label>
                                            <input type="text" name="contact_details[whatsapp]" value='{{old('contact_details.whatsapp')}}' class="form-control" placeholder="Enter whatsapp" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">working hours</label>
                                            <input type="text" name="contact_details[working_hours]" value='{{old('contact_details.working_hours')}}' class="form-control" placeholder="Enter working hours" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">address</label>
                                            <input type="text" name="contact_details[address]" value='{{old('contact_details.address')}}' class="form-control" placeholder="Enter address" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">location URL</label>
                                            <input type="text" name="location_url" value='{{old('location_url')}}' class="form-control" placeholder="Enter location URL" />
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='logo' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">cover</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='cover' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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

    $(document).on("change", "#city_id", function() {

    });
    </script>
@endsection
@extends("layouts.admin")
@section("page_title", "Create event")
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
                                <h3 class="card-title">Add new event</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('events.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">

                                            <label for="exampleInputEmail1">Event category</label>
                                            <select name="event_category_id" class="form-control">
                                                <option value="">Select Event Category</option>
                                                @foreach ($EventCategories as $EventCategory)
                                                    <option value="{{ $EventCategory->id }}">{{ $EventCategory->title_en . " - " . $EventCategory->title_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">City</label>
                                            <select name="city_id" class="form-control">
                                                <option value="">Select City</option>
                                                @foreach ($cities as $City)
                                                    <option value="{{ $City->id }}">{{ $City->name_en . " - " . $City->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (ar)</label>
                                            <input type="text" name="title_ar" value='{{old('title_ar')}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('title_ar'))
                                                <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (en)</label>
                                            <input type="text" name="title_en" value='{{old('title_en')}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('title_en'))
                                                <span class="text-danger">{{ $errors->first('title_en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        {{-- <div class="form-group col-md-6">
                                            <label for="exampleInputFile">Logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='logo' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @if ($errors->has('logo'))
                                                <span class="text-danger">{{ $errors->first('logo') }}</span>
                                            @endif
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">Cover</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='cover' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @if ($errors->has('cover'))
                                                <span class="text-danger">{{ $errors->first('cover') }}</span>
                                            @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">about (en)</label>
                                            <textarea name="about_en" class="form-control" id="" cols="30" rows="2">{{old('about_en')}}</textarea>
                                            @if ($errors->has('about_en'))
                                                <span class="text-danger">{{ $errors->first('about_en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">About (ar)</label>
                                            <textarea name="about_ar" class="form-control" id="" cols="30" rows="2">{{old('about_ar')}}</textarea>
                                            @if ($errors->has('about_ar'))
                                                <span class="text-danger">{{ $errors->first('about_ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Date from </label>
                                            <input type="date" value='{{old('date_from')}}' name="date_from" class="form-control" placeholder="Enter Email" />
                                            @if ($errors->has('date_from'))
                                                <span class="text-danger">{{ $errors->first('date_from') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Date to</label>
                                            <input type="date" value='{{old('date_to')}}' name="date_to" class="form-control" placeholder="Enter Website" />
                                            @if ($errors->has('date_to'))
                                                <span class="text-danger">{{ $errors->first('date_to') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Time from </label>
                                            <input type="time" value='{{old('time_from')}}' name="time_from" class="form-control" placeholder="Enter time from" />
                                            @if ($errors->has('time_from'))
                                                <span class="text-danger">{{ $errors->first('time_from') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Time to</label>
                                            <input type="time" value='{{old('time_to')}}' name="time_to" class="form-control" placeholder="Enter time to" />
                                            @if ($errors->has('time_to'))
                                                <span class="text-danger">{{ $errors->first('time_to') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Email </label>
                                            <input type="email" value='{{old('contact_details.email')}}' name="contact_details[email]" class="form-control" placeholder="Enter Email" />
                                            @if ($errors->has('contact_details'))
                                                <span class="text-danger">{{ $errors->first('contact_details') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Website</label>
                                            <input type="url" value='{{old('contact_details.website')}}' name="contact_details[website]" class="form-control" placeholder="Enter Website" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Mobile </label>
                                            <input type="number" {{old('contact_details.mobile')}} name="contact_details[mobile]" class="form-control" placeholder="Enter Mobile" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Telephone</label>
                                            <input type="text" {{old('contact_details.telephone')}} name="contact_details[telephone]" class="form-control" placeholder="Enter Telephone" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Address</label>
                                            <input type="text {{old('contact_details.address')}}" name="contact_details[address]" class="form-control" placeholder="Enter Address " />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">whatsapp</label>
                                            <input type="text" {{old('contact_details.whatsapp')}} name="contact_details[whatsapp]" class="form-control" placeholder="Enter whatsapp" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Facebook </label>
                                            <input type="text" value="{{old('social_links.facebook')}}" name="social_links[facebook]" class="form-control" placeholder="Enter Facebook " />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">twitter </label>
                                            <input type="text" value="{{old('social_links.twitter')}}" name="social_links[twitter]" class="form-control" placeholder="Enter twitter " />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Instagram</label>
                                            <input type="text" value="{{old('social_links.instagram')}}" name="social_links[instagram]" class="form-control" placeholder="Enter Instagram  " />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">YouTube</label>
                                            <input type="text" value="{{old('social_links.youTube')}}" name="social_links[youTube]" class="form-control" placeholder="Enter YouTube" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Location url</label>
                                            <input type="url" value="{{old('location_url')}}" name="location_url" class="form-control" placeholder="Enter location url  " />
                                            @if ($errors->has('location_url'))
                                                <span class="text-danger">{{ $errors->first('location_url') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">City url</label>
                                            <input type="url" value="{{old('city_location')}}" name="city_location" class="form-control" placeholder="Enter location url  " />
                                            @if ($errors->has('city_location'))
                                                <span class="text-danger">{{ $errors->first('city_location') }}</span>
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
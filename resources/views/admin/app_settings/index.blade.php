@extends("layouts.admin")
@section("page_title", "Edit App settings")
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
                                <h3 class="card-title">App settings</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    
 
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                          <a class="nav-link active" id="contact_details-tab" data-toggle="tab" href="#contact_details" role="tab" aria-controls="contact_details" aria-selected="true">Contact Details</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="social_links-tab" data-toggle="tab" href="#social_links" role="tab" aria-controls="social_links" aria-selected="false">Social links</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="help-tab" data-toggle="tab" href="#help" role="tab" aria-controls="help" aria-selected="false">Help</a>
                                        </li>
                                      </ul>
                                      <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="contact_details" role="tabpanel" aria-labelledby="contact_details-tab">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">about (en)</label>
                                                    <textarea name="about_us[en]" class="form-control" id="" cols="30" rows="2">{{$appSettingsData['about_us']['en']}}</textarea>
                                                    @if ($errors->has('about_us.en'))
                                                        <span class="text-danger">{{ $errors->first('about.en') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">About (ar)</label>
                                                    <textarea name="about_us[ar]" class="form-control" id="" cols="30" rows="2">{{$appSettingsData['about_us']['ar']}}</textarea>
                                                    @if ($errors->has('about_us.ar'))
                                                        <span class="text-danger">{{ $errors->first('about.ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Terms (en)</label>
                                                    <textarea name="terms[en]" class="form-control" id="" cols="30" rows="2">{{$appSettingsData['terms']['en']}}</textarea>
                                                    @if ($errors->has('terms.en'))
                                                        <span class="text-danger">{{ $errors->first('terms.en') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Terms (ar)</label>
                                                    <textarea name="terms[ar]" class="form-control" id="" cols="30" rows="2">{{$appSettingsData['terms']['ar']}}</textarea>
                                                    @if ($errors->has('terms.ar'))
                                                        <span class="text-danger">{{ $errors->first('terms.ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Email </label>
                                                    <input type="email" value='{{$appSettingsData['contact_details']['email']}}' name="contact_details[email]" class="form-control" placeholder="Enter Email" />
                                                    @if ($errors->has('contact_details'))
                                                        <span class="text-danger">{{ $errors->first('contact_details') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Website</label>
                                                    <input type="url" value='{{$appSettingsData['contact_details']['website']}}' name="contact_details[website]" class="form-control" placeholder="Enter Website" />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Mobile </label>
                                                    <input type="number" value="{{$appSettingsData['contact_details']['mobile']}}" name="contact_details[mobile]" class="form-control" placeholder="Enter Mobile" />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Telephone</label>
                                                    <input type="text" value="{{$appSettingsData['contact_details']['telephone']}}" name="contact_details[telephone]" class="form-control" placeholder="Enter Telephone" />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Address</label>
                                                    <input type="text" value="{{$appSettingsData['contact_details']['address']}}" name="contact_details[address]" class="form-control" placeholder="Enter Address " />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">whatsapp</label>
                                                    <input type="text" value="{{$appSettingsData['contact_details']['whatsapp']}}" name="contact_details[whatsapp]" class="form-control" placeholder="Enter whatsapp" />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Location url</label>
                                                    <input type="text" value="{{$appSettingsData['contact_details']['location_url']}}" name="contact_details[location_url]" class="form-control" placeholder="Enter location url  " />
                                                    @if ($errors->has('location_url'))
                                                        <span class="text-danger">{{ $errors->first('location_url') }}</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Working hours</label>
                                                    <input type="text" value="{{$appSettingsData['contact_details']['working_hours']}}" name="contact_details[working_hours]" class="form-control" placeholder="Enter working hours  " />
                                                    @if ($errors->has('working_hours'))
                                                        <span class="text-danger">{{ $errors->first('working_hours') }}</span>
                                                    @endif
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="social_links" role="tabpanel" aria-labelledby="social_links-tab">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Facebook </label>
                                                    <input type="text" value="{{$appSettingsData['social_links']['facebook']}}" name="social_links[facebook]" class="form-control" placeholder="Enter Facebook " />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">twitter </label>
                                                    <input type="text" value="{{$appSettingsData['social_links']['twitter']}}" name="social_links[twitter]" class="form-control" placeholder="Enter twitter " />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Instagram</label>
                                                    <input type="text" value="{{$appSettingsData['social_links']['instagram']}}" name="social_links[instagram]" class="form-control" placeholder="Enter Instagram  " />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">YouTube</label>
                                                    <input type="text" value="{{$appSettingsData['social_links']['youTube']}}" name="social_links[youTube]" class="form-control" placeholder="Enter YouTube" />
                                                    @if ($errors->has('name_ar'))
                                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="help" role="tabpanel" aria-labelledby="help-tab">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">question (ar)</label>
                                                    <input type="text" value="" name="help[ar][question]" class="form-control" placeholder="Enter location url  " />
                                                    @if ($errors->has('location_url'))
                                                        <span class="text-danger">{{ $errors->first('location_url') }}</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">question (en)</label>
                                                    <input type="text" value="" name="help[en][question]" class="form-control" placeholder="Enter working hours  " />
                                                    @if ($errors->has('working_hours'))
                                                        <span class="text-danger">{{ $errors->first('working_hours') }}</span>
                                                    @endif
                                                </div>
                                                
                                            </div>
        
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Answer (en)</label>
                                                    <textarea name="help[en][answer]" class="form-control" id="" cols="30" rows="2"></textarea>
                                                    @if ($errors->has('about_us.en'))
                                                        <span class="text-danger">{{ $errors->first('about.en') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="exampleInputEmail1">Answer (ar)</label>
                                                    <textarea name="help[ar][answer]" class="form-control" id="" cols="30" rows="2"></textarea>
                                                    @if ($errors->has('about_us.ar'))
                                                        <span class="text-danger">{{ $errors->first('about.ar') }}</span>
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
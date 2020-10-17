@extends("layouts.admin")
@section("page_title", "compounds")
@section("content")

    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

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
                                <h3 class="card-title">edit compound</h3>
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('compounds.update', $id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-body">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">City</label>
                                            <select name="city_id" class="form-control" id="city_id">
                                                <option value="">Select city</option>
                                                @foreach ($cities as $record)
                                                    <option value="{{ $record->id }}" @if($details->city_id == $record->id) selected @endif>{{ $record->name_en . " - " . $record->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">District</label>
                                            <select name="district_id" class="form-control" id="district_id">
                                                <option value="">Select district</option>
                                                @foreach ($districts as $record)
                                                    <option value="{{ $record->id }}" @if($details->district_id == $record->id) selected @endif>{{ $record->name_en . " - " . $record->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Facilites</label>
                                            <select name="use_facilities" class="form-control">
                                                <option value="1" @if($details->use_facilities == 1) selected @endif>On</option>
                                                <option value="0" @if($details->use_facilities == 0) selected @endif>Off</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Developer(s)</label>
                                            <select name="developers[]" class="select2" data-placeholder="Select a developer" style="width: 100%;" multiple>
                                                @foreach ($data['developers'] as $record)
                                                    <option value="{{ $record->id }}" @if(in_array($record->id, $data['selected_developers'])) selected @endif>{{ json_decode($record->name, true)['en'] . " - " . json_decode($record->name, true)['ar'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Contractor(s)</label>
                                            <select name="contractors[]" class="select2" data-placeholder="Select a contractor" style="width: 100%;" multiple>
                                                @foreach ($data['contractors'] as $record)
                                                    <option value="{{ $record->id }}" @if(in_array($record->id, $data['selected_contractors'])) selected @endif>{{ json_decode($record->name, true)['en'] . " - " . json_decode($record->name, true)['ar'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Facebook</label>
                                            <input type="text" name="social_media[facebook]" value='{{ $details->social_media['facebook'] }}' class="form-control" placeholder="Enter facebook" />                                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Twitter</label>
                                            <input type="text" name="social_media[twitter]" value='{{ $details->social_media['twitter'] }}' class="form-control" placeholder="Enter twitter" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Instagram</label>
                                            <input type="text" name="social_media[instagram]" value='{{ $details->social_media['instagram'] }}' class="form-control" placeholder="Enter instagram" />                                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Youtube</label>
                                            <input type="text" name="social_media[youtube]" value='{{ $details->social_media['youtube'] }}' class="form-control" placeholder="Enter youtube" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (ar)</label>
                                            <input type="text" name="name[ar]" value='{{ $details->name['ar'] }}' class="form-control" placeholder="Enter name ar" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">name (en)</label>
                                            <input type="text" name="name[en]" value='{{ $details->name['en'] }}' class="form-control" placeholder="Enter name en" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">about (ar)</label>
                                            <textarea name="about[ar]" class="form-control" id="" cols="30" rows="2">{{ $details->about['ar'] }}</textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">about (en)</label>
                                            <textarea name="about[en]" class="form-control" id="" cols="30" rows="2">{{ $details->about['en'] }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">email</label>
                                            <input type="text" name="contact_details[email]" value='{{ $details->contact_details['email'] }}' class="form-control" placeholder="Enter email" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">website</label>
                                            <input type="text" name="contact_details[website]" value='{{ $details->contact_details['website'] }}' class="form-control" placeholder="Enter website" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">mobile</label>
                                            <input type="text" name="contact_details[mobile]" value='{{ $details->contact_details['mobile'] }}' class="form-control" placeholder="Enter mobile" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">phone</label>
                                            <input type="text" name="contact_details[phone]" value='{{ $details->contact_details['phone'] }}' class="form-control" placeholder="Enter phone" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">whatsapp</label>
                                            <input type="text" name="contact_details[whatsapp]" value='{{ $details->contact_details['whatsapp'] }}' class="form-control" placeholder="Enter whatsapp" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">working hours</label>
                                            <input type="text" name="contact_details[working_hours]" value='{{ $details->contact_details['working_hours'] }}' class="form-control" placeholder="Enter working hours" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">address</label>
                                            <input type="text" name="contact_details[address]" value='{{ $details->contact_details['address'] }}' class="form-control" placeholder="Enter address" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">location URL</label>
                                            <input type="text" name="location_url" value='{{ $details->location_url }}' class="form-control" placeholder="Enter location URL" />
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">logo</label>
                                            <img style="width: 50px;" src="{{  $details->logo_path }}" alt="">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='logo' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">cover</label>
                                            <img style="width: 50px;" src="{{ $details->cover_path }}" alt="">
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
    <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2()

        $('#quickForm').validate({
            rules: {
                location_url: {
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
        $(document).on("change", "#city_id", function(e) {
            let city_id = $(this).val();
            if(city_id != "") {
                $.ajax({
                    url: "{{ url('admin/compounds/get-districts/') }}/" + city_id,
                    type: "get",
                    success: function(result) {
                        $("#district_id").html(result);
                    }
                });
            }
        });
    });
    </script>
@endsection
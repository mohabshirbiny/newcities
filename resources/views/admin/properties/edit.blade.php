@extends("layouts.admin")
@section("page_title", "properties")
@section("content")

    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

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
                                <h3 class="card-title">edit property</h3>
                            </div>
                            
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('properties.update', $id) }}" enctype="multipart/form-data">
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
                                            <label for="exampleInputEmail1">Facilites</label>
                                            <select name="facilities[]" class="select2" data-placeholder="Select a facility" style="width: 100%;" multiple>
                                                @foreach ($facilities as $facility_id => $facility_name)
                                                
                                                    <option value="{{ $facility_id }}" @if(in_array($record->id, $selected_facilities)) selected @endif>{{ json_decode($facility_name, true)['en'] . " - " . json_decode($facility_name, true)['ar'] }}</option>                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1">Developer</label>
                                            <select name="developer_id" class="form-control">
                                                <option value="">Select Developer</option>
                                                @foreach ($developers as $record)
                                                    <option value="{{ $record->id }}" @if($details->developer_id == $record->id) selected @endif>{{ json_decode($record->name, true)['en'] . " - " . json_decode($record->name, true)['ar'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Compound</label>
                                            <select name="compound_id" class="form-control">
                                                <option value="">Select Compound</option>
                                                @foreach ($compounds as $record)
                                                    <option value="{{ $record->id }}" @if($details->compound_id == $record->id) selected @endif>{{ json_decode($record->name, true)['en'] . " - " . json_decode($record->name, true)['ar'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Property Type</label>
                                            <select name="property_type_id" class="form-control">
                                                <option value="">Choose Property Type</option>
                                                @foreach ($property_types as $record)
                                                    <option value="{{ $record->id }}" @if($details->property_type_id == $record->id) selected @endif>{{ json_decode($record->name, true)['en'] . " - " . json_decode($record->name, true)['ar'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="1" @if(1 == $details->status) selected @endif>Residential</option>
                                                <option value="2" @if(2 == $details->status) selected @endif>Commercial</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Property Id</label>
                                                <input type="text" name="property_id" value='{{ $details->property_id }}' class="form-control" placeholder="Enter property id" />
                                            </div>
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
                                            <label for="exampleInputFile">cover</label>
                                            <img style="width: 50px;" src="{{  $details->cover_path }}" alt="">
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
@extends("layouts.admin")
@section("page_title", "Create Tender")
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
                                <h3 class="card-title">Add new tender</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('tenders.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label>
                                        <select name="city_id" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name_en . " - " . $city->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select name="tender_category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name_en . " - " . $category->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (ar)</label>
                                            <input type="text" name="title[ar]" value='{{old('title.ar')}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('title_ar'))
                                                <span class="text-danger">{{ $errors->first('title.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (en)</label>
                                            <input type="text" name="title[en]" value='{{old('title.en')}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('title_en'))
                                                <span class="text-danger">{{ $errors->first('title.en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='image' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">attachment</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name='attachment' class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    @if ($errors->has('attachment'))
                                                <span class="text-danger">{{ $errors->first('attachment') }}</span>
                                            @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Body (en)</label>
                                            <textarea name="body[en]" class="form-control" id="" cols="30" rows="2">{{old('body.en')}}</textarea>
                                            @if ($errors->has('body.en'))
                                                <span class="text-danger">{{ $errors->first('body.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Body (ar)</label>
                                            <textarea name="body[ar]" class="form-control" id="" cols="30" rows="2">{{old('body.ar')}}</textarea>
                                            @if ($errors->has('body.ar'))
                                                <span class="text-danger">{{ $errors->first('body.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">brief (en)</label>
                                            <textarea name="brief[en]" class="form-control" id="" cols="30" rows="2">{{old('brief.en')}}</textarea>
                                            @if ($errors->has('brief.en'))
                                                <span class="text-danger">{{ $errors->first('brief.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">brief (ar)</label>
                                            <textarea name="brief[ar]" class="form-control" id="" cols="30" rows="2">{{old('brief.ar')}}</textarea>
                                            @if ($errors->has('brief.ar'))
                                                <span class="text-danger">{{ $errors->first('brief.ar') }}</span>
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
                                            <label for="exampleInputEmail1">Book value </label>
                                            <input type="text" value="{{old('book_value')}}" name="book_value" class="form-control" placeholder="Enter Book value" />
                                            @if ($errors->has('book_value'))
                                                <span class="text-danger">{{ $errors->first('book_value') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Insurance Value</label>
                                            <input type="text" value="{{old('insurance_value')}}" name="insurance_value" class="form-control" placeholder="Enter Insurance Value" />
                                            @if ($errors->has('insurance_value'))
                                                <span class="text-danger">{{ $errors->first('insurance_value') }}</span>
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
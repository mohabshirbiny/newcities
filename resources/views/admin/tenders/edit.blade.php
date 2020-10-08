@extends("layouts.admin")
@section("page_title", "Edit tender")
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
                                <h3 class="card-title">Edit tender</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('tenders.update', $tender->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label>
                                        <select name="city_id" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" @if ($city->id == $tender->city_id ) selected='selected' @endif>{{ $city->name_en . " - " . $city->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select name="tender_category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($TenderCategories as $category)
                                                <option value="{{ $category->id }}" @if ($category->id == $tender->tender_category_id ) selected='selected' @endif>{{ $category->name_en . " - " . $category->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (ar)</label>
                                            <input type="text" name="title[ar]" value='{{$tender->title_ar}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('title_ar'))
                                                <span class="text-danger">{{ $errors->first('title.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (en)</label>
                                            <input type="text" name="title[en]" value='{{$tender->title_en}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('title_en'))
                                                <span class="text-danger">{{ $errors->first('title.en') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <img src="{{$tender->image_path}}" alt="" style="max-width: 100px;max-height: 100px;">
                                        </div>
                                        <div class="form-group col-md-3">
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
                                            <textarea name="body[en]" class="form-control" id="" cols="30" rows="2">{{$tender->body_en}}</textarea>
                                            @if ($errors->has('body.en'))
                                                <span class="text-danger">{{ $errors->first('body.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Body (ar)</label>
                                            <textarea name="body[ar]" class="form-control" id="" cols="30" rows="2">{{$tender->body_ar}}</textarea>
                                            @if ($errors->has('body.ar'))
                                                <span class="text-danger">{{ $errors->first('body.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">brief (en)</label>
                                            <textarea name="brief[en]" class="form-control" id="" cols="30" rows="2">{{$tender->brief_en}}</textarea>
                                            @if ($errors->has('brief.en'))
                                                <span class="text-danger">{{ $errors->first('brief.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">brief (ar)</label>
                                            <textarea name="brief[ar]" class="form-control" id="" cols="30" rows="2">{{$tender->brief_ar}}</textarea>
                                            @if ($errors->has('brief.ar'))
                                                <span class="text-danger">{{ $errors->first('brief.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Date from </label>
                                            <input type="date" value='{{$tender->date_from}}' name="date_from" class="form-control" placeholder="Enter Email" />
                                            @if ($errors->has('date_from'))
                                                <span class="text-danger">{{ $errors->first('date_from') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Date to</label>
                                            <input type="date" value='{{$tender->date_to}}' name="date_to" class="form-control" placeholder="Enter Website" />
                                            @if ($errors->has('date_to'))
                                                <span class="text-danger">{{ $errors->first('date_to') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Book value </label>
                                            <input type="text" value="{{$tender->book_value}}" name="book_value" class="form-control" placeholder="Enter Book value" />
                                            @if ($errors->has('book_value'))
                                                <span class="text-danger">{{ $errors->first('book_value') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Insurance Value</label>
                                            <input type="text" value="{{$tender->insurance_value}}" name="insurance_value" class="form-control" placeholder="Enter Insurance Value" />
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
@extends("layouts.admin")
@section("page_title", "Create Offer")
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
                                <h3 class="card-title">Add new Offer</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="quickForm" method="post" action="{{ route('offers.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer category</label>
                                        <select name="offer_category_id" class="form-control">
                                            <option value="">Select Offer Category</option>
                                            @foreach ($OfferCategories as $OfferCategory)
                                                <option value="{{ $OfferCategory->id }}">{{ $OfferCategory->name_en . " - " . $OfferCategory->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vendor</label>
                                        <select name="vendor_id" class="form-control">
                                            <option value="">Select Vendor</option>
                                            @foreach ($OfferCategories as $OfferCategory)
                                                <option value="{{ $OfferCategory->id }}">{{ $OfferCategory->name_en . " - " . $OfferCategory->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (ar)</label>
                                            <input type="text" name="title[ar]" value='{{old('title.ar')}}' class="form-control" placeholder="Enter title ar" />
                                            @if ($errors->has('name_ar'))
                                                <span class="text-danger">{{ $errors->first('title.ar') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">title (en)</label>
                                            <input type="text" name="title[en]" value='{{old('title.en')}}' class="form-control" placeholder="Enter title en" />
                                            @if ($errors->has('title.en'))
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
                                        
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">description (en)</label>
                                            <textarea name="description[en]" class="form-control" id="" cols="30" rows="2">{{old('description.en')}}</textarea>
                                            @if ($errors->has('description.en'))
                                                <span class="text-danger">{{ $errors->first('description.en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">description (ar)</label>
                                            <textarea name="description[ar]" class="form-control" id="" cols="30" rows="2">{{old('description.ar')}}</textarea>
                                            @if ($errors->has('description.ar'))
                                                <span class="text-danger">{{ $errors->first('description.ar') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">price before </label>
                                            <input type="number" value='{{old('price_before')}}' name="price_before" class="form-control" placeholder="Enter price before" />
                                            @if ($errors->has('price_before'))
                                                <span class="text-danger">{{ $errors->first('price_before') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">price after</label>
                                            <input type="number" value='{{old('price_after')}}' name="price_after" class="form-control" placeholder="Enter price after" />
                                            @if ($errors->has('price_after'))
                                                <span class="text-danger">{{ $errors->first('price_after') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">expiration date </label>
                                            <input type="date" {{old('expiration_date')}} name="expiration_date" class="form-control" placeholder="Enter expiration date" />
                                            @if ($errors->has('expiration_date'))
                                                <span class="text-danger">{{ $errors->first('expiration_date') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">order Telephone number</label>
                                            <input type="text" {{old('order_tel_number')}} name="order_tel_number" class="form-control" placeholder="Enter Telephone" />
                                            @if ($errors->has('order_tel_number'))
                                                <span class="text-danger">{{ $errors->first('order_tel_number') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">discount_percentage</label>
                                            <input type="number" {{old('discount_percentage')}}" name="discount_percentage" class="form-control" placeholder="Enter discount percentage " />
                                            @if ($errors->has('discount_percentage'))
                                                <span class="text-danger">{{ $errors->first('discount_percentage') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">URL</label>
                                            <input type="url" value="{{old('url')}}" name="url" class="form-control" placeholder="Enter location url  " />
                                            @if ($errors->has('url'))
                                                <span class="text-danger">{{ $errors->first('url') }}</span>
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
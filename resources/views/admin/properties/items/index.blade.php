@extends("layouts.admin")
@section("page_title", "compounds")
@section("content")

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    View all compounds
                                    <a class="btn btn-info btn-sm text-right" href="{{ route('properties.items.create', $property_id) }}">+ Add New</a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name (en)</th>
                                            <th>Name (ar)</th>
                                            <th>Count</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($property_items as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ json_decode($item->name, true)['en'] }}</td>
                                                <td>{{ json_decode($item->name, true)['ar'] }}</td>
                                                <td>{{ $items_count[$item->id] }}</td>
                                                <td><a class="badge bg-danger" href="{{ route("properties.items.delete", [$property_id, $item->id]) }}">Delete</a></td>
                                            </tr>                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
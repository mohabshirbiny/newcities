@extends("layouts.admin")
@section("page_title", "events")
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
                                    <a class="btn btn-info btn-sm text-right" href="{{ route('events.gallery.create', $event_id) }}">+ Add New</a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>File</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1; @endphp
                                        @foreach ($gallery_decoded as $type => $record_arr)
                                            @if ($type != 'video')
                                                @foreach ($record_arr as $record)
                                                    <tr>
                                                        <td>{{ $counter }}</td>
                                                        <td>{{ $type }}</td>
                                                        <td>
                                                            @if ($type == "image")
                                                                <img style="width: 50px;" src="{{ url('images/event_files/' . $record) }}" alt="">
                                                            @else
                                                                {{ $record }}                                                            
                                                            @endif
                                                        </td>
                                                        <td><a class="badge bg-danger" href="{{ route("events.gallery.delete", [$event_id, $record]) }}">Delete</a></td>
                                                    </tr>
                                                    @php $counter++; @endphp
                                                @endforeach
                                            @else
                                            
                                                @foreach ($record_arr as $record)
                                                    <tr>
                                                        <td>{{ $counter }}</td>
                                                        <td>{{ $type }}</td>
                                                        <td>
                                                            {{ $record['video'] }}                                                            
                                                        </td>
                                                        <td><a class="badge bg-danger" href="{{ route("events.gallery.delete", [$event_id, $record['video']]) }}">Delete</a></td>
                                                    </tr>
                                                    @php $counter++; @endphp
                                                @endforeach
                                            @endif
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
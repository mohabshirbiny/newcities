@extends("layouts.admin")
@section("page_title", "Jobs")
@section("content")

    <div class="content-wrapper">
        @include('layouts.alerts')
        
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
                                    View all jobs
                                    <a class="btn btn-info btn-sm text-right" href="{{ route('jobs.create') }}">+ Add New</a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Post Title (en)</th>
                                            <th>Post Title (ar)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
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

@section("js")
<script>
$(function() {
    $('#example2').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('jobs.index') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'post_title_en', name: 'post_title' },
            { data: 'post_title_ar', name: 'post_title' },
            { data: 'actions', name: 'actions' },
        ]
    });
});
</script>

@endsection
@extends('layouts.app')

@section('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/vendor/ubold/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Danh sách cửa hàng</h4>
            <ol class="breadcrumb">
                <li class="active">
                    Danh sách cửa hàng
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" id="search-form">
                            <div class="form-group m-l-10">
                                <label class="sr-only" for="">ID cửa hàng</label>
                                <input type="text" class="form-control" placeholder="ID cửa hàng" name="id"/>
                            </div>
                            <div class="form-group m-l-10">
                                <label class="sr-only" for="">Tên cửa hàng</label>
                                <input type="text" class="form-control" placeholder="Tên cửa hàng" name="name"/>
                            </div>
                            <div class="form-group m-l-10">
                                <label class="sr-only" for="">Số điện thoại</label>
                                <input type="text" class="form-control" placeholder="Số điện thoại" name="phone_number"/>
                            </div>
                            <div class="form-group m-l-10">
                                <label class="sr-only" for="">Loại cửa hàng</label>
                                {!! Form::select('type', ['' => '--- Chọn loại cửa hàng ---'] + config('system.stores.type_name'), null, ['class' => 'form-control']) !!}
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-15">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách cửa hàng</b></h4>
                <p class="text-muted font-13 m-b-30"></p>
                <table id="dataTables-stores" class="table table-striped table-bordered table-actions-bar">
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="20%">Tên cửa hàng</th>
                        <th width="15%">Loại cửa hàng</th>
                        <th width="25%">Địa chỉ</th>
                        <th width="13%">Số điện thoại</th>
                        <th width="12%">Ngày tạo</th>
                        <th width="5%"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/jszip.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.colVis.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

    <script src="/vendor/ubold/assets/pages/datatables.init.js"></script>
    <script src="/js/handlebars.js"></script>
    <script src="/vendor/ubold/assets/plugins/select2/js/select2.full.min.js"></script>

    <script src="/vendor/ubold/assets/plugins/moment/moment.js"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
@endsection

@section('inline_scripts')
    <script type="text/javascript">
        $(function () {
            var datatable = $("#dataTables-stores").DataTable({
                searching: false,
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{!! route('stores.datatables') !!}',
                    data: function (d) {
                        d.id = $('input[name=id]').val();
                        d.name = $('input[name=name]').val();
                        d.type = $('select[name=type]').val();
                        d.phone_number = $('input[name=phone_number]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    {data: 'address', name: 'address'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[5, 'asc']]
            });

            $('#search-form').on('submit', function(e) {
                datatable.draw();
                e.preventDefault();
            });
        });
    </script>
@endsection
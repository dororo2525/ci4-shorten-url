<?= $this->extend('layouts/app') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content-header') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">MANAGE URL</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">dashboard</li>
                    <li class="breadcrumb-item active">manage url</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?php
                if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php elseif (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Origin Url</th>
                            <th>Shorten Url</th>
                            <th>Code</th>
                            <th>Clicks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($urls as $url) : ?>
                            <tr>
                                <td><a href="<?= $url['url'] ?>"><?= $url['url'] ?></a></td>
                                <td><a href="<?= $url['short_url'] ?>"><?= $url['short_url'] ?></a></td>
                                <td><?= $url['code'] ?></td>
                                <td><?= $url['clicks'] ?></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch custom-switch-md">
                                        <input type="checkbox" class="custom-control-input switch-status" id="customSwitch<?= $url['id'] ?>" data-code="<?= $url['code'] ?>" <?= $url['status'] == 1 ? 'checked' : null ?>>
                                        <label class="custom-control-label" for="customSwitch<?= $url['id'] ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Dropdown menu items -->
                                            <a class="dropdown-item" href="<?= route_to('App\Controllers\Backend\ManageUrlController::edit', $url['code']) ?>">Edit</a>
                                            <a class="dropdown-item btn-delete" data-code="<?= $url['code'] ?>" href="javascript:void(0)">Delete</a>
                                            <a class="dropdown-item btn-save-qr" data-link="<?= $url['short_url'] ?>" data-code="<?= $url['code'] ?>" href="javascript:void(0)">Download qr code</a>
                                            <a class="dropdown-item" href="<?= base_url('report/'. $url['code']) ?>">Report</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Origin Url</th>
                            <th>Shorten Url</th>
                            <th>Code</th>
                            <th>Clicks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Shorten Url</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-url" action="<?= route_to('manage-url') ?>" method="POST">
                    <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [{
                    text: '<i class="fas fa-plus-circle"></i>',
                    attr: {
                        class: 'btn btn-light',
                        'data-toggle': "modal",
                        'data-target': "#modal-default"
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-eye"></i>',
                    attr: {
                        class: 'btn btn-light'
                    }
                },
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('.btn-save').on('click', function() {
            $('#form-url').submit();
        });

        $('#modal-default').on('shown.bs.modal', function() {
            $('#url').trigger('focus')
        });

        $('#modal-default').on('hidden.bs.modal', function() {
            $('#url').val('')
        });

        $('.btn-delete').click(function() {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    var code = $(this).data('code');
                    $.ajax({
                        url: "<?= route_to('App\Controllers\Backend\ManageUrlController::delete' , '') ?>" + code,
                        type: "POST",
                        data: {
                            code: code,
                            _method: "DELETE",
                            _token: "<?= csrf_hash() ?>"
                        },
                        dataType: "JSON",
                        success: function(response) {
                            console.log(response);
                            if (response.status == true) {
                                toastr.options = {
                                    "progressBar": true,
                                    "timeOut": "1500",
                                }
                                toastr.success(response.msg);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                toastr.options = {
                                    "progressBar": true,
                                    "timeOut": "1500",
                                }
                                toastr.error(response.msg);
                            }
                        },
                    });
                }
            })
        });

        $('.switch-status').click(function() {
            var code = $(this).data('code');
            var status = Number($(this).is(':checked'));
            $.ajax({
                url: "<?= route_to('App\Controllers\Backend\ManageUrlController::switchStatus') ?>",
                type: "POST",
                data: {
                    code: code,
                    status: status,
                    _token: "<?= csrf_hash() ?>"
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.status == true) {
                        toastr.options = {
                            "progressBar": true,
                            "timeOut": "1500",
                        }
                        toastr.success(response.msg);

                    } else {
                        toastr.options = {
                            "progressBar": true,
                            "timeOut": "1500",
                        }
                        toastr.error(response.msg);
                    }
                },
            });
            $(this).blur();
        });

        $('.btn-save-qr').click(function(){
            var link = $(this).data('link');
            var code = $(this).data('code');
            var canvas = document.createElement("canvas");
            canvas.width = 800;
            canvas.height = 800;

            var qr = new QRCode( canvas, {
                text: link,
                width: 800,
                height: 800,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            var canvasDraw = qr._oDrawing._elCanvas;

            var dataURL = canvasDraw.toDataURL("image/png");
            var link = document.createElement('a');
            link.download = code + '.png';
            link.href = dataURL;
            link.click();
        })
    });
</script>
<?= $this->endSection() ?>
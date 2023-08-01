<?= $this->extend('layouts/app'); ?>

<?= $this->section('css') ?>

<?= $this->endSection() ?>

<?= $this->section('content-header') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit URL</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= route_to('App\Controllers\Backend\ManageUrlController::index') ?>">dashboard</a></li>
                    <li class="breadcrumb-item active">edit url</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <?php
                use App\Controllers\Backend\ManageUrlController;
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

                    <form action="<?= route_to('App\Controllers\Backend\ManageUrlController::update' , $url['code']) ?>" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                        <div class="row mb-3">
                          <label for="url" class="col-lg-2 offset-lg-2 col-form-label">Origin Url</label>
                          <div class="col-lg-4">
                            <input type="text" class="form-control" id="url" name="url" value="<?= old('url',$url['url']) ?>">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="shorten_url" class="col-lg-2 offset-lg-2 col-form-label">Shorten Url</label>
                          <div class="col-lg-4">
                            <input type="text" class="form-control" id="short_url" name="short_url" value="<?= old('short_url',$url['short_url']) ?>" disabled>
                          </div>
                        </div>
                        <div class="row mb-3">
                            <label for="code" class="col-lg-2 offset-lg-2 col-form-label">Code</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="code" name="code" value="<?= old('code',$url['code']) ?>" disabled>
                            </div>
                          </div>
                        <div class="row mb-3">
                        <label for="code" class="col-lg-2 offset-lg-2 col-form-label">Status</label>
                          <div class="col-lg-4">
                          <div class="custom-control custom-switch custom-switch-md">
                                        <input type="checkbox" class="custom-control-input switch-status align-middle" id="customSwitch" name="status" <?= $url['status'] == 1 ? 'checked' : null ?>>
                                        <label class="custom-control-label" for="customSwitch"></label>
                                    </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-6 offset-lg-2">
                                <button type="submit" class="btn btn-primary btn-block" type="button">Save</button>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>

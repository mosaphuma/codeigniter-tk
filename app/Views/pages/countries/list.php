<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Country</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Countryctl/country_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Country</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("Countryctl/countrys") ?>" method="GET">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="Search country 's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
                    <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                </div>
                </form>
            </div>
        </div>

    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="20%">
                    <col width="50%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Code</th>
                    <th class="p-1 text-center">Name</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($countrys as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['code'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['name'] ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Countryctl/country_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('Countryctl/country_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['code'] ?> - <?= $row['name'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($countrys) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="4">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>


<h3>Upload Excel File</h3>
        <?php if (session()->getFlashdata('error')) : ?>
            <p style="color: red;"><?= session()->getFlashdata('error'); ?></p>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <p style="color: green;"><?= session()->getFlashdata('success'); ?></p>
        <?php endif; ?>
        <form action="<?= base_url("Main/upload") ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit">Upload</button>
        </form>

<?= $this->endSection() ?>




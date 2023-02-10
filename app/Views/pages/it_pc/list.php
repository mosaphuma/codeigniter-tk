<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">LIST OF PC </div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('IT_pcctl/pc_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add PC</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("IT_pcctl/it_pcf") ?>" method="GET">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="Search PC 's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
                    <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                </div>
                </form>
            </div>
        </div>

    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="5%">
                    <col width="40%">
                    <col width="40%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">ISSUECODE</th>
                    <th class="p-1 text-center">PCCODE</th>
                    <th class="p-1 text-center">PCIP</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($it_pcf as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['ID'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUECODE'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['PCCODE'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['PCIP'] ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('IT_pcctl/pc_edit/'.$row['ID']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('IT_pcctl/pc_delete/'.$row['ID']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['PCCODE'] ?> - <?= $row['PCIP'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($it_pcf) <= 0): ?>
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



<?= $this->endSection() ?>




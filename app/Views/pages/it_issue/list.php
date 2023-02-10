<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">LIST OF ISSUECODE</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('IT_issuectl/issue_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Issue</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("IT_issuectl/it_issuef") ?>" method="GET">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="Search Issue 's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
                    <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                </div>
                </form>
            </div>
        </div>

    <div class="card-body">
        <div class="container-fluid">
        
        
                <?php if($session->getFlashdata('error')): ?>
                    <div class="alert alert-danger rounded-0">
                        <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($session->getFlashdata('success')): ?>
                    <div class="alert alert-success rounded-0">
                        <?= $session->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                
        </div>
    </div>


            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="20%">
                    <col width="50%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">ISSUECODE</th>
                    <th class="p-1 text-center">ISSUEDESC</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($it_issuef as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['ID'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUECODE'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEDESC'] ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('IT_issuectl/issue_edit/'.$row['ID']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('IT_issuectl/issue_delete/'.$row['ID']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['ISSUECODE'] ?> - <?= $row['ISSUEDESC'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($it_issuef) <= 0): ?>
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




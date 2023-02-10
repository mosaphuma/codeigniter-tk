<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">LIST OF ISSUEDETAIL</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('IT_issuedetailctl/issued_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Issue Detail </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("IT_issuedetailctl/it_issuedf") ?>" method="GET">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="Search Issue 's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
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
                    <col width="10%">
                    <col width="30%">
                    <col width="5%">
                    <col width="5%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">CODE</th>
                    <th class="p-1 text-center">ISSUEDATE</th>
                    <th class="p-1 text-center">ISSUEDETAIL</th>
                    <th class="p-1 text-center">ISSUEFOR</th>
                    <th class="p-1 text-center">ISSUEWHERE</th>
                    <th class="p-1 text-center">ISSUEHOW</th>
                    <th class="p-1 text-center">ENDATE</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach($it_issuedf as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['ID'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUECODE'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEDATE'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEDETAIL'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEFOR'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEWHERE'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEHOW'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['ISSUEENDATE'] ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('IT_issuedetailctl/issued_edit/'.$row['ID']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('IT_issuedetailctl/issued_delete/'.$row['ID']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['ISSUECODE'] ?> - <?= $row['ISSUEDETAIL'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($it_issuedf) <= 0): ?>
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




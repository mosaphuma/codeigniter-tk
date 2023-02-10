<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New CODE</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('I_codectl/i_codef') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('I_codectl/icode_add') ?>" method="POST">
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
                <div class="mb-3">
                    <label for="code" class="control-label">ICode</label>
                    <input type="text" class="form-control rounded-0" id="code" name="code" autofocus placeholder="ITD" value="<?= !empty($request->getPost('ICODE')) ? $request->getPost('ICODE') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">ICODEDESC</label>
                    <input type="text" class="form-control rounded-0" id="name" name="name"  placeholder="ITD" value="<?= !empty($request->getPost('IDESC')) ? $request->getPost('IDESC') : '' ?>" required="required">
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
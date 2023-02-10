<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New PC</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('IT_pcctl/it_pcf') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('IT_pcctl/pc_add') ?>" method="POST">
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
                            <label for="department_id" class="control-label">ISSUECODE</label>
                            <select class="form-select rounded-0" id="issuecode" name="issuecode" value="<?= !empty($request->getPost('ISSUECODE')) ? $request->getPost('ISSUEDCODE') : '' ?>" required="required">
                                <option value="" disabled selected></option>
                                <?php foreach($it_issuef as $row): ?>
                                <option value="<?= $row['ISSUECODE'] ?>" <?= !empty($request->getPost('ISSUECODE')) && $request->getPost('ISSUECODE') == $row['ISSUECODE'] ? 'selected' : '' ?>><?= $row['ISSUEDESC'] ?></option>
                                <?php endforeach; ?>
                            </select>
                </div>
                <div class="mb-3">
                    <label for="code" class="control-label">PC CODE</label>
                    <input type="text" class="form-control rounded-0" id="code" name="code" autofocus placeholder="PC CODE" value="<?= !empty($request->getPost('PCCODE')) ? $request->getPost('PCCODE') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">PC IP</label>
                    <input type="text" class="form-control rounded-0" id="name" name="name"  placeholder="IP" value="<?= !empty($request->getPost('PCIP')) ? $request->getPost('PCIP') : '' ?>" required="required">
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('custom_js') ?>
<script>
    $(function(){
        $('#ISSUECODE').select2({
            placeholder:"Please Select Here",
            width:'100%',
            selectionCssClass:'form-control'
        })
    })
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New ISSUE Detail</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('IT_issuedetailctl/it_issuedf') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('IT_issuedetailctl/issued_add') ?>" method="POST">
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
                            <select class="form-select rounded-0" id="code" name="code" value="<?= !empty($request->getPost('ISSUECODE')) ? $request->getPost('ISSUEDCODE') : '' ?>" required="required">
                                <option value="" disabled selected></option>
                                <?php foreach($it_issuef as $row): ?>
                                <option value="<?= $row['ISSUECODE'] ?>" <?= !empty($request->getPost('ISSUECODE')) && $request->getPost('ISSUECODE') == $row['ISSUECODE'] ? 'selected' : '' ?>><?= $row['ISSUEDESC'] ?></option>
                                <?php endforeach; ?>
                            </select>
                </div>
                <!--
                <div class="mb-3">
                    <label for="code" class="control-label">Code</label>
                    <input type="text" class="form-control rounded-0" id="code" name="code" autofocus placeholder="issued" value="<?= !empty($request->getPost('ISSUECODE')) ? $request->getPost('ISSUECODE') : '' ?>" required="required">
                </div>
                                -->
                <div class="mb-3">
                    <label for="issuedate" class="control-label">ISSUEDATE</label>
                    <input type="date" class="form-control rounded-0" id="issuedate" name="issuedate"value="<?= !empty($request->getPost('ISSUEDATE')) ? $request->getPost('ISSUEDATE') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">ISSUEDETAIL</label>
                    <input type="text" class="form-control rounded-0" id="issuedetail" name="issuedetail"  placeholder="Detail" value="<?= !empty($request->getPost('ISSUEDETAIL')) ? $request->getPost('ISSUEDETAIL') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">ISSUEFOR</label>
                    <input type="text" class="form-control rounded-0" id="issuefor" name="issuefor"  placeholder="FOR" value="<?= !empty($request->getPost('ISSUEFOR')) ? $request->getPost('ISSUEFOR') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">ISSUEWHERE</label>
                    <input type="text" class="form-control rounded-0" id="issuewhere" name="issuewhere"  placeholder="FOR" value="<?= !empty($request->getPost('ISSUEWHERE')) ? $request->getPost('ISSUEWHERE') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">ISSUEHOW</label>
                    <input type="text" class="form-control rounded-0" id="issuehow" name="issuehow"  placeholder="FOR" value="<?= !empty($request->getPost('ISSUEHOW')) ? $request->getPost('ISSUEHOW') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">ISSUENDATE</label>
                    <input type="date" class="form-control rounded-0" id="issueendate" name="issueendate"value="<?= !empty($request->getPost('ISSUEENDATE')) ? $request->getPost('ISSUEENDATE') : '' ?>" required="required">                </div>
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
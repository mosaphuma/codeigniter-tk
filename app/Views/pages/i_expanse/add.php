<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New Expanse Detail</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('I_expansectl/i_expansef') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('I_expansectl/expanse_add') ?>" method="POST">
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
                            <label for="department_id" class="control-label">ICODE</label>
                            <select class="form-select rounded-0" id="code" name="code" value="<?= !empty($request->getPost('ICODE')) ? $request->getPost('IDCODE') : '' ?>" required="required">
                                <option value="" disabled selected></option>
                                <?php foreach($i_codef as $row): ?>
                                <option value="<?= $row['ICODE'] ?>" <?= !empty($request->getPost('ICODE')) && $request->getPost('ICODE') == $row['ICODE'] ? 'selected' : '' ?>><?= $row['IDESC'] ?></option>
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
                    <label for="issuedate" class="control-label">BUYDATE</label>
                    <input type="date" class="form-control rounded-0" id="issuedate" name="issuedate"value="<?= !empty($request->getPost('BUYDATE')) ? $request->getPost('BUYDATE') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">BUYDETAIL</label>
                    <input type="text" class="form-control rounded-0" id="issuedetail" name="issuedetail"  placeholder="Detail" value="<?= !empty($request->getPost('BUYDETAIL')) ? $request->getPost('BUYDETAIL') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">QTY</label>
                    <input type="text" class="form-control rounded-0" id="issuefor" name="issuefor"  placeholder="FOR" value="<?= !empty($request->getPost('QTY')) ? $request->getPost('QTY') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">PRICERL</label>
                    <input type="text" class="form-control rounded-0" id="issuewhere" name="issuewhere"  placeholder="FOR" value="<?= !empty($request->getPost('PRICERL')) ? $request->getPost('PRICERL') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">PRiCEUSD</label>
                    <input type="text" class="form-control rounded-0" id="issuehow" name="issuehow"  placeholder="FOR" value="<?= !empty($request->getPost('PRICEUSD')) ? $request->getPost('PRICEUSD') : '' ?>" required="required">
                </div>
                
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
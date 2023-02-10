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
            <form action="<?= base_url('I_expansectl/expansedatereport') ?>" method="GET">
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
                    <label for="issuedate" class="control-label">FROMDATE</label>
                    <input type="date" class="form-control rounded-0" id="fdate" name="fdate"value="<?= !empty($request->getPost('BUYDATE')) ? $request->getPost('BUYDATE') : '' ?>" required="required">
                </div>
               <div class="mb-3">
                    <label for="issuedate" class="control-label">TODATE</label>
                    <input type="date" class="form-control rounded-0" id="tdate" name="tdate"value="<?= !empty($request->getPost('BUYDATE')) ? $request->getPost('BUYDATE') : '' ?>" required="required">
                </div>
                
                    <button class="btn rounded-0 btn-primary bg-gradient" id="submit" value="submit">Submit</button>
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
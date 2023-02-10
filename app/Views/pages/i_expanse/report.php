<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Report</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('I_expansectl/expanse_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Expanse Detail </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("I_expansectl/i_expanseR") ?>" method="GET">
                <div class="input-group">
                <!--    
                <input type="search" id="search" name="search" placeholder="Search Issue 's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
                    <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>

                -->
                </div>
                </form>
            </div>
        </div>

    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="30%">
                    <col width="30%">
                   
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">CODE</th>
                    <th class="p-1 text-center">RIEL</th>
                    <th class="p-1 text-center">USD</th>
                   
                </thead>
                <tbody>
                    <?php 
                    
                 //   foreach($i_expanseR as $row): ?>
                        <tr>
                            <td class="px-2 py-1 align-middle"><?= 1?></td>
                            <td class="px-2 py-1 align-middle"><?= 'FOOD'  ?></td>
                            <td class="px-2 py-1 align-middle"><?= number_format($sumprice) ?></td>
                            <td class="px-2 py-1 align-middle"><?= number_format($sumpriceusd) ?></td>
                          
                            
                        </tr>
                        
                        <tr>
                            <td class="px-2 py-1 align-middle"><?= 2?></td>
                            <td class="px-2 py-1 align-middle"><?= 'HAIR'  ?></td>
                            <td class="px-2 py-1 align-middle"><?= number_format($sumhair) ?></td>
                            <td class="px-2 py-1 align-middle"><?= number_format($sumhairusd) ?></td>
                          
                            
                        </tr>
                   <?php //endforeach; ?>
                    <?php //if(count($i_expanseR) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="4">Report Expanse</td>
                        </tr>
                    <?php //endif ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>




<?= $this->endSection() ?>




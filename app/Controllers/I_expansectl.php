<?php

namespace App\Controllers;
use App\Models\I_expanse;
use App\Models\I_code;
class I_expansectl extends BaseController
{
    // it_issue
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->it_issued_model = new I_expanse;
        $this->it_issue_model = new I_code;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    
    
    public function i_expansef(){
        $this->data['sumprice']=$this->it_issued_model->sumprice();
       

        $this->data['page_title']="IT_ISSUE";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        if(!empty($this->request->getVar('search'))){
            $search = strtolower($this->request->getVar('search'));
            $this->it_issued_model->where("lower(i_expanse.`ICODE`) like '%{$search}%' or lower(i_expanse.`BUYDATE`) like '%{$search}%' or lower(i_expanse.`BUYDETAIL`) like '%{$search}%'");
        }
        $this->data['total'] =  $this->it_issued_model->countAllResults();
        if(!empty($this->request->getVar('search'))){
            $search = strtolower($this->request->getVar('search'));
            $this->it_issued_model->where("lower(i_expanse.`ICODE`) like '%{$search}%' or lower(i_expanse.`BUYDATE`) like '%{$search}%'or lower(i_expanse.`BUYDETAIL`) like '%{$search}%'");
        }
        $this->data['i_expansef'] = $this->it_issued_model
                                    ->select("i_expanse.*,i_expanse.BUYDETAIL")
                                    ->join('i_code'," i_code.ICODE = i_expanse.ICODE ",'inner')
                                    ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['i_expansef'])? count($this->data['i_expansef']) : 0;
        $this->data['pager'] = $this->it_issued_model->pager;
        return view('pages/i_expanse/list', $this->data);
    }

    public function expanse_add(){
        $this->data['i_codef'] = $this->it_issue_model->findAll();
        //$this->data['designations'] = $this->desg_model->findAll();
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['ICODE'] = $code;
            $udata['BUYDATE'] = $issuedate;
            $udata['BUYDETAIL'] = $issuedetail;
            $udata['QTY'] = $issuefor;
            $udata['PRICERL'] = $issuewhere;
            $udata['PRICEUSD'] = $issuehow;
            
            $checkCode = $this->it_issued_model->where('ICODE',$code)->countAllResults();
            if (!is_numeric($issuewhere)) {
                session()->setFlashdata('error', 'PriceR field should contain only numbers.');
                //return redirect()->to(base_url('your_form_url'));
                return redirect()->to('I_expansectl/expanse_add/');
              }

              if(!is_numeric($issuehow)){
                session()->setFlashdata('error','PriceUsd should contain only numbers');
                return redirect()->to('I_expansectl/expanse_add/');
              }
            //if($checkCode){
            //    $this->session->setFlashdata('error',"ISSUED Code Already Taken.");
           else{
                $save = $this->it_issued_model->save($udata);
                if($save){
                    $id = $this->it_issued_model->insertID();
                    $this->session->setFlashdata('main_success',"BUY Details has been updated successfully.");
                    return redirect()->to('/I_expansectl/i_expansef');
                }else{
                    $this->session->setFlashdata('error',"ISSUE Details has failed to ADD.");
                }
            }
        
        }

        $this->data['page_title']="Add New BUY";
        return view('pages/i_expanse/add', $this->data);
    }


public function expanse_edit($id=''){
    $this->data['i_codef'] = $this->it_issue_model->findAll();  //pass funtion it_issuef to edit pages
    if(empty($id))
    return redirect()->to('I_expansectl/i_expansef');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['ICODE'] = $code;  //this is the id of select
        $udata['BUYDATE'] = $issuedate;
        $udata['BUYDETAIL'] = $name;
        $udata['QTY'] = $issuefor;
        $udata['PRICERL'] = $issuewhere;
        $udata['PRICEUSD'] = $issuehow;
        //$udata['ISSUEENDATE'] = $issueendate;

        $checkCode = $this->it_issued_model->where('ICODE',$code)->where("ID!= '{$id}'")->countAllResults();
        //if($checkCode){
        //    $this->session->setFlashdata('error',"country Code Already Taken.");
        //}else{

            if (!is_numeric($issuewhere)) {
                session()->setFlashdata('error', 'PriceR field should contain only numbers.');
                //return redirect()->to(base_url('your_form_url'));
                return redirect()->to('I_expansectl/expanse_edit/'.$id);
              }

              if(!is_numeric($issuehow)){
                session()->setFlashdata('error','PriceUSD should contain only numbers');
              }
              else{   
            $update = $this->it_issued_model->where('ID',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"BUY Details has been updated successfully.");
                return redirect()->to('I_expansectl/expanse_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"BUY Details has failed to update.");
            }
        }
    }


    $this->data['page_title']="Edit Country";
    $this->data['countrys1'] = $this->it_issued_model->where("ID ='{$id}'")->first();
    return view('pages/i_expanse/edit', $this->data);
}

public function expanse_delete($id=''){
    if(empty($id)){
            $this->session->setFlashdata('main_error',"BuyItem Deletion failed due to unknown ID.");
            return redirect()->to('I_expansectl/i_expansef');
    }
    $delete = $this->it_issued_model->where('ID', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"Buy item  has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"buy item  Deletion failed due to unknown ID.");
    }
    return redirect()->to('I_expansectl/i_expansef');
}


public function expanse_view($id=''){
    if(empty($id)){
        $this->session->setFlashdata('main_error',"Employee ID is unknown.");
        return redirect()->to('I_expansectl/expanse_view');
    }
    $this->data['page_title']="Employee Details";
    $this->data['details'] = $this->it_issued_model
                                ->select("i_expanse.*")
                                //->join('departments'," employees.department_id = departments.id ",'inner')
                                //->join('designations'," employees.designation_id = designations.id ",'inner')
                                ->where("i_expanse.ID = $id")->first();
    return view('pages/i_expanse/view', $this->data);
    
}

public function i_expanseR(){
    $this->data['sumprice']=$this->it_issued_model->sumprice();
    $this->data['sumhair']=$this->it_issued_model->sumhair();
    $this->data['sumpriceusd']=$this->it_issued_model->sumpriceusd();
    $this->data['sumhairusd']=$this->it_issued_model->sumhairusd();



    $this->data['page_title']="IT_ISSUE";
    $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    $this->data['perPage'] =  10;
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issued_model->where("lower(i_expanse.`ICODE`) like '%{$search}%' or lower(i_expanse.`BUYDATE`) like '%{$search}%' or lower(i_expanse.`BUYDETAIL`) like '%{$search}%'");
    }
    $this->data['total'] =  $this->it_issued_model->countAllResults();
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issued_model->where("lower(i_expanse.`ICODE`) like '%{$search}%' or lower(i_expanse.`BUYDATE`) like '%{$search}%'or lower(i_expanse.`BUYDETAIL`) like '%{$search}%'");
    }
    $this->data['i_expanseR'] = $this->it_issued_model
                                ->select("i_expanse.*,i_expanse.BUYDETAIL")
                                ->join('i_code'," i_code.ICODE = i_expanse.ICODE ",'inner');
                               // ->paginate($this->data['perPage']);
    $this->data['total_res'] = is_array($this->data['i_expanseR'])? count($this->data['i_expanseR']) : 0;
    $this->data['pager'] = $this->it_issued_model->pager;
    return view('pages/i_expanse/report', $this->data);
}




public function expansedatereport(){
    $this->data['sumprice']=$this->it_issued_model->sumprice();
    $this->data['sumhair']=$this->it_issued_model->sumhair();
    $this->data['sumpriceusd']=$this->it_issued_model->sumpriceusd();
    $this->data['sumhairusd']=$this->it_issued_model->sumhairusd();
    $this->data['total']=$this->it_issued_model->datewisereport();



    //$this->data['page_title']="IT_ISSUE";
    //$this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    //$this->data['perPage'] =  10;
    /*
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issued_model->where("lower(i_expanse.`ICODE`) like '%{$search}%' or lower(i_expanse.`BUYDATE`) like '%{$search}%' or lower(i_expanse.`BUYDETAIL`) like '%{$search}%'");
    }
    $this->data['total'] =  $this->it_issued_model->countAllResults();
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->it_issued_model->where("lower(i_expanse.`ICODE`) like '%{$search}%' or lower(i_expanse.`BUYDATE`) like '%{$search}%'or lower(i_expanse.`BUYDETAIL`) like '%{$search}%'");
    }
    */
   // $this->data['expansedatereport'] = $this->it_issued_model
    //                            ->select("i_expanse.*,i_expanse.BUYDETAIL")
    //                            ->join('i_code'," i_code.ICODE = i_expanse.ICODE ",'inner');
                               // ->paginate($this->data['perPage']);
   // $this->data['total_res'] = is_array($this->data['expansedatereport'])? count($this->data['expansedatereport']) : 0;
    //$this->data['pager'] = $this->it_issued_model->pager;
    //return view('pages/i_expanse/datereport', $this->data);

    if (isset($_GET['submit'])) {
        $fdate = $this->request->get('fdate');
        $tdate = $this->request->get('tdate');
        //$uid = $this->request->getPost('uid');
        
        $reportsModel = new I_expanse();
        $rdetails = $reportsModel->expansedatereport($fdate,$tdate);
        return view('pages/i_expanse/datereportdetail', $this->data);
        //return view('datereportdetail', [
          //  'reportdetails' => $rdetails,
          //  'fdate' => $fdate,
          //  'tdate' => $tdate
       // ]);
    } else {
        //return view('datereport');
        //$this->data['fdate'] = $this->$reportsModel->where("BUYDATE ='{$fdate}'")->first();
        //$this->data['tdate'] = $this->$reportsModel->where("BUYDATE ='{$tdate}'")->first();

        return view('pages/i_expanse/datereport', $this->data);
    }

}

/*
public function datewiserport(){
    //Form Validation
    $validation = \Config\Services::validation();
    $validation->setRules([
      'fromdate' => 'required',
      'todate' => 'required'
    ]);
  
    if ($validation->run()) {
      $fdate = $this->request->getPost('fromdate');
      $tdate = $this->request->getPost('todate');
      //$uid = session()->get('uid');
  
      $model = new \App\Models\I_expanse();
      $rdetails = $model->datewisereport($fdate, $tdate);
  
      return view('datereportdetail', [
        'reportdetails' => $rdetails,
        'fromdate' => $fdate,
        'todate' => $tdate
      ]);
    } else {
      return view('datereport');
    }
  }
  
*/
}
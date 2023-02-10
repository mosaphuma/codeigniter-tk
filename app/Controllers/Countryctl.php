<?php

namespace App\Controllers;
use App\Models\Country;
class Countryctl extends BaseController
{
    // country
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->hr_country_model = new Country;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }


public function countrys(){
    $this->data['page_title']="countrys";
    $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    $this->data['perPage'] =  10;
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->hr_country_model->where("lower(hr_countries.`code`) like '%{$search}%' or lower(hr_countries.`name`) like '%{$search}%'");
    }
    $this->data['total'] =  $this->hr_country_model->countAllResults();
    if(!empty($this->request->getVar('search'))){
        $search = strtolower($this->request->getVar('search'));
        $this->hr_country_model->where("lower(hr_countries.`code`) like '%{$search}%' or lower(hr_countries.`name`) like '%{$search}%'");    
    }
    $this->data['countrys'] = $this->hr_country_model
                                ->select("hr_countries.*, hr_countries.code,hr_countries.name")
                               
                                ->paginate($this->data['perPage']);
    $this->data['total_res'] = is_array($this->data['countrys'])? count($this->data['countrys']) : 0;
    $this->data['pager'] = $this->hr_country_model->pager;
    return view('pages/countries/list', $this->data);
}


public function country_add(){
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['code'] = $code;
        $udata['name'] = $name;
        $checkCode = $this->hr_country_model->where('code',$code)->countAllResults();
        if($checkCode){
            $this->session->setFlashdata('error',"Country Code Already Taken.");
        }else{
            $save = $this->hr_country_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"country Details has been updated successfully.");
                return redirect()->to('Countryctl/countrys/');
            }else{
                $this->session->setFlashdata('error',"country Details has failed to update.");
            }
        }
    }

    $this->data['page_title']="Add New Country";
    return view('pages/countries/add', $this->data);
}
public function country_edit($id=''){
    if(empty($id))
    return redirect()->to('Countryctl/countrys');
    if($this->request->getMethod() == 'post'){
        extract($this->request->getPost());
        $udata= [];
        $udata['code'] = $code;
        $udata['name'] = $name;
        $checkCode = $this->hr_country_model->where('code',$code)->where("id!= '{$id}'")->countAllResults();
        if($checkCode){
            $this->session->setFlashdata('error',"country Code Already Taken.");
        }else{
            $update = $this->hr_country_model->where('id',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"Country Details has been updated successfully.");
                return redirect()->to('Countryctl/country_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"country Details has failed to update.");
            }
        }
    }

    $this->data['page_title']="Edit Country";
    $this->data['countrys1'] = $this->hr_country_model->where("id ='{$id}'")->first();
    return view('pages/countries/edit', $this->data);
}

public function country_delete($id=''){
    if(empty($id)){
            $this->session->setFlashdata('main_error',"Country Deletion failed due to unknown ID.");
            return redirect()->to('Countryctl/countrys');
    }
    $delete = $this->hr_country_model->where('id', $id)->delete();
    if($delete){
        $this->session->setFlashdata('main_success',"Country has been deleted successfully.");
    }else{
        $this->session->setFlashdata('main_error',"Countrys Deletion failed due to unknown ID.");
    }
    return redirect()->to('Countryctl/countrys');
}

}

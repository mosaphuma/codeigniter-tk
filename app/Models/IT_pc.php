<?php

namespace App\Models;

use CodeIgniter\Model;

class IT_pc extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'it_pc';
    protected $primaryKey       = 'ID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ISSUECODE','PCCODE', 'PCIP'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

  
    public function countAllpc()
    {
        return $this->where('ISSUECODE', 'PC')->countAllResults();
    }
  
    public function countAllcctv()
    {
        return $this->where('ISSUECODE', 'CCTV')->countAllResults();
    }
  
    public function countAllfp()
    {
        return $this->where('ISSUECODE', 'FP')->countAllResults();
    }

    

}

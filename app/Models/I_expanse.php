<?php

namespace App\Models;

use CodeIgniter\Model;

class I_expanse extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'i_expanse';
    protected $primaryKey       = 'ID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ICODE','BUYDATE','BUYDETAIL','QTY','PRICERL','PRICEUSD'];

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


    public function sumprice()
    {
        $db = \Config\Database::connect();
        $query = $db->table('i_expanse')
                    ->selectSum('PRICERL')
                    ->where('ICODE', 'FOOD')
                    ->get();

        return $query->getRow()->PRICERL;
    }

    public function sumpriceusd()
    {
        $db = \Config\Database::connect();
        $query = $db->table('i_expanse')
                    ->selectSum('PRICEUSD')
                    ->where('ICODE', 'FOOD')
                    ->get();

        return $query->getRow()->PRICEUSD;
    }
    
    public function sumhair()
    {
        $db = \Config\Database::connect();
        $query = $db->table('i_expanse')
                    ->selectSum('PRICERL')
                    ->where('ICODE', 'HAIR')
                    ->get();

        return $query->getRow()->PRICERL;
    }
    
    public function sumhairusd()
    {
        $db = \Config\Database::connect();
        $query = $db->table('i_expanse')
                    ->selectSum('PRICEUSD')
                    ->where('ICODE', 'HAIR')
                    ->get();

        return $query->getRow()->PRICEUSD;
    }

    public function datewisereport() {
        $db = \Config\Database::connect();
        $data = [
          'BUYDATE >= ' => 0,
          'BUYDATE <= ' => 0,
          //'UserId' => $uid
        ];
      
        $query = $this->db->table('i_expanse')
          ->select('BUYDATE, sum(PRICERL) as ExpenseCost')
          ->where($data)
          ->groupBy('BUYDATE')
          ->get();
      
        return $query->getResult();
      }
      
}

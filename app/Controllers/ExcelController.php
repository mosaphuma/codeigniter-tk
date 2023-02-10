<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use PHPExcel;
use PHPExcel_IOFactory;

class ExcelController extends BeseController
{
    public function index()
    {
        return view('excel_form');
    }

    public function upload()
    {
        $file = $this->request->getFile('file');
        $file_name = $file->getName();

        // Check if file is uploaded
        if (!$file->isValid()) {
            return redirect()->to('/excel')->with('error', 'File upload error');
        }

        // Check if file is an excel file
        if ($file->getExtension() != 'xlsx') {
            return redirect()->to('/excel')->with('error', 'File must be an Excel file');
        }

        // Read the data from the excel file
        $excel = PHPExcel_IOFactory::load($file->getTempName());
        $worksheet = $excel->getActiveSheet();
        $data = $worksheet->toArray();

        // Connect to the database
        $db = \Config\Database::connect();

        // Loop through the data and insert into the database table
        foreach ($data as $row) {
            $db->table('hr_countries')->insert($row);
        }

        return redirect()->to('/excel')->with('success', 'File uploaded and data inserted successfully');
    }
}

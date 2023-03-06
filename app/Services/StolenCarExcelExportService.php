<?php

namespace App\Services;

use App\Http\Requests\StolenCarRequest;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StolenCarExcelExportService
{
    /**
     * Create a new table and save it to the storage/app folder
     * and display the link to the user
     *
     * @param StolenCarRequest $request
     *
     * @return string
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Collection $stolenCars):string
    {
        $spreadsheet = new Spreadsheet();

        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->mergeCells("A1:G1");
        $worksheet->setCellValue("A1", 'Sorted stolen car');

        $header = ['Name', 'Number', 'Color', 'VIN', 'Make', 'Model', 'Model Year'];
        $columnIndex = 2;
        $letter = 'A';

        foreach ($header as $columnName) {
            $worksheet->setCellValue($letter++.$columnIndex, $columnName);
        }

        $highestRow = $worksheet->getHighestRow() + 1;

        foreach ($stolenCars as $stolenCar) {
            $worksheet->setCellValue('A'.$highestRow, "{$stolenCar['name']}");
            $worksheet->setCellValue('B'.$highestRow, "{$stolenCar['number']}");
            $worksheet->setCellValue('C'.$highestRow, "{$stolenCar['color']}");
            $worksheet->setCellValue('D'.$highestRow, "{$stolenCar['vin']}");
            $worksheet->setCellValue('E'.$highestRow, "{$stolenCar['make']}");
            $worksheet->setCellValue('F'.$highestRow, "{$stolenCar['model']}");
            $worksheet->setCellValue('G'.$highestRow, "{$stolenCar['model_year']}");

            $highestRow++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'stolen_cars_'.date('Ymd_His').'_'.rand().'.xlsx';
        $writer->save(storage_path('app/'.$filename));

        return asset('storage/app/'.$filename);
    }

}

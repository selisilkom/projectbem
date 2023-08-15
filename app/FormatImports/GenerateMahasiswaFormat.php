<?php

namespace App\FormatImports;

use App\Models\Organisasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class GenerateMahasiswaFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    public function view(): View
    {
        return view('admin.pages.mahasiswa.format');
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // kolom A Kelas
                $kolom_a = 'A';
                $kolomA = [];
                $arrKelas = Organisasi::get();
                foreach ($arrKelas as $kelas) {
                    array_push($kolomA, $kelas->nama_organisasi);
                }
                $validationA = $event->sheet->getCell("{$kolom_a}2")->getDataValidation();
                $validationA->setType(DataValidation::TYPE_LIST);
                $validationA->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationA->setAllowBlank(false);
                $validationA->setShowInputMessage(true);
                $validationA->setShowErrorMessage(true);
                $validationA->setShowDropDown(true);
                $validationA->setErrorTitle('Input error');
                $validationA->setError('Value is not in list.');
                $validationA->setPromptTitle('Pick from list');
                $validationA->setPrompt('Please pick a value from the drop-down list.');
                $validationA->setFormula1(sprintf('"%s"', implode(',', $kolomA)));

                // kolom E Gender
                $kolom_e = 'E';
                $kolomE = [
                    'Laki-laki',
                    'Perempuan',
                ];
                $validationE = $event->sheet->getCell("{$kolom_e}2")->getDataValidation();
                $validationE->setType(DataValidation::TYPE_LIST);
                $validationE->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationE->setAllowBlank(false);
                $validationE->setShowInputMessage(true);
                $validationE->setShowErrorMessage(true);
                $validationE->setShowDropDown(true);
                $validationE->setErrorTitle('Input error');
                $validationE->setError('Value is not in list.');
                $validationE->setPromptTitle('Pick from list');
                $validationE->setPrompt('Please pick a value from the drop-down list.');
                $validationE->setFormula1(sprintf('"%s"', implode(',', $kolomE)));

                for ($i = 3; $i <= 1000; $i++) {
                    $event->sheet->getCell("{$kolom_a}{$i}")->setDataValidation(clone $validationA);
                    $event->sheet->getCell("{$kolom_e}{$i}")->setDataValidation(clone $validationE);
                }
            },
        ];
    }
}

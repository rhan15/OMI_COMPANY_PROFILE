<?php

namespace App\Exports;

use App\Models\Register;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RegisterExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $from_date;
    protected $to_date;

    function __construct($from_date, $to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        return Register::get_registers_eksport($this->from_date, $this->to_date);
    }

    public function headings(): array
    {

        // if (true) {
        if ($this->from_date == null && $this->to_date == null) {
            return [
                [
                    'Periode: Semua',
                ],
                [
                    '#',
                    'Tanggal Daftar',
                    'User Identity',
                    'User Name',
                    'User Gender',
                    'User Email',
                    'User Phone Number',
                    'User Province',
                    'User City',
                    'User District',
                    'User Subdistrict',
                    'User Postal Code',
                    'User Address',
                    'Location Province',
                    'Location City',
                    'Location District',
                    'Location Subdistrict',
                    'Company Name',
                    'Company Address',
                    'Company Phone',
                    'Notes',
                ]
            ];
        } else {
            return [
                [
                    'Periode: '.$this->from_date->isoFormat('D MMMM YYYY').'-'.$this->to_date->isoFormat('D MMMM YYYY'),
                ],
                [
                    '#',
                    'Tanggal Daftar',
                    'User Identity',
                    'User Name',
                    'User Gender',
                    'User Email',
                    'User Phone Number',
                    'User Province',
                    'User City',
                    'User District',
                    'User Subdistrict',
                    'User Postal Code',
                    'User Address',
                    'Location Province',
                    'Location City',
                    'Location District',
                    'Location Subdistrict',
                    'Company Name',
                    'Company Address',
                    'Company Phone',
                    'Notes',
                ]
            ];
        }
    }

    public function registerEvents(): array
    {
        return [
            // // Handle by a closure.
            // BeforeExport::class => function(BeforeExport $event) {
            //     $event->writer->getProperties()->setCreator('omi-website');
            // },

            // // Array callable, refering to a static method.
            // BeforeWriting::class => [self::class, 'beforeWriting'],

            // // Using a class with an __invoke method.
            // BeforeSheet::class => new BeforeSheetHandler(),

            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate()->setMergeCells(['A1:C1']);

                $headers = $workSheet->getStyle('A2:U2');

                $headers
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $headers->getFont()->setBold(true);
            }
        ];
    }

    // public static function afterSheet(AfterSheet $event)
    // {
    //     try {
    //         $workSheet = $event
    //             ->sheet
    //             ->getDelegate()
    //             ->setMergeCells([
    //                 'B1:C1',
    //             ]);

    //             $headers = $workSheet->getStyle('A1:D2');

    //             $headers
    //                 ->getAlignment()
    //                 ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    //                 ->setVertical(Alignment::VERTICAL_CENTER);

    //             $headers->getFont()->setBold(true);

    //     } catch (Exception $exception) {
    //         throw $exception;
    //     }
    // }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

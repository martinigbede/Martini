<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ComptaExport implements FromArray, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        // Parcours des lignes pour identifier les titres de section
        foreach ($this->data as $rowIndex => $row) {
            $firstCell = $row[0] ?? '';
            $excelRow = $rowIndex + 1;

            // Colorer les titres de section
            if (str_contains(strtolower($firstCell), 'résumé') || 
                str_contains(strtolower($firstCell), 'caisses') || 
                str_contains(strtolower($firstCell), 'revenus') ||
                str_contains(strtolower($firstCell), 'paiements') ||
                str_contains(strtolower($firstCell), 'décaissements')) {
                
                $sheet->getStyle("A{$excelRow}:{$highestCol}{$excelRow}")
                    ->getFont()->setBold(true)
                    ->getColor()->setARGB('FFFFFFFF');
                $sheet->getStyle("A{$excelRow}:{$highestCol}{$excelRow}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF4A90E2');
            }

            // Alignement à droite des montants FCFA
            foreach ($row as $colIndex => $cell) {
                if (is_string($cell) && str_contains($cell, 'FCFA')) {
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                    $sheet->getStyle("{$colLetter}{$excelRow}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                }
            }
        }

        // Gras pour les en-têtes de sous-tableau
        foreach ($this->data as $rowIndex => $row) {
            if (is_array($row) && count($row) > 1 && strtolower($row[1]) === 'montant') {
                $excelRow = $rowIndex + 1;
                $sheet->getStyle("A{$excelRow}:{$highestCol}{$excelRow}")
                    ->getFont()->setBold(true);
            }
        }

        return [];
    }
}

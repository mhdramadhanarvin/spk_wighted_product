<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Employee;
use App\Models\FinalResult;
use Codedge\Fpdf\Fpdf\Fpdf;

class WPController extends Controller
{
    public function index()
    {
        $employees = Employee::with('alternates.criteria')->get();
        $criteria = Criteria::orderBy('id')->get();

        $headerAlternate = ['Nama Karyawan'];
        foreach ($criteria as $c) {
            array_push($headerAlternate, $c['name']);
        }

        $alternate = $employees->map(function ($employee) use ($criteria) {
            $result = [
                'id' => $employee->id,
                'name' => $employee->name,
            ];

            foreach ($criteria as $cr) {
                $alternateResult = $employee->alternates->firstWhere('criteria_id', $cr->id);
                $result[$cr->name] = $alternateResult ? $alternateResult->value : 0;
            }

            return $result;
        });

        $headerVectorS = $headerAlternate;
        $headerVectorS = collect($headerVectorS)->push('Total')->all();

        $vectorS = $employees->map(function ($employee) use ($criteria) {
            $result = [
                'id' => $employee->id,
                'name' => $employee->name,
            ];
            $total = 1;

            foreach ($criteria as $cr) {
                $alternateResult = $employee->alternates->firstWhere('criteria_id', $cr->id);
                $weight = $alternateResult ? number_format($alternateResult->value ** $cr->normal_weight, 3) : 0;
                $result[$cr->id] = $weight;
                $total *= $weight;
            }
            $result['total'] = number_format($total, 3);

            return $result;
        });

        $totalVectorS = $vectorS->sum('total');

        $vectorS->map(function ($data) {
            $employee = Employee::find($data['id']);
            $employee->finals()->delete();
            collect($data)->except(['id', 'name', 'total'])->each(function ($val, $key) use ($employee) {
                $final = new FinalResult([
                    'value' => $val,
                    'criteria_id' => $key
                ]);
                $employee->finals()->save($final);
            });
        });

        $headerFinal = ['Nama Karyawan', 'Skor Akhir'];
        $final = $vectorS->map(function ($data) use ($totalVectorS) {
            return collect([
                'name' => $data['name'],
                'result' => number_format($data['total'] / $totalVectorS, 3)
            ]);
        });
        $final = $final->sortBy('result', null, true);

        return view('weight_product.index', compact('alternate', 'headerAlternate', 'vectorS', 'headerVectorS', 'headerFinal', 'final'));
    }

    public function print()
    {
        $employees = Employee::with('alternates.criteria')->get();
        $criteria = Criteria::orderBy('id')->get();

        $fpdf = new Fpdf();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', '', 11);
        $fpdf->SetTitle("Hasil Perangkingan SPK SAW");

        $fpdf->Cell(40);
        // Framed title
        $fpdf->Image(public_path('images/header.png'));
        // Line break
        $fpdf->Ln(10);
        $fpdf->Cell(40);
        $fpdf->Cell(52, 10, 'Berikut hasil dari penentuan karyawan terbaik pada bimbingan belajar Adzkia', 0, 0, 'C');
        $fpdf->Ln(10);

        $header = ['Rank', 'Nama'];
        for ($i = 0; $i < count($criteria); $i++) {
            array_push($header, "K" . $i + 1);
        }
        // array_push($header, "Kriteria");
        array_push($header, "Hasil Akhir");

        $record = $employees->map(function ($employee) use ($criteria) {
            $result[] = $employee->name;

            $total = 1;
            foreach ($criteria as $cr) {
                $alternateResult = $employee->finals->firstWhere('criteria_id', $cr->id);
                $value = $alternateResult ? $alternateResult->value : 0;
                $result[] = $value;
                $total *= $value;
            }
            $result[] = $total;

            return $result;
        });

        // calculate getting total value
        $totalValue = $record->sum($criteria->count() + 1);

        $recordWithFinal = $record->map(function ($r) use ($totalValue) {
            $data = [
                ...$r,
                number_format(collect($r)->last() / $totalValue, 3)
            ];
            $collect = collect($data);

            return $collect->except($collect->count() - 2)->all();
        })->toArray();

        $recordReIndex = array_map('array_values', $recordWithFinal);

        $recordSort = collect($recordReIndex)->sortBy(count($header) - 2, null, true)->all();

        $recordReIndexSort = array_values($recordSort);

        $recordSorting = collect($recordReIndexSort)->map(function ($val, $key) {
            return [
                $key + 1,
                ...$val
            ];
        })->all();

        foreach ($header as $keyH => $col) {
            $defaultWidth = 190;
            if ($keyH == count($header) - 1) { //last record
                $width = $defaultWidth * 0.12;
            } elseif ($keyH == 0) { //first column
                $width = $defaultWidth * 0.07;
            } elseif ($keyH > 1) { //criteria column
                $width = ($defaultWidth * 0.5) / $criteria->count();
            } else {
                $width = $defaultWidth * 0.32; //employee name (second column)
            }
            $fpdf->Cell($width, 15, $col, 1, 0, 'C');
        }
        $fpdf->Ln();

        // Data
        foreach ($recordSorting as $row) {
            foreach ($row as $keyR => $col) {
                $defaultWidth = 190;
                if ($keyR == count($header) - 1) { //last record
                    $width = $defaultWidth * 0.12;
                } elseif ($keyR == 0) { //first column
                    $width = $defaultWidth * 0.07;
                } elseif ($keyR > 1) { //criteria column
                    $width = ($defaultWidth * 0.5) / $criteria->count();
                } else {
                    $width = $defaultWidth * 0.32; //employee name (second column)
                }
                $fpdf->Cell($width, 8, $col, 1, 0, 'C');
            }
            $fpdf->Ln();
        }

        $fpdf->SetTitle("Hasil Perangkingan SPK WP");

        $fpdf->Output();

        return response('Hello World', 200)
            ->header('Content-Type', 'application/pdf');
    }
}

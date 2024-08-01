<?php

namespace App\Http\Controllers;

use App\Models\AlternateResult;
use App\Models\Criteria;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('alternates.criteria')->get();
        $criteria = Criteria::orderBy('id')->get();

        $header = ['Nama Karyawan'];
        foreach ($criteria as $c) {
            array_push($header, $c['name']);
        }

        $employee = $employees->map(function ($employee) use ($criteria) {
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

        return view('employee.list', compact('employee', 'header'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criteria = Criteria::orderBy('id')->get();
        return view('employee.create', compact('criteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::insertGetId(['name' => $request->name]);
            foreach ($request->criteria as $key => $value) {
                AlternateResult::insert([
                    'employee_id' => $employee,
                    'criteria_id' => $key,
                    'value' => $value
                ]);
            }
            DB::commit();

            return redirect()->route('employee.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('employee.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employeeData = Employee::with('alternates.criteria')->select('id', 'name')->find($id);
        $criteria = Criteria::orderBy('id')->get();
        $employee = [
            'id' => $employeeData->id,
            'name' => $employeeData->name,
        ];

        foreach ($criteria as $cr) {
            $alternateResult = $employeeData->alternates->firstWhere('criteria_id', $cr->id);
            $employee['alternate'][$cr->id]['value'] = $alternateResult ? $alternateResult->value : 0;
            $employee['alternate'][$cr->id]['name'] = $cr['name'];
        }

        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->save();
            $employee->alternates()->delete();
            foreach ($request->criteria as $key => $value) {
                $criteria = Criteria::find($key);
                $alternate = new AlternateResult([
                    'employee_id' => $employee->id,
                    'value' => $value
                ]);
                $criteria->alternates()->save($alternate);
            }
            DB::commit();

            return redirect()->route('employee.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('employee.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->alternates()->delete();
        $employee->delete();

        return redirect()->route('employee.index');
    }
}

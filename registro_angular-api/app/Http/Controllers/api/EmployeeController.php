<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeSearchRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected Employee $employee;
    protected EmployeeService $employeeService;

    public function __construct()
    {
        $this->employee =  new Employee();
        $this->employeeService =  new EmployeeService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->employee->orderBy('name', 'asc')->get(), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeRequest  $request
     * @return JsonResponse
     */
    public function store(EmployeeRequest $request): JsonResponse
    {

        $this->employee->name = $request->name;
        $this->employee->email = $request->email;
        $this->employee->cpf = $request->cpf;
        $this->employee->phone = $request->phone;
        $this->employee->save();
        $this->employee->knowledges()->sync($request->knowledges);
        return response()->json('Cadastrado com sucesso!', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return JsonResponse
     */
    public function show(Employee $employee): JsonResponse
    {
        $employeeWithKnowledges = $employee->load('knowledges');
        return response()->json($employeeWithKnowledges, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmployeeRequest  $request
     * @param Employee $employee
     * @return JsonResponse
     */
    public function update(Request $request, Employee $employee): JsonResponse
    {
        $this->employee = $employee;
        $this->employee->validated = $request->validated;
        $this->employee->save();
        return response()->json('Atualizado com sucesso!', 201);
    }

    /**
     * @param EmployeeSearchRequest $request
     * @return JsonResponse
     */
    public function search(EmployeeSearchRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $employee = $this->employeeService->search($validatedData);
        return response()->json(['data' => $employee], 200);
    }



}

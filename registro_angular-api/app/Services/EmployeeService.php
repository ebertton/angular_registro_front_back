<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function search(array $validatedData)
    {
        return Employee::where(function ($query) use ($validatedData) {
            if (isset($validatedData['name'])) {
                $query->where('name', 'like', '%'.$validatedData['name'].'%');
            }
            if (isset($validatedData['email'])) {
                $query->where('email', $validatedData['email']);
            }
            if (isset($validatedData['cpf'])) {
                $query->where('cpf', $validatedData['cpf']);
            }
            if (isset($validatedData['phone'])) {
                $query->where('phone', 'like', '%'.$validatedData['phone'].'%');
            }
            if (isset($validatedData['validated'])) {
                $query->where('validated', $validatedData['validated']);
            }
        })->get();
    }
}
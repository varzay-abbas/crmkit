<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface 
{
    public function getAllEmployees() 
    {
        return Employee::with('company')->select("employees.*");
    }

    public function getEmployeeId($EmployeeId) 
    {
        return Employee::findOrFail($EmployeeId);
    }

    public function deleteEmployee($EmployeeId) 
    {
        Employee::destroy($EmployeeId);
    }

    public function createEmployee(array $EmployeeDetails) 
    {
        return Employee::create($EmployeeDetails);
    }

    public function updateEmployee($EmployeeId, array $newDetails) 
    {
        return Employee::whereId($EmployeeId)->update($newDetails);
    }

}
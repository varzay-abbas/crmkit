<?php

namespace App\Interfaces;

interface EmployeeRepositoryInterface 
{
    public function getAllEmployees();
    public function getEmployeeId($companyId);
    public function deleteEmployee($emplyeeId);
    public function createEmployee(array $companyDetails);
    public function updateEmployee($employeeId, array $newDetails);
}
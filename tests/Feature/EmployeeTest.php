<?php

namespace Tests\Feature;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testNewCompany()
    {
        Employee::create([
            "first_name" => "Test emp first name",
            "last_name" => "test emp last name",
            "phone" => "123456",
            "email" => "etest@email.com",
            "company_id" => 1,
        ]);

        $this->assertDatabaseHas('employees', [
            'email' => 'etest@email.com',
        ]);
    }
    
}
<?php

namespace Tests\Feature;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testNewCompany()
    {
        Company::create([
            "name" => "Test Company",
            "email" => "test@testunit.com",
            "website" => "http://testunit.com",
            "logo" => "test.logo.jpg"

        ]);

        $this->assertDatabaseHas('companies', [
            'email' => 'test@testunit.com',
        ]);
    }
    
    public function testDatabase()
    {
        // Make call to application...
    
       // $this->seeInDatabase('users', ['email' => 'admin@admin.com']);
        $this->assertDatabaseHas('users', [
            'email' => 'admin@admin.com',
        ]);
    }
}
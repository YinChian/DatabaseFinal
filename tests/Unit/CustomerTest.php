<?php

namespace Tests\Unit;

use App\Models\Customers;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_update_a_customer()
    {
        $customer = Customers::factory()->create();

        $updateData = [
            'Name' => 'John Doe',
            'Email' => '123@gmail.com',
            'PhoneNumber' => '1234567890',
            'Address' => '123 Main St New York, NY 10001',
            'CustomerType' => 'Individual',
            // 'RegistrationDate' => '2024-05-13',
        ];

        $customer->update($updateData);

        $this->assertDatabaseHas('customers', $updateData);
    }

    #[Test]
    public function it_can_delete_a_customer()
    {
        $customer = Customers::factory()->create();

        $customer->delete();

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    #[Test]
    public function it_can_list_customers()
    {
        $customers = Customers::factory()->count(5)->create();

        $this->assertCount(5, Customers::all());
    }

    #[Test]
    public function it_can_show_a_customer()
    {
        $customer = Customers::factory()->create();

        $foundCustomer = Customers::find($customer->id);

        $this->assertNotNull($foundCustomer);
        $this->assertEquals($customer->id, $foundCustomer->id);
    }
}

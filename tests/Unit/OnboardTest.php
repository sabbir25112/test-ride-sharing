<?php namespace Tests\Unit;

use App\Exceptions\UserNotFoundException;
use App\Features\Onboard;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardTest extends TestCase
{
    use RefreshDatabase;

    private $Onboard;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Onboard = new Onboard();
    }

    public function test_add_user()
    {
         $this->Onboard->addUser("Rohan", "M", 26);

         $this->assertDatabaseHas((new User())->getTable(), [
            'name' => 'Rohan',
         ]);
    }

    public function test_add_user_by_helper_function()
    {
        add_user("Rohan", "M", 26);

        $this->assertDatabaseHas((new User())->getTable(), [
            'name' => 'Rohan',
        ]);
    }

    public function test_add_vehicle()
    {
        $this->Onboard->addUser("Rohan", "M", 26);
        $this->Onboard->addVehicle("Rohan", "Swift", "KA-01-12345");

        $this->assertDatabaseHas((new Vehicle())->getTable(), [
            'vehicle_number' => "KA-01-12345",
        ]);
    }

    public function test_add_vehicle_by_helper_function()
    {
        add_user("Rohan", "M", 26);
        add_vehicle("Rohan", "Swift", "KA-01-12345");

        $this->assertDatabaseHas((new Vehicle())->getTable(), [
            'vehicle_number' => "KA-01-12345",
        ]);
    }

    public function test_add_vehicle_without_user()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("User Not Found");

        $this->Onboard->addVehicle("Rohan", "Swift", "KA-01-12345");
    }
}

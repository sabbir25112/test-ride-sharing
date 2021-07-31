<?php namespace App\Features;


use App\Exceptions\AlreadyOfferedException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\VehicleNotFoundException;
use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class RideOffering
{
    protected $rideCreator;
    protected $vehicle;

    /**
     * @param User|Model $rideCreator
     */
    public function setRideCreator(Model $rideCreator): self
    {
        $this->rideCreator = $rideCreator;
        return $this;
    }

    /**
     * @param Model $vehicle
     */
    public function setVehicle(Model $vehicle): self
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    public function offerRide($origin, $destination, $available_seats)
    {
        if (!$this->vehicle) throw new InvalidParameterException("Vehicle Not Found");
        if (!$this->rideCreator) throw new InvalidParameterException("Ride Creator Not Found");

        if (!$this->vehicle->isOfferable()) throw new AlreadyOfferedException();

        DB::beginTransaction();
        try {
            Ride::create([
                'user_id'       => $this->rideCreator->id,
                'vehicle_id'    => $this->vehicle->id,
                'origin'        => $origin,
                'destination'   => $destination,
                'available_seats' => $available_seats,
            ]);

            $this->vehicle->isOffered();

            DB::commit();
            return true;

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return false;
        }
    }
}

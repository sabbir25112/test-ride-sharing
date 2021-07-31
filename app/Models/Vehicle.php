<?php namespace App\Models;

use App\Exceptions\AlreadyOfferedException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'user_id',
        'model',
        'is_offered',
    ];

    public function getVehicleByNumber($vehicle_number)
    {
        return $this->where('vehicle_number', $vehicle_number)->first();
    }

    public function isOfferable()
    {
        return !$this->is_offered;
    }

    public function isOffered()
    {
        if (!$this->isOfferable()) throw new AlreadyOfferedException();

        $this->is_offered = true;
        $this->save();
    }
}

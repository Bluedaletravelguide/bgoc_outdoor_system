<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_request';

    protected $guarded = ['id'];

    protected $fillable = [
        'service_request_no',
        'description',
        'location',
        'status',
        'remarks_by_client',
        'remarks_by_teamleader',
        'work_order_id',
        'sr_sub_category_id',
        'sr_category_id',
        'raise_by',
        'project_id',
        'asset_id',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($serviceRequest) {
            // Generate the service request number and work order number
            $getPrefixNo = $serviceRequest->generatePrefixNo();

            // Assign the service request number to the service_request_no property
            $serviceRequest->service_request_no = $getPrefixNo[0];

        });
    }

    public function generatePrefixNo()
    {

        $getPrefix = Project::select('projects.project_prefix', 'client_company.company_prefix')
        ->leftJoin('client_company', 'projects.client_company_id', 'client_company.id')
        ->where('projects.id', $this->project_id)
        ->get();

        logger("testttt: " . $this);
        logger("getprefix: " . $getPrefix);

        $companyPrefix = $getPrefix[0]->company_prefix;
        $projectPrefix = $getPrefix[0]->project_prefix;

        // Get the current count of service requests for this combination of prefixes
        $count = static::where('project_id', $this->project_id)->count() + 1;

        // Format the count to have leading zeros
        $countFormatted = str_pad($count, 6, '0', STR_PAD_LEFT);

        // Concatenate all parts to form the service request numbers
        $serviceRequestNo = "sr-$companyPrefix$projectPrefix-$countFormatted";
        $workOrderNo = "wo-$companyPrefix$projectPrefix-$countFormatted";

        // Concatenate all parts to form the service request number
        return [$serviceRequestNo, $workOrderNo];
    }

    public function work_orders()
    {
        return $this->belongsToMany(WorkOrder::class);
    }

    public function sr_photos()
    {
        return $this->belongsToMany(ServiceRequestPhoto::class);
    }

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
    public function assets()
    {
        return $this->belongsTo(Asset::class);
    }
}

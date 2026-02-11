<?php

namespace App\Observers;

use App\Models\ServiceAvailability;
use App\Models\StatusHistory;

class ServiceAvailabilityObserver
{
    /**
     * Handle the ServiceAvailability "updating" event.
     */
    public function updating(ServiceAvailability $serviceAvailability): void
    {
        // Check if status has changed
        if ($serviceAvailability->isDirty('status')) {
            // Create a history record
            StatusHistory::create([
                'service_availability_id' => $serviceAvailability->id,
                'old_status' => $serviceAvailability->getOriginal('status'),
                'new_status' => $serviceAvailability->status,
                'changed_by' => auth()->id(),
                'notes' => $serviceAvailability->notes ?? null,
            ]);

            // Update last_updated timestamp
            $serviceAvailability->last_updated = now();
        }
    }
}

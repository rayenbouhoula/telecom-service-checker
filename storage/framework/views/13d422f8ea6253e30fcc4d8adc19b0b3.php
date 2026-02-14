<?php $__env->startSection('title', 'Service Availability'); ?>

<?php
    $breadcrumbs = [
        ['title' => 'Service Availability', 'url' => '']
    ];
?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-broadcast-pin"></i> Service Availability</h2>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.service-availability.export')); ?>" class="btn btn-outline-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
        <a href="<?php echo e(route('admin.service-availability.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Service
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.service-availability.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Area</label>
                <select name="area_id" class="form-select">
                    <option value="">All Areas</option>
                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($area->id); ?>" <?php echo e(request('area_id') == $area->id ? 'selected' : ''); ?>>
                            <?php echo e($area->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Service Type</label>
                <select name="service_type_id" class="form-select">
                    <option value="">All Service Types</option>
                    <?php $__currentLoopData = $serviceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>" <?php echo e(request('service_type_id') == $type->id ? 'selected' : ''); ?>>
                            <?php echo e($type->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="available" <?php echo e(request('status') == 'available' ? 'selected' : ''); ?>>Available</option>
                    <option value="maintenance" <?php echo e(request('status') == 'maintenance' ? 'selected' : ''); ?>>Under Maintenance</option>
                    <option value="problem" <?php echo e(request('status') == 'problem' ? 'selected' : ''); ?>>Service Issue</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-search"></i> Apply Filters
                </button>
                <a href="<?php echo e(route('admin.service-availability.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Services Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Area</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Last Updated</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $serviceAvailabilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($service->id); ?></td>
                            <td>
                                <i class="bi bi-geo-alt text-primary"></i>
                                <?php echo e($service->area->name); ?>

                            </td>
                            <td>
                                <?php if($service->serviceType->icon): ?>
                                    <i class="bi bi-<?php echo e($service->serviceType->icon); ?>"></i>
                                <?php endif; ?>
                                <?php echo e($service->serviceType->name); ?>

                            </td>
                            <td>
                                <?php if($service->status == 'available'): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Available
                                    </span>
                                <?php elseif($service->status == 'maintenance'): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-tools"></i> Under Maintenance
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-triangle"></i> Service Issue
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($service->notes): ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?php echo e($service->notes); ?>">
                                        <?php echo e($service->notes); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($service->last_updated ? $service->last_updated->format('Y-m-d H:i') : 'N/A'); ?></td>
                            <td class="text-end table-actions">
                                <div class="btn-group" role="group">
                                    <!-- Quick Status Update Buttons -->
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="updateStatus(<?php echo e($service->id); ?>, 'available')"
                                            title="Mark as Available">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="updateStatus(<?php echo e($service->id); ?>, 'maintenance')"
                                            title="Mark as Maintenance">
                                        <i class="bi bi-tools"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="updateStatus(<?php echo e($service->id); ?>, 'problem')"
                                            title="Mark as Problem">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </button>
                                </div>
                                <a href="<?php echo e(route('admin.service-availability.edit', $service)); ?>" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="<?php echo e(route('admin.service-availability.destroy', $service)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">No service availability records found</p>
                                <a href="<?php echo e(route('admin.service-availability.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Add First Service
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($serviceAvailabilities->hasPages()): ?>
        <div class="card-footer bg-white">
            <?php echo e($serviceAvailabilities->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function updateStatus(serviceId, status) {
    const statusLabels = {
        'available': 'Available',
        'maintenance': 'Under Maintenance',
        'problem': 'Service Issue'
    };
    
    const statusLabel = statusLabels[status] || status;
    
    if (confirm('Are you sure you want to update the status to ' + statusLabel + '?')) {
        fetch('<?php echo e(route("admin.service-availability.quick-update")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                id: serviceId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update status: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while updating status');
            console.error(error);
        });
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MAISON INFO\telecom-service-checker\resources\views/admin/service-availability/index.blade.php ENDPATH**/ ?>
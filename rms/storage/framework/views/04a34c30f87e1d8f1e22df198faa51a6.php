
<?php $__env->startSection('title', 'Order Details'); ?>
<?php $__env->startSection('page-title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-3 d-flex gap-2">
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-outline-secondary">
        <i class="ti ti-arrow-left me-1"></i>Back to Orders
    </a>
    
    <a href="<?php echo e(route('admin.orders.invoice', $order)); ?>"
       target="_blank"
       class="btn btn-sm btn-success">
        <i class="ti ti-receipt me-1"></i>View Invoice
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-2">Customer</h6>
                <strong><?php echo e($order->user->name ?? 'Guest'); ?></strong><br>
                <small class="text-muted"><?php echo e($order->user->email ?? ''); ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-2">Table & Type</h6>
                <strong><?php echo e($order->table ? 'Table #' . $order->table->table_number : 'No Table'); ?></strong><br>
                <span class="badge bg-info-subtle text-info-emphasis"><?php echo e(ucfirst(str_replace('_', ' ', $order->order_type ?? 'dine_in'))); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-2">Date & Time</h6>
                <strong><?php echo e($order->created_at->format('d M Y')); ?></strong><br>
                <small class="text-muted"><?php echo e($order->created_at->format('h:i A')); ?></small>
            </div>
        </div>
    </div>
</div>

<!-- Updated Row: Changed to col-md-4 to fit 3 cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-3">Order Status</h6>
                <form method="POST" action="<?php echo e(route('admin.orders.status', $order)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div class="d-flex gap-2 align-items-center">
                        <select name="status" class="form-select form-select-sm" style="max-width:200px;">
                            <?php $__currentLoopData = ['pending','confirmed','cooking','ready','served','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e($order->status === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-check"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-3">Payment</h6>
                <form method="POST" action="<?php echo e(route('admin.orders.payment', $order)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        <select name="payment_status" class="form-select form-select-sm" style="max-width:150px;">
                            <option value="unpaid" <?php echo e($order->payment_status === 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                            <option value="paid" <?php echo e($order->payment_status === 'paid' ? 'selected' : ''); ?>>Paid</option>
                        </select>
                        <select name="payment_method" class="form-select form-select-sm" style="max-width:150px;">
                            <option value="cash" <?php echo e($order->payment_method === 'cash' ? 'selected' : ''); ?>>Cash</option>
                            <option value="card" <?php echo e($order->payment_method === 'card' ? 'selected' : ''); ?>>Card</option>
                            <option value="online" <?php echo e($order->payment_method === 'online' ? 'selected' : ''); ?>>Online</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success"><i class="ti ti-check"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- NEW: Assign Waiter Card -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-3">Assign Waiter</h6>
                <form method="POST"
                      action="<?php echo e(route('admin.orders.waiter', $order)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <?php
                        $staff = \App\Models\User::whereIn('role', ['staff','admin'])->get();
                    ?>
                    <select name="waiter_id" class="form-select form-select-sm mb-2">
                        <option value="">-- Select Waiter --</option>
                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>"
                            <?php echo e($order->waiter_id == $s->id ? 'selected' : ''); ?>>
                            <?php echo e($s->name); ?> (<?php echo e(ucfirst($s->role)); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-info w-100">
                        <i class="ti ti-user-check me-1"></i> Assign Waiter
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- End New Card -->

</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="ti ti-list-details me-1"></i>Order Items</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <strong><?php echo e($item->menuItem->name ?? 'Item'); ?></strong>
                        <?php if($item->special_instructions): ?>
                        <br><small class="text-muted"><?php echo e($item->special_instructions); ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                    <td class="text-end">Rs.<?php echo e(number_format($item->unit_price ?? $item->price, 0)); ?></td>
                    <td class="text-end fw-bold">Rs.<?php echo e(number_format($item->subtotal ?? ($item->quantity * ($item->unit_price ?? $item->price)), 0)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">No items.</td></tr>
                <?php endif; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th class="text-end text-success fs-5">Rs.<?php echo e(number_format($order->total_amount, 0)); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php if($order->notes): ?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h6 class="text-muted small text-uppercase mb-1">Notes</h6>
        <p class="mb-0"><?php echo e($order->notes); ?></p>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\RM sytem\rms\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>
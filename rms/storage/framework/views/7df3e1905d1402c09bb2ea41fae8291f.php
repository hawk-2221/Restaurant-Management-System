
<?php $__env->startSection('title', 'New Order'); ?>
<?php $__env->startSection('page-title', 'Create New Order'); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-plus me-2 text-success"></i>New Order
                </h6>
            </div>
            <div class="card-body">

                <?php if($errors->any()): ?>
                <div class="alert alert-danger py-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="small"><?php echo e($e); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.orders.store')); ?>" id="orderForm">
                    <?php echo csrf_field(); ?>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Order Type *</label>
                            <select name="order_type" class="form-select" required>
                                <option value="dine_in">Dine In</option>
                                <option value="takeaway">Takeaway</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Table</label>
                            <select name="table_id" class="form-select">
                                <option value="">-- No Table --</option>
                                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($table->id); ?>">Table #<?php echo e($table->table_number); ?> (<?php echo e($table->capacity); ?> persons)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Special instructions...">
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">
                        <i class="ti ti-tools-kitchen-2 me-2"></i>Select Items
                    </h6>

                    <div id="orderItems">
                        <div class="order-item row g-2 mb-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label small">Item *</label>
                                <select name="items[0][id]" class="form-select item-select" onchange="calculateTotal()" required>
                                    <option value="">-- Select Item --</option>
                                    <?php $__currentLoopData = $menuItems->groupBy('category.name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <optgroup label="<?php echo e($cat ?? 'Uncategorized'); ?>">
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?> — Rs.<?php echo e(number_format($item->price, 0)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Qty *</label>
                                <input type="number" name="items[0][qty]" class="form-control item-qty" value="1" min="1" onchange="calculateTotal()" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Note</label>
                                <input type="text" name="items[0][note]" class="form-control" placeholder="e.g. no onion">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeItem(this)">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm mb-4" onclick="addItem()">
                        <i class="ti ti-plus me-1"></i>Add Item
                    </button>

                    <div class="alert alert-success d-flex justify-content-between align-items-center py-2">
                        <strong>Total Amount:</strong>
                        <strong class="fs-5" id="totalDisplay">Rs. 0</strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-1"></i>Create Order
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-list me-2"></i>Menu Reference
                </h6>
            </div>
            <div class="card-body p-0" style="max-height:500px; overflow-y:auto;">
                <?php $__currentLoopData = $menuItems->groupBy('category.name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-3 border-bottom">
                    <div class="fw-semibold small text-muted mb-2"><?php echo e($cat ?? 'Uncategorized'); ?></div>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small><?php echo e($item->name); ?></small>
                        <small class="text-success fw-bold">Rs.<?php echo e(number_format($item->price, 0)); ?></small>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let itemIndex = 1;
const menuPrices = <?php echo json_encode($menuItems->pluck('price', 'id'), 512) ?>;

function addItem() {
    const container = document.getElementById('orderItems');
    const div = document.createElement('div');
    div.className = 'order-item row g-2 mb-3 align-items-end';
    div.innerHTML = '<div class="col-md-5"><label class="form-label small">Item *</label><select name="items[' + itemIndex + '][id]" class="form-select item-select" onchange="calculateTotal()" required>' + getMenuOptions() + '</select></div><div class="col-md-2"><label class="form-label small">Qty *</label><input type="number" name="items[' + itemIndex + '][qty]" class="form-control item-qty" value="1" min="1" onchange="calculateTotal()" required></div><div class="col-md-3"><label class="form-label small">Note</label><input type="text" name="items[' + itemIndex + '][note]" class="form-control" placeholder="e.g. no onion"></div><div class="col-md-2"><button type="button" class="btn btn-danger btn-sm w-100" onclick="removeItem(this)"><i class="ti ti-trash"></i></button></div>';
    container.appendChild(div);
    itemIndex++;
}

function getMenuOptions() {
    let opts = '<option value="">-- Select Item --</option>';
    <?php $__currentLoopData = $menuItems->groupBy('category.name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    opts += '<optgroup label="<?php echo e($cat ?? 'Uncategorized'); ?>">';
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    opts += '<option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?> — Rs.<?php echo e(number_format($item->price, 0)); ?></option>';
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    opts += '</optgroup>';
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    return opts;
}

function removeItem(btn) {
    const items = document.querySelectorAll('.order-item');
    if (items.length > 1) {
        btn.closest('.order-item').remove();
        calculateTotal();
    }
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.order-item').forEach(function(row) {
        const select = row.querySelector('.item-select');
        const qty = row.querySelector('.item-qty');
        if (select && select.value && qty) {
            const price = menuPrices[select.value] || 0;
            total += price * parseInt(qty.value || 1);
        }
    });
    document.getElementById('totalDisplay').textContent = 'Rs. ' + total.toLocaleString();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\RM sytem\rms\resources\views/admin/orders/create.blade.php ENDPATH**/ ?>
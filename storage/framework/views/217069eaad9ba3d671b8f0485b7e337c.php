

<?php $__env->startSection('content'); ?>
<div class="px-20 py-10">
    <h2 class="font-bold text-2xl border-l-4 border-blue-500 pl-4"><?php echo e($category->name); ?> Products</h2>
    <div class="grid grid-cols-4 gap-4 mt-5">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

        <a href="<?php echo e(route('viewproduct', $product->id)); ?>" class=" border p-4 rounded-lg shadow hover:shadow-md transition-all hover:-translate-y-2">
            <img src="<?php echo e(asset('images/products/'.$product->photopath)); ?>" alt="Product Image" class="w-full h-48 object-cover rounded-lg mb-2">
            <h3 class="text-lg font-semibold"><?php echo e($product->name); ?></h3>
            <p class="text-gray-600">
                <?php if($product->discounted_price!=''): ?>
                <span>Rs.<?php echo e($product->discounted_price); ?></span>
                <span class="line-through text-red-500">Rs.<?php echo e($product->price); ?></span> 
                <?php else: ?>
                <span>Rs.<?php echo e($product->price); ?></span>
                <?php endif; ?>
            </p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hp\OneDrive\Desktop\laravel proj\ecommerce-csit-4th\resources\views/categoryproducts.blade.php ENDPATH**/ ?>
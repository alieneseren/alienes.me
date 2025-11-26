<?php $__env->startSection('title', 'Projeler - ' . ($profile->full_name ?? 'alienes.me')); ?>
<?php $__env->startSection('content'); ?>
<section class="py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-4">Projelerim</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-12">Gerçekleştirdiğim projeler ve çalışmalar</p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card hover:scale-105">
                <?php if($project->image): ?>
                <img src="<?php echo e(asset('storage/' . $project->image)); ?>" alt="<?php echo e($project->title); ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                <?php else: ?>
                <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-white font-bold"><?php echo e(substr($project->title, 0, 1)); ?></span>
                </div>
                <?php endif; ?>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2"><?php echo e($project->title); ?></h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4"><?php echo e($project->description); ?></p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <?php $__currentLoopData = $project->technologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 rounded-full text-sm"><?php echo e($tech); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="flex gap-4">
                    <?php if($project->demo_url): ?>
                    <a href="<?php echo e($project->demo_url); ?>" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline">Demo</a>
                    <?php endif; ?>
                    <?php if($project->github_url): ?>
                    <a href="<?php echo e($project->github_url); ?>" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline">GitHub</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-600 dark:text-gray-400">Henüz proje eklenmemiş.</p>
            </div>
            <?php endif; ?>
        </div>
        <div class="mt-12">
            <?php echo e($projects->links()); ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/alienes/alienes.me/resources/views/frontend/projects.blade.php ENDPATH**/ ?>
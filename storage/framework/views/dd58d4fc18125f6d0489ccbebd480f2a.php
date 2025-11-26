<?php $__env->startSection('title', 'Projeler - Alienes.me'); ?>
<?php $__env->startSection('meta_description', 'Tüm projelerim ve çalışmalarım'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<section class="pt-24 pb-12 bg-gradient-to-br from-primary-50 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">Projelerim</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">Üzerinde çalıştığım ve tamamladığım projeler</p>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if($projects->count() > 0): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <?php if($project->image): ?>
                <img src="<?php echo e(asset('storage/' . $project->image)); ?>" alt="<?php echo e($project->title); ?>" class="w-full h-48 object-cover">
                <?php else: ?>
                <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white"><?php echo e(substr($project->title, 0, 1)); ?></span>
                </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2"><?php echo e($project->title); ?></h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4"><?php echo e($project->description); ?></p>
                    
                    <?php if($project->technologies): ?>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php $__currentLoopData = is_array($project->technologies) ? $project->technologies : explode(',', $project->technologies); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-xs rounded"><?php echo e(trim($tech)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex gap-4">
                        <?php if($project->demo_url): ?>
                        <a href="<?php echo e($project->demo_url); ?>" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm font-semibold">
                            Demo →
                        </a>
                        <?php endif; ?>
                        <?php if($project->github_url): ?>
                        <a href="<?php echo e($project->github_url); ?>" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm font-semibold">
                            GitHub →
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Pagination -->
        <?php if($projects->hasPages()): ?>
        <div class="mt-12">
            <?php echo e($projects->links()); ?>

        </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="text-center py-12">
            <p class="text-xl text-gray-600 dark:text-gray-400">Henüz proje eklenmemiş.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/alienes/alienes.me/resources/views/projects.blade.php ENDPATH**/ ?>
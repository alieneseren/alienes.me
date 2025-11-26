<?php $__env->startSection('title', 'Çalışma Notları'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl sm:text-4xl font-bold mb-3 sm:mb-4 text-gray-900 dark:text-white break-words">📚 Çalışma Notları</h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-8 sm:mb-12">Ders notlarına, örneklere ve pratik sorulara buradan ulaşabilirsiniz.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('study.category', $category->slug)); ?>" 
               class="block bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-shadow p-5 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="text-4xl sm:text-5xl mb-3 sm:mb-4"><?php echo e($category->icon); ?></div>
                <h2 class="text-xl sm:text-2xl font-bold mb-2 text-gray-900 dark:text-white break-words line-clamp-2"><?php echo e($category->name); ?></h2>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 break-words line-clamp-2"><?php echo e($category->description); ?></p>
                <div class="flex items-center text-xs sm:text-sm text-gray-500 dark:text-gray-500">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                    <span class="truncate"><?php echo e($category->active_notes_count); ?> not</span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/alienes/alienes.me/resources/views/study/index.blade.php ENDPATH**/ ?>
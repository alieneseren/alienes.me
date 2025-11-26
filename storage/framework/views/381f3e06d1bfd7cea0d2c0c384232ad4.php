<?php $__env->startSection('title', $note->title . ' - ' . $category->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <li><a href="<?php echo e(route('study.index')); ?>" class="hover:text-primary-600">📚 Çalışma Notları</a></li>
                <li><span>/</span></li>
                <li><a href="<?php echo e(route('study.category', $category->slug)); ?>" class="hover:text-primary-600"><?php echo e($category->name); ?></a></li>
                <li><span>/</span></li>
                <li class="text-gray-900 dark:text-white font-semibold"><?php echo e($note->title); ?></li>
            </ol>
        </nav>

        <!-- Note Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4 mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($note->title); ?></h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        <?php echo e($category->icon); ?> <?php echo e($category->name); ?> • 👁️ <?php echo e($note->views); ?> görüntülenme
                    </p>
                </div>
                <a href="<?php echo e(route('study.category', $category->slug)); ?>" class="btn-secondary text-sm">
                    ← Geri Dön
                </a>
            </div>
        </div>

        <!-- HTML Content in Iframe -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
            <iframe 
                src="<?php echo e(asset($note->file_path)); ?>" 
                class="w-full border-0"
                style="min-height: calc(100vh - 250px);"
                onload="this.style.height=(this.contentWindow.document.documentElement.scrollHeight + 50) + 'px';"
                frameborder="0">
            </iframe>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/alienes/alienes.me/resources/views/study/show.blade.php ENDPATH**/ ?>
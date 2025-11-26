<?php $__env->startSection('title', isset($category) ? $category->name . ' - Blog' : 'Blog'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
            <?php echo e(isset($category) ? $category->name : 'Blog'); ?>

        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            <?php echo e(isset($category) && $category->description ? $category->description : 'Yazılım, teknoloji ve deneyimlerim hakkında yazılar.'); ?>

        </p>
    </div>

    <!-- Categories -->
    <div class="flex flex-wrap justify-center gap-4 mb-12">
        <a href="<?php echo e(route('blog.index')); ?>" 
           class="px-4 py-2 rounded-full transition-colors <?php echo e(!isset($category) ? 'bg-primary-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'); ?>">
            Tümü
        </a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('blog.category', $cat->slug)); ?>" 
               class="px-4 py-2 rounded-full transition-colors <?php echo e(isset($category) && $category->id == $cat->id ? 'bg-primary-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'); ?>">
                <?php echo e($cat->name); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <?php if($post->image): ?>
                    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block h-48 overflow-hidden">
                        <img src="<?php echo e(Storage::url($post->image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    </a>
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <a href="<?php echo e(route('blog.category', $post->category->slug)); ?>" class="text-xs font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider">
                            <?php echo e($post->category->name); ?>

                        </a>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($post->published_at->format('d M Y')); ?></span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <?php echo e($post->title); ?>

                        </a>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                        <?php echo e($post->excerpt ?? Str::limit(strip_tags($post->content), 150)); ?>

                    </p>
                    <div class="flex items-center justify-between mt-auto">
                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                            Devamını Oku &rarr;
                        </a>
                        <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <?php echo e($post->views); ?>

                        </span>
                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <div class="inline-block p-4 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Henüz yazı bulunmuyor</h3>
                <p class="text-gray-600 dark:text-gray-400">Bu kategoriye ait henüz bir yazı eklenmemiş.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-8">
        <?php echo e($posts->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/alienes/alienes.me/resources/views/frontend/blog/index.blade.php ENDPATH**/ ?>
<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$app['config']->set('database.connections.sqlite_testing', [
    'driver' => 'sqlite',
    'database' => ':memory:',
    'prefix' => ''
]);
$app['config']->set('database.default', 'sqlite_testing');

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Profile;

Schema::create('profiles', function (Blueprint $table) {
    $table->id();
    $table->string('full_name')->nullable();
    $table->timestamps();
});
Profile::create(['full_name' => 'Test']);

// Test with global query log
\DB::enableQueryLog();

// Simulate layout load
$profile1 = Profile::first();

// And later again in the same layout
$profile2 = Profile::first();

print_r(\DB::getQueryLog());

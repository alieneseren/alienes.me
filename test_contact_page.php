<?php
// DEBUG SCRIPT - Contact page tamamı kontrol et
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get profile
$profile = \App\Models\Profile::first();

echo "===================== PROFILE DATA =====================\n\n";
echo "Profile exists: " . ($profile ? "YES" : "NO") . "\n";

if ($profile) {
    echo "\nProfile fields:\n";
    echo "- full_name: " . $profile->full_name . "\n";
    echo "- email: " . $profile->email . "\n";
    echo "- phone: " . ($profile->phone ?: "[empty]") . "\n";
    echo "- location: " . ($profile->location ?: "[empty]") . "\n";
    echo "- linkedin_url: [" . $profile->linkedin_url . "]\n";
    echo "- github_url: [" . $profile->github_url . "]\n";
    echo "- twitter_url: [" . $profile->twitter_url . "]\n";
    
    echo "\n===================== CONDITION TESTS =====================\n\n";
    
    // Test each condition exactly as in blade
    $linkedin_check = ($profile->linkedin_url && !empty(trim($profile->linkedin_url)));
    $github_check = ($profile->github_url && !empty(trim($profile->github_url)));
    $twitter_check = ($profile->twitter_url && !empty(trim($profile->twitter_url)));
    
    echo "LinkedIn condition (show link): " . ($linkedin_check ? "✅ SHOW" : "❌ HIDE") . "\n";
    echo "GitHub condition (show link): " . ($github_check ? "✅ SHOW" : "❌ HIDE") . "\n";
    echo "Twitter condition (show link): " . ($twitter_check ? "✅ SHOW" : "❌ HIDE") . "\n";
    
    echo "\n";
    
    $outer_condition = (($profile->linkedin_url && !empty(trim($profile->linkedin_url))) || 
                        ($profile->github_url && !empty(trim($profile->github_url))) || 
                        ($profile->twitter_url && !empty(trim($profile->twitter_url))));
    
    echo "Outer condition (show section): " . ($outer_condition ? "✅ YES" : "❌ NO") . "\n";
    
    echo "\n";
    
    if ($linkedin_check || $github_check || $twitter_check) {
        echo "✅ SECTION WILL BE VISIBLE\n";
        if ($linkedin_check) echo "  - LinkedIn icon will show: $profile->linkedin_url\n";
        if ($github_check) echo "  - GitHub icon will show: $profile->github_url\n";
        if ($twitter_check) echo "  - Twitter icon will show: $profile->twitter_url\n";
    } else {
        echo "❌ SECTION WILL BE HIDDEN (all fields empty or false)\n";
    }
}

echo "\n===================== HTML RENDER TEST =====================\n\n";

// Try rendering
try {
    $view = \Illuminate\Support\Facades\View::make('contact', [
        'profile' => $profile,
        'errors' => new \Illuminate\Support\MessageBag()
    ]);
    $html = $view->render();
    
    // Check if "Sosyal Medya" is in HTML
    if (strpos($html, 'Sosyal Medya') !== false) {
        echo "✅ 'Sosyal Medya' header found in HTML\n";
    } else {
        echo "❌ 'Sosyal Medya' header NOT found in HTML\n";
    }
    
    // Check for links
    if (strpos($html, 'linkedin.com') !== false) {
        echo "✅ LinkedIn link found in HTML\n";
    }
    if (strpos($html, 'github.com') !== false) {
        echo "✅ GitHub link found in HTML\n";
    }
    if (strpos($html, 'twitter') !== false) {
        echo "✅ Twitter link found in HTML\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error rendering view: " . $e->getMessage() . "\n";
}
?>

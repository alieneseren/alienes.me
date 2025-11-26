<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Profile;
use App\Http\Requests\StoreContactRequest;
use App\Notifications\NewContactMessage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('contact', compact('profile'));
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        
        // Admin'e email gönder
        $profile = Profile::first();
        if ($profile && $profile->email) {
            try {
                // Admin objesine benzeyen bir obje oluştur
                $admin = (object)[
                    'email' => $profile->email,
                    'name' => $profile->name ?? 'Admin'
                ];
                
                // Notification gönder
                Notification::send($admin, new NewContactMessage($contact));
            } catch (\Exception $e) {
                // Email gönderme başarısız olsa bile mesaj kaydedilir
                \Log::warning('Contact form email gönderilemedi: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağım.');
    }
}

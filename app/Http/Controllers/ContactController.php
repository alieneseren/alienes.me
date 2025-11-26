<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Profile;
use App\Http\Requests\StoreContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('contact', compact('profile'));
    }

    public function store(StoreContactRequest $request)
    {
        // Mesajı kaydet
        $contact = Contact::create($request->validated());
        
        // Email gönderme denemesi (başarısız olsa da devam eder)
        $profile = Profile::first();
        if ($profile && $profile->email) {
            try {
                \Log::info('Contact message received', [
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'subject' => $contact->subject,
                    'admin_email' => $profile->email
                ]);
                
                // Email göndermeye çalış
                $adminEmail = $profile->email;
                $subject = 'Yeni İletişim Mesajı - ' . $contact->subject;
                $body = "Yeni mesaj:\n\nAd: {$contact->name}\nEmail: {$contact->email}\nKonu: {$contact->subject}\n\nMesaj:\n{$contact->message}";
                
                // Bu şekilde gönder
                @mail($adminEmail, $subject, $body);
            } catch (\Exception $e) {
                \Log::warning('Contact form error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Mesajınız başarıyla kaydedildi. En kısa sürede size dönüş yapacağız.');
    }
}
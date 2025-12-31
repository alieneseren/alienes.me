<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Yeni İletişim Mesajı</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #0284c7;
            font-size: 24px;
        }
        .content {
            margin: 20px 0;
        }
        .field {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 3px solid #0284c7;
            border-radius: 4px;
        }
        .field-label {
            font-weight: bold;
            color: #0284c7;
            font-size: 14px;
        }
        .field-value {
            color: #333;
            margin-top: 5px;
            word-wrap: break-word;
        }
        .message-body {
            background-color: #fff9e6;
            padding: 15px;
            border-radius: 4px;
            border-left: 3px solid #fbc02d;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            border-top: 1px solid #ddd;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            background-color: #0284c7;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0369a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Yeni İletişim Mesajı</h1>
        </div>

        <div class="content">
            <p>Merhaba,</p>
            <p>Porfoliyo web sitenizden yeni bir mesaj geldi. Detaylar aşağıdadır:</p>

            <div class="field">
                <div class="field-label">📝 Gönderici Adı</div>
                <div class="field-value">{{ $contact->name }}</div>
            </div>

            <div class="field">
                <div class="field-label">📧 Gönderici E-postası</div>
                <div class="field-value">
                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                </div>
            </div>

            <div class="field">
                <div class="field-label">📞 Telefon</div>
                <div class="field-value">
                    @if($contact->phone)
                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                    @else
                        <em>Telefon numarası verilmemiş</em>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="field-label">💬 Konu</div>
                <div class="field-value">{{ $contact->subject }}</div>
            </div>

            <div class="field">
                <div class="field-label">📬 Mesaj</div>
                <div class="message-body">{{ $contact->message }}</div>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="button">
                    Admin Panele Git
                </a>
            </div>
        </div>

        <div class="footer">
            <p>Bu mesaj {{ config('app.name') }} iletişim formundan gönderilmiştir.</p>
            <p>{{ now()->format('d.m.Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>

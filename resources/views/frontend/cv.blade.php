<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->name }} - CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .cv-container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .cv-header {
            background: #2c3e50;
            color: white;
            padding: 40px;
            text-align: center;
        }
        .cv-header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 700;
        }
        .cv-header h2 {
            font-size: 1.2em;
            font-weight: 300;
            margin-top: 10px;
            opacity: 0.9;
        }
        .contact-info {
            background: #34495e;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 0.9em;
        }
        .contact-info span {
            margin: 0 15px;
        }
        .contact-info i {
            margin-right: 5px;
            color: #3498db;
        }
        .cv-body {
            padding: 40px;
        }
        .section-title {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 30px;
            color: #2c3e50;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .section-title:first-child {
            margin-top: 0;
        }
        .experience-item, .education-item {
            margin-bottom: 25px;
        }
        .item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .item-title {
            font-weight: 700;
            font-size: 1.1em;
        }
        .item-subtitle {
            font-weight: 600;
            color: #7f8c8d;
        }
        .item-date {
            color: #3498db;
            font-weight: 600;
            font-size: 0.9em;
        }
        .skill-tag {
            display: inline-block;
            background: #ecf0f1;
            color: #2c3e50;
            padding: 5px 15px;
            border-radius: 20px;
            margin: 0 5px 10px 0;
            font-weight: 600;
        }
        .social-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1.2em;
            transition: color 0.3s;
        }
        .social-links a:hover {
            color: #3498db;
        }
        @media print {
            body { background: white; }
            .cv-container { box-shadow: none; margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container no-print mb-3 mt-3">
    <a href="/" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Ana Sayfa</a>
    <button onclick="window.print()" class="btn btn-primary float-end"><i class="fas fa-print"></i> Yazdır / PDF</button>
</div>

<div class="cv-container">
    <div class="cv-header">
        <h1>{{ $cv->name }}</h1>
        @if($cv->title)
            <h2>{{ $cv->title }}</h2>
        @endif
        
        @if($cv->social_links)
        <div class="social-links mt-3">
            @foreach($cv->social_links as $social)
                <a href="{{ $social['url'] }}" target="_blank" title="{{ $social['platform'] }}">
                    @if(stripos($social['platform'], 'linkedin') !== false) <i class="fab fa-linkedin"></i>
                    @elseif(stripos($social['platform'], 'github') !== false) <i class="fab fa-github"></i>
                    @elseif(stripos($social['platform'], 'twitter') !== false) <i class="fab fa-twitter"></i>
                    @elseif(stripos($social['platform'], 'instagram') !== false) <i class="fab fa-instagram"></i>
                    @else <i class="fas fa-link"></i>
                    @endif
                </a>
            @endforeach
        </div>
        @endif
    </div>

    <div class="contact-info">
        <span><i class="fas fa-envelope"></i> {{ $cv->email }}</span>
        @if($cv->phone)
            <span><i class="fas fa-phone"></i> {{ $cv->phone }}</span>
        @endif
        @if($cv->address)
            <span><i class="fas fa-map-marker-alt"></i> {{ $cv->address }}</span>
        @endif
    </div>

    <div class="cv-body">
        @if($cv->summary)
        <div class="section">
            <h3 class="section-title">Özet</h3>
            <p>{{ $cv->summary }}</p>
        </div>
        @endif

        @if($cv->experience)
        <div class="section">
            <h3 class="section-title">İş Deneyimi</h3>
            @foreach($cv->experience as $exp)
            <div class="experience-item">
                <div class="item-header">
                    <div class="item-title">{{ $exp['position'] }}</div>
                    <div class="item-date">{{ $exp['date'] }}</div>
                </div>
                <div class="item-subtitle">{{ $exp['company'] }}</div>
                @if(isset($exp['description']))
                    <p class="mt-2">{{ $exp['description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if($cv->education)
        <div class="section">
            <h3 class="section-title">Eğitim</h3>
            @foreach($cv->education as $edu)
            <div class="education-item">
                <div class="item-header">
                    <div class="item-title">{{ $edu['school'] }}</div>
                    <div class="item-date">{{ $edu['date'] }}</div>
                </div>
                <div class="item-subtitle">{{ $edu['department'] }}</div>
            </div>
            @endforeach
        </div>
        @endif

        @if($cv->skills)
        <div class="section">
            <h3 class="section-title">Yetenekler</h3>
            <div>
                @foreach($cv->skills as $skill)
                    <span class="skill-tag">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

</body>
</html>

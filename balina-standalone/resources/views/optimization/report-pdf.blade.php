<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Optimizasyon Raporu</title>
    <style>
        * {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            padding: 40px;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 10px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .result-box {
            background: #eff6ff;
            border: 1px solid #3b82f6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .result-box h3 {
            color: #1e40af;
            margin-bottom: 10px;
        }
        .winner-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            position: fixed;
            bottom: 30px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .metric {
            display: inline-block;
            background: #f3f4f6;
            padding: 5px 10px;
            border-radius: 4px;
            margin: 2px;
        }
        .metric-value {
            font-weight: bold;
            color: #3b82f6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🐋 Optimizasyon Algoritması Raporu</h1>
        <p>Oluşturulma Tarihi: {{ $generatedAt }}</p>
    </div>

    <!-- Parametreler -->
    <div class="section">
        <div class="section-title">📊 Parametreler</div>
        <table>
            <tr>
                <th>Parametre</th>
                <th>Değer</th>
            </tr>
            <tr>
                <td>Popülasyon Boyutu</td>
                <td>{{ $parameters['populationSize'] }}</td>
            </tr>
            <tr>
                <td>Maksimum İterasyon</td>
                <td>{{ $parameters['maxIterations'] }}</td>
            </tr>
            <tr>
                <td>Boyut</td>
                <td>{{ $parameters['dimension'] }}</td>
            </tr>
            <tr>
                <td>Alt Sınır</td>
                <td>{{ $parameters['lowerBound'] }}</td>
            </tr>
            <tr>
                <td>Üst Sınır</td>
                <td>{{ $parameters['upperBound'] }}</td>
            </tr>
            <tr>
                <td>Amaç Fonksiyonu</td>
                <td>{{ $parameters['objectiveFunction'] }}</td>
            </tr>
        </table>
    </div>

    <!-- Tekli Sonuçlar -->
    @if(!empty($results))
        <div class="section">
            <div class="section-title">🎯 Optimizasyon Sonuçları</div>
            <div class="result-box">
                <h3>{{ $results['algorithm'] ?? 'Algoritma' }}</h3>
                <p>
                    <span class="metric">En İyi Fitness: <span class="metric-value">{{ number_format($results['bestFitness'] ?? 0, 10) }}</span></span>
                </p>
                @if(!empty($results['bestPosition']))
                    <p style="margin-top: 10px;">
                        <strong>En İyi Pozisyon:</strong><br>
                        [{{ implode(', ', array_map(fn($v) => number_format($v, 6), $results['bestPosition'])) }}]
                    </p>
                @endif
            </div>
        </div>
    @endif

    <!-- Versus Sonuçları -->
    @if(!empty($versusResults))
        <div class="section">
            <div class="section-title">⚔️ Yarışma Sonuçları</div>
            
            @foreach($versusResults as $key => $result)
                <div class="result-box" style="{{ $winner === $key ? 'border-color: #10b981; background: #ecfdf5;' : '' }}">
                    <h3>
                        {{ $result['name'] }}
                        @if($winner === $key)
                            <span class="winner-badge">🏆 Kazanan</span>
                        @endif
                    </h3>
                    <p>
                        <span class="metric">En İyi Fitness: <span class="metric-value">{{ number_format($result['bestFitness'], 10) }}</span></span>
                        <span class="metric">Çalışma Süresi: <span class="metric-value">{{ $result['executionTime'] }} ms</span></span>
                    </p>
                </div>
            @endforeach

            @if($winner === 'tie')
                <p style="text-align: center; color: #d97706; font-weight: bold;">
                    🤝 Berabere! Her iki algoritma da aynı sonuca ulaştı.
                </p>
            @endif
        </div>
    @endif

    <!-- Yakınsama Geçmişi (İlk ve Son 10) -->
    @if(!empty($convergenceHistory))
        <div class="section">
            <div class="section-title">📈 Yakınsama Geçmişi (Özet)</div>
            <table>
                <tr>
                    <th>İterasyon</th>
                    <th>En İyi Fitness</th>
                    <th>Ortalama Fitness</th>
                </tr>
                @foreach(array_slice($convergenceHistory, 0, 5) as $row)
                    <tr>
                        <td>{{ $row['iteration'] }}</td>
                        <td>{{ number_format($row['fitness'], 8) }}</td>
                        <td>{{ isset($row['avgFitness']) ? number_format($row['avgFitness'], 8) : '-' }}</td>
                    </tr>
                @endforeach
                @if(count($convergenceHistory) > 10)
                    <tr>
                        <td colspan="3" style="text-align: center; color: #9ca3af;">... {{ count($convergenceHistory) - 10 }} satır gizlendi ...</td>
                    </tr>
                @endif
                @foreach(array_slice($convergenceHistory, -5) as $row)
                    <tr>
                        <td>{{ $row['iteration'] }}</td>
                        <td>{{ number_format($row['fitness'], 8) }}</td>
                        <td>{{ isset($row['avgFitness']) ? number_format($row['avgFitness'], 8) : '-' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <div class="footer">
        Bu rapor balina.alienes.me tarafından otomatik olarak oluşturulmuştur.<br>
        © {{ date('Y') }} Optimizasyon Dashboard
    </div>
</body>
</html>

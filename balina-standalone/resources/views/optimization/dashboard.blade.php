<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐋 Optimizasyon Algoritmaları Dashboard</title>
    <meta name="description" content="WOA, PSO, GWO ve GA algoritmalarının gerçek zamanlı karşılaştırmalı analizi - Tokat Gaziosmanpaşa Üniversitesi">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🐋</text></svg>">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js is bundled with Livewire v3, no need for separate include -->
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-dark': '#0a0f1a',
                        'slate-dark': '#0f172a',
                        'slate-card': '#1e293b',
                        'electric-blue': '#3b82f6',
                        'cyan-accent': '#06b6d4',
                        'neon-green': '#10b981',
                        'neon-orange': '#f97316',
                        'neon-silver': '#94a3b8',
                        'neon-purple': '#a855f7',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'float': 'float 3s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    
    <!-- Prism.js for Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
        
        /* Glassmorphism */
        .glass {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .glass-strong {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Neon Glow Effects */
        .neon-blue { text-shadow: 0 0 10px #3b82f6, 0 0 20px #3b82f6, 0 0 40px #3b82f6; }
        .neon-cyan { text-shadow: 0 0 10px #06b6d4, 0 0 20px #06b6d4, 0 0 40px #06b6d4; }
        .neon-green { text-shadow: 0 0 10px #10b981, 0 0 20px #10b981; }
        .neon-orange { text-shadow: 0 0 10px #f97316, 0 0 20px #f97316; }
        
        .box-glow-blue { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3), inset 0 0 20px rgba(59, 130, 246, 0.05); }
        .box-glow-cyan { box-shadow: 0 0 20px rgba(6, 182, 212, 0.3), inset 0 0 20px rgba(6, 182, 212, 0.05); }
        .box-glow-green { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        .box-glow-orange { box-shadow: 0 0 20px rgba(249, 115, 22, 0.3); }
        
        /* Gradient Backgrounds */
        .bg-gradient-mesh {
            background: 
                radial-gradient(at 40% 20%, rgba(59, 130, 246, 0.15) 0px, transparent 50%),
                radial-gradient(at 80% 80%, rgba(6, 182, 212, 0.1) 0px, transparent 50%),
                radial-gradient(at 10% 90%, rgba(168, 85, 247, 0.1) 0px, transparent 50%);
        }
        
        /* Animations */
        @keyframes glow {
            from { filter: brightness(1); }
            to { filter: brightness(1.2); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        
        .animate-pulse-ring::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 2px solid currentColor;
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Loading Spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(59, 130, 246, 0.2);
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Button Hover Effects */
        .btn-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-glow:hover::before {
            left: 100%;
        }
        
        .btn-glow:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 40px rgba(59, 130, 246, 0.4);
        }
        
        /* Card Hover */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        /* Sidebar Toggle */
        .sidebar-collapsed {
            width: 60px !important;
        }
        
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        
        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        /* Stats Card Number */
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.05em;
            line-height: 1;
        }
        
        .stat-number-lg {
            font-size: 3rem;
        }
    </style>
</head>
<body class="bg-deep-dark text-white antialiased min-h-screen bg-gradient-mesh">
    <!-- Livewire Component -->
    @livewire('optimization-dashboard')
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <!-- Prism.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-matlab.min.js"></script>
    
    <!-- Global Chart Config and Livewire Integration -->
    <script>
        // Chart.js Global Config
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.borderColor = 'rgba(148, 163, 184, 0.1)';
        Chart.defaults.font.family = 'Inter';
        
        // Wait for Livewire to be ready
        document.addEventListener('livewire:init', () => {
            console.log('🐋 Livewire initialized');
            
            // Initialize charts after DOM is ready
            initializeCharts();
            
            // Listen for Livewire events
            Livewire.on('optimization-complete', (data) => {
                console.log('✅ Optimization complete', data);
                const eventData = data[0] || data;
                updateConvergenceChart(eventData.convergence, false);
                updateScatterChart(eventData.positions, eventData.bestPosition, eventData.bounds);
            });
            
            Livewire.on('versus-complete', (data) => {
                console.log('⚔️ Versus complete', data);
                const eventData = data[0] || data;
                updateVersusChart(eventData.results);
                
                const firstAlg = Object.keys(eventData.results)[0];
                if (eventData.results[firstAlg]) {
                    updateScatterChart(
                        eventData.results[firstAlg].positions,
                        eventData.results[firstAlg].bestPosition,
                        eventData.bounds
                    );
                }
            });
            
            Livewire.on('dashboard-reset', () => {
                console.log('🔄 Dashboard reset');
                resetCharts();
            });
            
            Livewire.on('code-updated', () => {
                if (typeof Prism !== 'undefined') {
                    setTimeout(() => Prism.highlightAll(), 100);
                }
            });
        });
        
        // Sayı formatlayıcı (Bilimsel gösterim)
        function formatScientific(num, precision = 2) {
            if (num === 0) return '0';
            if (Math.abs(num) < 0.001 || Math.abs(num) > 10000) {
                return num.toExponential(precision);
            }
            return num.toFixed(precision);
        }

        // Chart instances
        let convergenceChart = null;
        let scatterChart = null;
        
        function initializeCharts() {
            const isMobile = window.innerWidth < 768;
            const tickFontSize = isMobile ? 9 : 11;
            const labelFontSize = isMobile ? 10 : 12;
            const titleFontSize = isMobile ? 12 : 14;

            // Convergence Chart
            const convCtx = document.getElementById('convergenceChart');
            if (convCtx && !convergenceChart) {
                convergenceChart = new Chart(convCtx, {
                    type: 'line',
                    data: { labels: [], datasets: [] },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: {
                            legend: { 
                                position: 'top',
                                labels: { 
                                    usePointStyle: true,
                                    padding: isMobile ? 10 : 20,
                                    font: { size: labelFontSize, weight: '500' },
                                    boxWidth: isMobile ? 8 : 40
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleFont: { size: titleFontSize, weight: '600' },
                                bodyFont: { size: labelFontSize },
                                padding: isMobile ? 8 : 12,
                                cornerRadius: 8,
                                borderColor: 'rgba(59, 130, 246, 0.3)',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += formatScientific(context.parsed.y, 4);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'logarithmic',
                                title: { display: true, text: 'Fitness (log)', font: { size: labelFontSize, weight: '500' } },
                                grid: { color: 'rgba(148, 163, 184, 0.08)' },
                                ticks: { 
                                    font: { size: tickFontSize },
                                    callback: function(value, index, values) {
                                        return formatScientific(value, 0); 
                                    }
                                }
                            },
                            x: {
                                title: { display: true, text: 'İterasyon', font: { size: labelFontSize, weight: '500' } },
                                grid: { color: 'rgba(148, 163, 184, 0.08)' },
                                ticks: { font: { size: tickFontSize } }
                            }
                        }
                    }
                });
            }
            
            // Scatter Chart
            const scatCtx = document.getElementById('scatterChart');
            if (scatCtx && !scatterChart) {
                scatterChart = new Chart(scatCtx, {
                    type: 'scatter',
                    data: { datasets: [] },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                position: 'top',
                                labels: { usePointStyle: true, padding: 15, font: { size: labelFontSize } }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                padding: 10,
                                cornerRadius: 8,
                                bodyFont: { size: labelFontSize },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.x !== null && context.parsed.y !== null) {
                                            label += `[${formatScientific(context.parsed.x, 2)}, ${formatScientific(context.parsed.y, 2)}]`;
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: { display: true, text: 'X₁', font: { size: labelFontSize, weight: '500' } },
                                grid: { color: 'rgba(148, 163, 184, 0.08)' },
                                ticks: { 
                                    font: { size: tickFontSize },
                                    callback: function(value) { return formatScientific(value, 1); }
                                }
                            },
                            y: {
                                title: { display: true, text: 'X₂', font: { size: labelFontSize, weight: '500' } },
                                grid: { color: 'rgba(148, 163, 184, 0.08)' },
                                ticks: { 
                                    font: { size: tickFontSize },
                                    callback: function(value) { return formatScientific(value, 1); }
                                }
                            }
                        }
                    }
                });
            }
        }
        
        function updateConvergenceChart(convergence, isVersus = false) {
            if (!convergenceChart || !convergence) return;
            
            const labels = convergence.map((c, i) => i + 1);
            // Logaritmik skala için 0 değerlerini minimal bir değerle değiştir
            const data = convergence.map(c => {
                let val = typeof c === 'object' ? c.fitness : c;
                return val <= 0 ? 1e-100 : val;
            });
            
            convergenceChart.data.labels = labels;
            convergenceChart.data.datasets = [{
                label: 'En İyi Fitness',
                data: data,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6
            }];
            convergenceChart.update('none');
        }
        
        function updateVersusChart(results) {
            if (!convergenceChart || !results) return;
            
            const colors = {
                woa: { border: '#3b82f6', bg: 'rgba(59, 130, 246, 0.1)', name: 'WOA 🐋' },
                pso: { border: '#f97316', bg: 'rgba(249, 115, 22, 0.1)', name: 'PSO 🔵' },
                gwo: { border: '#94a3b8', bg: 'rgba(148, 163, 184, 0.1)', name: 'GWO 🐺' },
                ga: { border: '#10b981', bg: 'rgba(16, 185, 129, 0.1)', name: 'GA 🧬' }
            };
            
            const datasets = [];
            let maxLen = 0;
            
            Object.entries(results).forEach(([key, result]) => {
                const conv = result.convergence || [];
                if (conv.length > maxLen) maxLen = conv.length;
                
                const color = colors[key] || { border: '#fff', bg: 'rgba(255,255,255,0.1)', name: key.toUpperCase() };
                
                datasets.push({
                    label: color.name,
                    data: conv.map(c => {
                        let val = typeof c === 'object' ? c.fitness : c;
                        return val <= 0 ? 1e-100 : val;
                    }),
                    borderColor: color.border,
                    backgroundColor: color.bg,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6
                });
            });
            
            convergenceChart.data.labels = Array.from({ length: maxLen }, (_, i) => i + 1);
            convergenceChart.data.datasets = datasets;
            convergenceChart.update('none');
        }
        
        function updateScatterChart(positions, bestPosition, bounds) {
            if (!scatterChart || !positions) return;
            
            const posData = positions.map(pos => ({ x: pos[0] || 0, y: pos[1] || 0 }));
            
            const datasets = [{
                label: 'Bireyler',
                data: posData,
                backgroundColor: 'rgba(6, 182, 212, 0.6)',
                borderColor: '#06b6d4',
                pointRadius: 6,
                pointHoverRadius: 10,
                pointStyle: 'circle'
            }];
            
            if (bestPosition && bestPosition.length >= 2) {
                datasets.push({
                    label: 'Global Best ⭐',
                    data: [{ x: bestPosition[0], y: bestPosition[1] }],
                    backgroundColor: '#ef4444',
                    borderColor: '#fff',
                    pointRadius: 14,
                    pointStyle: 'star',
                    pointHoverRadius: 18
                });
            }
            
            if (bounds) {
                const lb = bounds.lower[0] || -10;
                const ub = bounds.upper[0] || 10;
                scatterChart.options.scales.x.min = lb;
                scatterChart.options.scales.x.max = ub;
                scatterChart.options.scales.y.min = lb;
                scatterChart.options.scales.y.max = ub;
            }
            
            scatterChart.data.datasets = datasets;
            scatterChart.update('none');
        }
        
        function resetCharts() {
            if (convergenceChart) {
                convergenceChart.data.labels = [];
                convergenceChart.data.datasets = [];
                convergenceChart.update('none');
            }
            if (scatterChart) {
                scatterChart.data.datasets = [];
                scatterChart.update('none');
            }
        }
        
        // Copy code function
        function copyCode() {
            const code = document.getElementById('codeBlock')?.innerText;
            if (code) {
                navigator.clipboard.writeText(code).then(() => {
                    const btn = document.getElementById('copyBtn');
                    if (btn) {
                        btn.innerText = '✓ Kopyalandı!';
                        setTimeout(() => btn.innerText = '📋 Kopyala', 2000);
                    }
                });
            }
        }
        
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('sidebar-collapsed');
            }
        }

    </script>
</body>
</html>

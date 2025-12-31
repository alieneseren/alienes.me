// Game Authentication & Leaderboard System
class GameAuth {
    constructor(gameName) {
        this.gameName = gameName;
        this.username = localStorage.getItem('game_username');
        // Subdomain'den ana domain API'sine erişim için
        this.apiBase = 'https://alienes.me';
    }

    // Kullanıcı giriş kontrolü
    checkAuth() {
        if (!this.username) {
            this.showLoginModal();
            return false;
        }
        return true;
    }

    // Giriş modalını göster
    showLoginModal() {
        const modal = document.createElement('div');
        modal.id = 'authModal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        `;

        modal.innerHTML = `
            <div style="background: white; padding: 40px; border-radius: 20px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                <h2 style="color: #667eea; margin-bottom: 10px; font-size: 2em; text-align: center;">🎮 Oyuna Hoş Geldin!</h2>
                <p style="color: #666; margin-bottom: 30px; text-align: center;">Skorunu kaydetmek için kullanıcı adını gir</p>
                
                <input type="text" 
                       id="usernameInput" 
                       placeholder="Kullanıcı adın" 
                       maxlength="50"
                       style="width: 100%; padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1em; margin-bottom: 20px; box-sizing: border-box;"
                       autocomplete="off">
                
                <button onclick="gameAuth.login()" 
                        style="width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 10px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: opacity 0.3s;"
                        onmouseover="this.style.opacity='0.9'" 
                        onmouseout="this.style.opacity='1'">
                    🚀 Başla
                </button>
                
                <p style="color: #999; font-size: 0.85em; margin-top: 20px; text-align: center;">
                    Skorun skor tablosunda görünecek
                </p>
            </div>
        `;

        document.body.appendChild(modal);
        document.getElementById('usernameInput').focus();

        // Enter tuşu ile giriş
        document.getElementById('usernameInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.login();
            }
        });
    }

    // Giriş yap
    login() {
        const input = document.getElementById('usernameInput');
        const username = input.value.trim();

        if (!username || username.length < 2) {
            input.style.borderColor = 'red';
            input.placeholder = 'En az 2 karakter!';
            return;
        }

        // Özel karakterleri temizle
        const cleanUsername = username.replace(/[^a-zA-Z0-9ğüşıöçĞÜŞİÖÇ_-]/g, '');

        this.username = cleanUsername;
        localStorage.setItem('game_username', cleanUsername);

        const modal = document.getElementById('authModal');
        if (modal) {
            modal.remove();
        }

        // Oyunu başlat
        if (typeof startGameCallback === 'function') {
            startGameCallback();
        }
    }

    // Skoru kaydet
    async saveScore(score, extraData = {}) {
        if (!this.username) return;

        try {
            const response = await fetch(`${this.apiBase}/api/games/score`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    username: this.username,
                    game_name: this.gameName,
                    score: score,
                    ...extraData
                })
            });

            const data = await response.json();

            if (data.success) {
                this.showScoreModal(score, data.leaderboard);
            }

            return data;
        } catch (error) {
            console.error('Skor kaydedilemedi:', error);
        }
    }

    // Skor modalını göster
    showScoreModal(score, leaderboard) {
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            animation: fadeIn 0.3s;
        `;

        const rank = leaderboard.findIndex(s => s.username === this.username && s.score === score) + 1;
        const isTopTen = rank > 0 && rank <= 10;

        modal.innerHTML = `
            <div style="background: white; padding: 40px; border-radius: 20px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center;">
                <div style="font-size: 5em; margin-bottom: 20px;">${isTopTen ? '🏆' : '🎮'}</div>
                <h2 style="color: #667eea; margin-bottom: 10px; font-size: 2.5em;">Oyun Bitti!</h2>
                <p style="color: #666; margin-bottom: 20px;">Skorun: <strong style="color: #764ba2; font-size: 1.5em;">${score}</strong></p>
                
                ${isTopTen ? `
                    <div style="background: linear-gradient(135deg, #ffd700, #ffed4e); padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <p style="color: #856404; font-weight: bold; font-size: 1.2em;">🎉 ${rank}. sıradasın!</p>
                    </div>
                ` : ''}
                
                <div style="max-height: 300px; overflow-y: auto; background: #f5f5f5; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h3 style="color: #333; margin-bottom: 15px;">🏆 Skor Tablosu</h3>
                    ${this.generateLeaderboardHTML(leaderboard)}
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button onclick="location.reload()" 
                            style="flex: 1; padding: 15px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 10px; font-size: 1em; font-weight: bold; cursor: pointer;">
                        🔄 Tekrar Oyna
                    </button>
                    <button onclick="window.location.href='https://games.alienes.me'" 
                            style="flex: 1; padding: 15px; background: #e0e0e0; color: #333; border: none; border-radius: 10px; font-size: 1em; font-weight: bold; cursor: pointer;">
                        ← Geri Dön
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
    }

    // Liderlik tablosunu göster (Manuel)
    async showLeaderboard() {
        const leaderboard = await this.getLeaderboard();

        const modal = document.createElement('div');
        modal.id = 'leaderboardModal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            animation: fadeIn 0.3s;
        `;

        modal.innerHTML = `
            <div style="background: white; padding: 40px; border-radius: 20px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center; position: relative;">
                <button onclick="document.getElementById('leaderboardModal').remove()" 
                        style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 1.5em; cursor: pointer; color: #666;">
                    ✕
                </button>
                <h2 style="color: #667eea; margin-bottom: 20px; font-size: 2em;">🏆 Liderlik Tablosu</h2>
                
                <div style="max-height: 400px; overflow-y: auto; background: #f5f5f5; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    ${this.generateLeaderboardHTML(leaderboard)}
                </div>
            </div>
        `;

        document.body.appendChild(modal);
    }

    // Liderlik tablosu HTML'i oluştur
    generateLeaderboardHTML(leaderboard) {
        if (!leaderboard || leaderboard.length === 0) {
            return '<p style="color: #999;">Henüz skor yok</p>';
        }

        return leaderboard.map((item, index) => {
            const isCurrentUser = item.username === this.username;
            const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : '';

            return `
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: ${isCurrentUser ? '#fff3cd' : 'white'}; border-radius: 8px; margin-bottom: 8px; ${isCurrentUser ? 'border: 2px solid #ffc107;' : ''}">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: bold; color: #999; min-width: 30px;">${medal || (index + 1 + '.')}</span>
                        <span style="font-weight: ${isCurrentUser ? 'bold' : 'normal'}; color: ${isCurrentUser ? '#856404' : '#333'};">${item.username}</span>
                    </div>
                    <span style="font-weight: bold; color: #667eea;">${item.score}</span>
                </div>
            `;
        }).join('');
    }

    // Liderlik tablosunu getir
    async getLeaderboard(limit = 10) {
        try {
            const response = await fetch(`${this.apiBase}/api/games/leaderboard/${this.gameName}?limit=${limit}`);
            const data = await response.json();
            return data.scores || [];
        } catch (error) {
            console.error('Liderlik tablosu alınamadı:', error);
            return [];
        }
    }

    // Kullanıcı adını değiştir
    changeUsername() {
        localStorage.removeItem('game_username');
        this.username = null;
        location.reload();
    }

    // Kullanıcı bilgilerini göster
    showUserInfo() {
        if (!this.username) return '';

        return `
            <div style="position: fixed; top: 20px; right: 20px; background: white; padding: 10px 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 9999;">
                <span style="color: #667eea; font-weight: bold;">👤 ${this.username}</span>
                <button onclick="gameAuth.changeUsername()" 
                        style="margin-left: 10px; padding: 5px 10px; background: #f0f0f0; border: none; border-radius: 5px; cursor: pointer; font-size: 0.85em;">
                    Değiştir
                </button>
            </div>
        `;
    }
}

// CSS Animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
`;
document.head.appendChild(style);

#!/usr/bin/env python3
"""
alienes.me Ziyaretçi Takip Uygulaması
Gerçek zamanlı web sitesi ziyaretçi izleme aracı
"""

import tkinter as tk
from tkinter import ttk, messagebox
import threading
import requests
import json
from datetime import datetime
import time
from collections import deque

# API Ayarları
API_BASE_URL = "https://alienes.me/api/visitor-count"
REFRESH_INTERVAL = 5000  # 5 saniye (milisaniye)

class VisitorMonitorApp:
    def __init__(self, root):
        self.root = root
        self.root.title("alienes.me Ziyaretçi Takip")
        self.root.geometry("900x700")
        self.root.configure(bg="#1a1a2e")
        
        # Veri depolama
        self.recent_logs = deque(maxlen=100)
        self.is_running = True
        
        # Stil ayarları
        self.setup_styles()
        
        # Ana frame
        self.main_frame = tk.Frame(root, bg="#1a1a2e")
        self.main_frame.pack(fill=tk.BOTH, expand=True, padx=10, pady=10)
        
        # Üst bilgi paneli
        self.create_header()
        
        # İstatistik kartları
        self.create_stats_cards()
        
        # Aktif ziyaretçiler ve loglar
        self.create_visitors_section()
        
        # Alt durum çubuğu
        self.create_status_bar()
        
        # İlk veri yüklemesi
        self.update_data()
        
        # Pencere kapatma olayı
        self.root.protocol("WM_DELETE_WINDOW", self.on_closing)
    
    def setup_styles(self):
        """Tkinter stilleri ayarla"""
        style = ttk.Style()
        style.theme_use('clam')
        
        # Treeview stilleri
        style.configure("Custom.Treeview",
            background="#16213e",
            foreground="#e8e8e8",
            fieldbackground="#16213e",
            rowheight=28
        )
        style.configure("Custom.Treeview.Heading",
            background="#0f3460",
            foreground="#e94560",
            font=('Helvetica', 10, 'bold')
        )
        style.map("Custom.Treeview",
            background=[('selected', '#0f3460')],
            foreground=[('selected', '#ffffff')]
        )
    
    def create_header(self):
        """Başlık paneli"""
        header_frame = tk.Frame(self.main_frame, bg="#16213e", height=60)
        header_frame.pack(fill=tk.X, pady=(0, 10))
        header_frame.pack_propagate(False)
        
        # Logo/Başlık
        title_label = tk.Label(
            header_frame,
            text="🌐 alienes.me Ziyaretçi Takip",
            font=("Helvetica", 18, "bold"),
            fg="#e94560",
            bg="#16213e"
        )
        title_label.pack(side=tk.LEFT, padx=20, pady=15)
        
        # Bağlantı durumu
        self.connection_label = tk.Label(
            header_frame,
            text="● Bağlanıyor...",
            font=("Helvetica", 11),
            fg="#ffc107",
            bg="#16213e"
        )
        self.connection_label.pack(side=tk.RIGHT, padx=20, pady=15)
    
    def create_stats_cards(self):
        """İstatistik kartları"""
        cards_frame = tk.Frame(self.main_frame, bg="#1a1a2e")
        cards_frame.pack(fill=tk.X, pady=(0, 10))
        
        # Kartlar için grid
        for i in range(4):
            cards_frame.columnconfigure(i, weight=1)
        
        # Kart verileri
        self.stats = {
            'today': {'label': "Bugün", 'value': tk.StringVar(value="0"), 'icon': "📊"},
            'active': {'label': "Anlık Aktif", 'value': tk.StringVar(value="0"), 'icon': "👥"},
            'week': {'label': "Son 7 Gün", 'value': tk.StringVar(value="0"), 'icon': "📈"},
            'change': {'label': "Değişim", 'value': tk.StringVar(value="0%"), 'icon': "📉"}
        }
        
        col = 0
        for key, data in self.stats.items():
            card = self.create_stat_card(cards_frame, data['icon'], data['label'], data['value'])
            card.grid(row=0, column=col, padx=5, sticky="nsew")
            col += 1
    
    def create_stat_card(self, parent, icon, label, value_var):
        """Tek bir istatistik kartı oluştur"""
        card = tk.Frame(parent, bg="#16213e", relief="flat", bd=0)
        card.configure(highlightbackground="#0f3460", highlightthickness=1)
        
        # İkon
        icon_label = tk.Label(card, text=icon, font=("Helvetica", 24), fg="#e94560", bg="#16213e")
        icon_label.pack(pady=(15, 5))
        
        # Değer
        value_label = tk.Label(card, textvariable=value_var, font=("Helvetica", 28, "bold"), fg="#ffffff", bg="#16213e")
        value_label.pack()
        
        # Etiket
        label_text = tk.Label(card, text=label, font=("Helvetica", 11), fg="#888888", bg="#16213e")
        label_text.pack(pady=(5, 15))
        
        return card
    
    def create_visitors_section(self):
        """Aktif ziyaretçiler ve log bölümü"""
        # Notebook (sekmeli panel)
        notebook_frame = tk.Frame(self.main_frame, bg="#1a1a2e")
        notebook_frame.pack(fill=tk.BOTH, expand=True, pady=(0, 10))
        
        # Sol panel - Aktif Ziyaretçiler
        left_frame = tk.Frame(notebook_frame, bg="#16213e")
        left_frame.pack(side=tk.LEFT, fill=tk.BOTH, expand=True, padx=(0, 5))
        
        left_title = tk.Label(
            left_frame,
            text="👥 Anlık Aktif Ziyaretçiler",
            font=("Helvetica", 12, "bold"),
            fg="#e94560",
            bg="#16213e"
        )
        left_title.pack(anchor="w", padx=10, pady=10)
        
        # Aktif ziyaretçi tablosu
        active_columns = ("Sayfa", "Cihaz", "Tarayıcı", "Ülke", "Son Görülme")
        self.active_tree = ttk.Treeview(
            left_frame,
            columns=active_columns,
            show="headings",
            style="Custom.Treeview"
        )
        
        for col in active_columns:
            self.active_tree.heading(col, text=col)
            self.active_tree.column(col, width=100, minwidth=80)
        
        self.active_tree.pack(fill=tk.BOTH, expand=True, padx=10, pady=(0, 10))
        
        # Sağ panel - Son Aktiviteler
        right_frame = tk.Frame(notebook_frame, bg="#16213e")
        right_frame.pack(side=tk.RIGHT, fill=tk.BOTH, expand=True, padx=(5, 0))
        
        right_title = tk.Label(
            right_frame,
            text="📋 Son Aktiviteler",
            font=("Helvetica", 12, "bold"),
            fg="#e94560",
            bg="#16213e"
        )
        right_title.pack(anchor="w", padx=10, pady=10)
        
        # Log tablosu
        log_columns = ("Zaman", "Sayfa", "Cihaz", "OS", "Ülke")
        self.log_tree = ttk.Treeview(
            right_frame,
            columns=log_columns,
            show="headings",
            style="Custom.Treeview"
        )
        
        for col in log_columns:
            self.log_tree.heading(col, text=col)
            self.log_tree.column(col, width=90, minwidth=70)
        
        self.log_tree.pack(fill=tk.BOTH, expand=True, padx=10, pady=(0, 10))
    
    def create_status_bar(self):
        """Alt durum çubuğu"""
        status_frame = tk.Frame(self.main_frame, bg="#0f3460", height=30)
        status_frame.pack(fill=tk.X)
        status_frame.pack_propagate(False)
        
        self.status_label = tk.Label(
            status_frame,
            text="Son güncelleme: -",
            font=("Helvetica", 9),
            fg="#888888",
            bg="#0f3460"
        )
        self.status_label.pack(side=tk.LEFT, padx=10, pady=5)
        
        self.api_label = tk.Label(
            status_frame,
            text=f"API: {API_BASE_URL}",
            font=("Helvetica", 9),
            fg="#888888",
            bg="#0f3460"
        )
        self.api_label.pack(side=tk.RIGHT, padx=10, pady=5)
    
    def update_data(self):
        """API'den veri çek ve güncelle"""
        if not self.is_running:
            return
        
        # Arka planda veri çekme
        thread = threading.Thread(target=self.fetch_data, daemon=True)
        thread.start()
        
        # Sonraki güncellemeyi planla
        self.root.after(REFRESH_INTERVAL, self.update_data)
    
    def fetch_data(self):
        """API'den veri çek"""
        try:
            # Dashboard verisi
            response = requests.get(f"{API_BASE_URL}/dashboard", timeout=10)
            
            if response.status_code == 200:
                data = response.json()
                self.root.after(0, lambda: self.update_ui(data))
                self.root.after(0, lambda: self.set_connection_status(True))
            else:
                self.root.after(0, lambda: self.set_connection_status(False, f"HTTP {response.status_code}"))
        
        except requests.exceptions.Timeout:
            self.root.after(0, lambda: self.set_connection_status(False, "Zaman aşımı"))
        except requests.exceptions.ConnectionError:
            self.root.after(0, lambda: self.set_connection_status(False, "Bağlantı hatası"))
        except Exception as e:
            self.root.after(0, lambda: self.set_connection_status(False, str(e)[:30]))
    
    def update_ui(self, data):
        """Arayüzü güncelle"""
        try:
            summary = data.get('summary', {})
            
            # İstatistik kartlarını güncelle
            self.stats['today']['value'].set(str(summary.get('today', 0)))
            self.stats['active']['value'].set(str(summary.get('active_now', 0)))
            self.stats['week']['value'].set(str(summary.get('total_week', 0)))
            
            change = summary.get('change_percent', 0)
            change_str = f"+{change}%" if change >= 0 else f"{change}%"
            self.stats['change']['value'].set(change_str)
            
            # Aktif ziyaretçiler tablosunu güncelle
            self.active_tree.delete(*self.active_tree.get_children())
            for visitor in data.get('active_visitors', []):
                self.active_tree.insert('', 'end', values=(
                    visitor.get('page', '-')[:30],
                    visitor.get('device', '-'),
                    visitor.get('browser', '-'),
                    visitor.get('country', '-'),
                    visitor.get('last_seen', '-')
                ))
            
            # Log tablosunu güncelle (logs endpoint'inden çek)
            self.fetch_logs()
            
            # Son güncelleme zamanı
            now = datetime.now().strftime("%H:%M:%S")
            self.status_label.config(text=f"Son güncelleme: {now}")
            
        except Exception as e:
            print(f"UI güncelleme hatası: {e}")
    
    def fetch_logs(self):
        """Son logları çek"""
        try:
            response = requests.get(f"{API_BASE_URL}/logs?limit=30", timeout=5)
            
            if response.status_code == 200:
                data = response.json()
                logs = data.get('logs', [])
                
                # Log tablosunu güncelle
                self.log_tree.delete(*self.log_tree.get_children())
                for log in logs:
                    # Zamanı formatla
                    time_str = log.get('time_ago', '-')
                    
                    self.log_tree.insert('', 'end', values=(
                        time_str,
                        log.get('page', '-')[:25],
                        log.get('device', '-'),
                        log.get('os', '-'),
                        log.get('country', '-')
                    ))
        except Exception as e:
            print(f"Log çekme hatası: {e}")
    
    def set_connection_status(self, connected, error_msg=None):
        """Bağlantı durumunu güncelle"""
        if connected:
            self.connection_label.config(text="● Bağlı", fg="#28a745")
        else:
            msg = f"● Bağlantı Yok ({error_msg})" if error_msg else "● Bağlantı Yok"
            self.connection_label.config(text=msg, fg="#dc3545")
    
    def on_closing(self):
        """Pencere kapatılırken"""
        self.is_running = False
        self.root.destroy()


class SSEMonitor:
    """Server-Sent Events ile gerçek zamanlı izleme (opsiyonel)"""
    
    def __init__(self, callback):
        self.callback = callback
        self.running = False
    
    def start(self):
        """SSE bağlantısını başlat"""
        self.running = True
        thread = threading.Thread(target=self._listen, daemon=True)
        thread.start()
    
    def stop(self):
        """SSE bağlantısını durdur"""
        self.running = False
    
    def _listen(self):
        """SSE olaylarını dinle"""
        try:
            import sseclient
            
            response = requests.get(f"{API_BASE_URL}/stream", stream=True)
            client = sseclient.SSEClient(response)
            
            for event in client.events():
                if not self.running:
                    break
                
                try:
                    data = json.loads(event.data)
                    self.callback(data)
                except json.JSONDecodeError:
                    pass
        
        except Exception as e:
            print(f"SSE hatası: {e}")


def main():
    """Ana fonksiyon"""
    root = tk.Tk()
    
    # Pencere simgesi (opsiyonel)
    try:
        root.iconbitmap("icon.ico")
    except:
        pass
    
    # Minimum boyut
    root.minsize(800, 600)
    
    # Uygulamayı başlat
    app = VisitorMonitorApp(root)
    root.mainloop()


if __name__ == "__main__":
    main()

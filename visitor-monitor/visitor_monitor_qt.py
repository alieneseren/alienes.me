#!/usr/bin/env python3
"""
alienes.me Ziyaretçi Takip Uygulaması (PyQt6)
Gerçek zamanlı web sitesi ziyaretçi izleme aracı
"""

import sys
import json
import requests
from datetime import datetime
from PyQt6.QtWidgets import (
    QApplication, QMainWindow, QWidget, QVBoxLayout, QHBoxLayout,
    QLabel, QTableWidget, QTableWidgetItem, QHeaderView, QFrame,
    QSplitter, QStatusBar, QGroupBox
)
from PyQt6.QtCore import Qt, QTimer, QThread, pyqtSignal
from PyQt6.QtGui import QFont, QColor, QPalette

# API Ayarları
API_BASE_URL = "https://alienes.me/api/visitor-count"
REFRESH_INTERVAL = 5000  # 5 saniye


class DataFetcher(QThread):
    """Arka planda API'den veri çeken thread"""
    data_ready = pyqtSignal(dict)
    logs_ready = pyqtSignal(dict)
    error_occurred = pyqtSignal(str)

    def run(self):
        try:
            # Dashboard verisi
            response = requests.get(f"{API_BASE_URL}/dashboard", timeout=10)
            if response.status_code == 200:
                self.data_ready.emit(response.json())
            else:
                self.error_occurred.emit(f"HTTP {response.status_code}")
                return

            # Loglar
            logs_response = requests.get(f"{API_BASE_URL}/logs?limit=30", timeout=10)
            if logs_response.status_code == 200:
                self.logs_ready.emit(logs_response.json())

        except requests.exceptions.Timeout:
            self.error_occurred.emit("Zaman aşımı")
        except requests.exceptions.ConnectionError:
            self.error_occurred.emit("Bağlantı hatası")
        except Exception as e:
            self.error_occurred.emit(str(e)[:30])


class StatCard(QFrame):
    """İstatistik kartı widget'ı"""

    def __init__(self, icon: str, label: str, parent=None):
        super().__init__(parent)
        self.setStyleSheet("""
            StatCard {
                background-color: #16213e;
                border-radius: 10px;
                border: 1px solid #0f3460;
            }
        """)
        self.setMinimumHeight(120)
        self.setMinimumWidth(180)

        layout = QVBoxLayout(self)
        layout.setAlignment(Qt.AlignmentFlag.AlignCenter)

        # İkon
        self.icon_label = QLabel(icon)
        self.icon_label.setFont(QFont("Segoe UI Emoji", 28))
        self.icon_label.setAlignment(Qt.AlignmentFlag.AlignCenter)
        self.icon_label.setStyleSheet("color: #e94560;")
        layout.addWidget(self.icon_label)

        # Değer
        self.value_label = QLabel("0")
        self.value_label.setFont(QFont("Arial", 32, QFont.Weight.Bold))
        self.value_label.setAlignment(Qt.AlignmentFlag.AlignCenter)
        self.value_label.setStyleSheet("color: white;")
        layout.addWidget(self.value_label)

        # Etiket
        self.label_text = QLabel(label)
        self.label_text.setFont(QFont("Arial", 11))
        self.label_text.setAlignment(Qt.AlignmentFlag.AlignCenter)
        self.label_text.setStyleSheet("color: #888888;")
        layout.addWidget(self.label_text)

    def set_value(self, value):
        self.value_label.setText(str(value))


class VisitorMonitorApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.setWindowTitle("🌐 alienes.me Ziyaretçi Takip")
        self.setMinimumSize(1000, 700)
        self.setup_ui()
        self.setup_timer()

    def setup_ui(self):
        """Arayüzü oluştur"""
        # Koyu tema
        self.setStyleSheet("""
            QMainWindow {
                background-color: #1a1a2e;
            }
            QLabel {
                color: white;
            }
            QTableWidget {
                background-color: #16213e;
                color: #e8e8e8;
                border: 1px solid #0f3460;
                gridline-color: #0f3460;
            }
            QTableWidget::item {
                padding: 5px;
            }
            QTableWidget::item:selected {
                background-color: #0f3460;
            }
            QHeaderView::section {
                background-color: #0f3460;
                color: #e94560;
                font-weight: bold;
                padding: 8px;
                border: none;
            }
            QStatusBar {
                background-color: #0f3460;
                color: #888888;
            }
            QGroupBox {
                color: #e94560;
                font-weight: bold;
                border: 1px solid #0f3460;
                border-radius: 5px;
                margin-top: 10px;
                padding-top: 10px;
            }
            QGroupBox::title {
                subcontrol-origin: margin;
                left: 10px;
                padding: 0 5px;
            }
        """)

        central_widget = QWidget()
        self.setCentralWidget(central_widget)
        main_layout = QVBoxLayout(central_widget)
        main_layout.setContentsMargins(15, 15, 15, 15)
        main_layout.setSpacing(15)

        # Başlık
        header_layout = QHBoxLayout()
        
        title_label = QLabel("🌐 alienes.me Ziyaretçi Takip")
        title_label.setFont(QFont("Arial", 20, QFont.Weight.Bold))
        title_label.setStyleSheet("color: #e94560;")
        header_layout.addWidget(title_label)

        header_layout.addStretch()

        self.connection_label = QLabel("● Bağlanıyor...")
        self.connection_label.setFont(QFont("Arial", 12))
        self.connection_label.setStyleSheet("color: #ffc107;")
        header_layout.addWidget(self.connection_label)

        main_layout.addLayout(header_layout)

        # İstatistik kartları
        cards_layout = QHBoxLayout()
        cards_layout.setSpacing(10)

        self.today_card = StatCard("📊", "Bugün")
        self.active_card = StatCard("👥", "Anlık Aktif")
        self.week_card = StatCard("📈", "Son 7 Gün")
        self.change_card = StatCard("📉", "Değişim")

        cards_layout.addWidget(self.today_card)
        cards_layout.addWidget(self.active_card)
        cards_layout.addWidget(self.week_card)
        cards_layout.addWidget(self.change_card)

        main_layout.addLayout(cards_layout)

        # Tablolar için splitter
        splitter = QSplitter(Qt.Orientation.Horizontal)

        # Aktif ziyaretçiler tablosu
        active_group = QGroupBox("👥 Anlık Aktif Ziyaretçiler")
        active_layout = QVBoxLayout(active_group)

        self.active_table = QTableWidget()
        self.active_table.setColumnCount(6)
        self.active_table.setHorizontalHeaderLabels(["Site", "Sayfa", "Cihaz", "Tarayıcı", "Ülke", "Son Görülme"])
        self.active_table.horizontalHeader().setSectionResizeMode(QHeaderView.ResizeMode.Stretch)
        self.active_table.setSelectionBehavior(QTableWidget.SelectionBehavior.SelectRows)
        self.active_table.setEditTriggers(QTableWidget.EditTrigger.NoEditTriggers)
        active_layout.addWidget(self.active_table)

        splitter.addWidget(active_group)

        # Son aktiviteler tablosu
        logs_group = QGroupBox("📋 Son Aktiviteler")
        logs_layout = QVBoxLayout(logs_group)

        self.logs_table = QTableWidget()
        self.logs_table.setColumnCount(6)
        self.logs_table.setHorizontalHeaderLabels(["Zaman", "Site", "Sayfa", "Cihaz", "OS", "Ülke"])
        self.logs_table.horizontalHeader().setSectionResizeMode(QHeaderView.ResizeMode.Stretch)
        self.logs_table.setSelectionBehavior(QTableWidget.SelectionBehavior.SelectRows)
        self.logs_table.setEditTriggers(QTableWidget.EditTrigger.NoEditTriggers)
        logs_layout.addWidget(self.logs_table)

        splitter.addWidget(logs_group)

        main_layout.addWidget(splitter, 1)

        # Durum çubuğu
        self.status_bar = QStatusBar()
        self.setStatusBar(self.status_bar)
        self.status_bar.showMessage(f"API: {API_BASE_URL}")

        self.update_label = QLabel("Son güncelleme: -")
        self.status_bar.addPermanentWidget(self.update_label)

    def setup_timer(self):
        """Zamanlayıcıyı ayarla"""
        self.timer = QTimer()
        self.timer.timeout.connect(self.fetch_data)
        self.timer.start(REFRESH_INTERVAL)

        # İlk yükleme
        self.fetch_data()

    def fetch_data(self):
        """API'den veri çek"""
        self.fetcher = DataFetcher()
        self.fetcher.data_ready.connect(self.update_dashboard)
        self.fetcher.logs_ready.connect(self.update_logs)
        self.fetcher.error_occurred.connect(self.handle_error)
        self.fetcher.start()

    def update_dashboard(self, data: dict):
        """Dashboard verilerini güncelle"""
        try:
            summary = data.get('summary', {})

            # Kartları güncelle
            self.today_card.set_value(summary.get('today', 0))
            self.active_card.set_value(summary.get('active_now', 0))
            self.week_card.set_value(summary.get('total_week', 0))

            change = summary.get('change_percent', 0)
            change_str = f"+{change}%" if change >= 0 else f"{change}%"
            self.change_card.set_value(change_str)

            # Aktif ziyaretçiler tablosu
            active_visitors = data.get('active_visitors', [])
            self.active_table.setRowCount(len(active_visitors))

            for row, visitor in enumerate(active_visitors):
                subdomain = visitor.get('subdomain') or 'ana-site'
                self.active_table.setItem(row, 0, QTableWidgetItem(subdomain))
                self.active_table.setItem(row, 1, QTableWidgetItem(visitor.get('page', '-')[:30]))
                self.active_table.setItem(row, 2, QTableWidgetItem(visitor.get('device', '-')))
                self.active_table.setItem(row, 3, QTableWidgetItem(visitor.get('browser', '-')))
                self.active_table.setItem(row, 4, QTableWidgetItem(visitor.get('country', '-')))
                self.active_table.setItem(row, 5, QTableWidgetItem(visitor.get('last_seen', '-')))

            # Bağlantı durumu
            self.connection_label.setText("● Bağlı")
            self.connection_label.setStyleSheet("color: #28a745;")

            # Son güncelleme
            now = datetime.now().strftime("%H:%M:%S")
            self.update_label.setText(f"Son güncelleme: {now}")

        except Exception as e:
            print(f"Dashboard güncelleme hatası: {e}")

    def update_logs(self, data: dict):
        """Log tablosunu güncelle"""
        try:
            logs = data.get('logs', [])
            self.logs_table.setRowCount(len(logs))

            for row, log in enumerate(logs):
                subdomain = log.get('subdomain') or 'ana-site'
                self.logs_table.setItem(row, 0, QTableWidgetItem(log.get('time_ago', '-')))
                self.logs_table.setItem(row, 1, QTableWidgetItem(subdomain))
                self.logs_table.setItem(row, 2, QTableWidgetItem(log.get('page', '-')[:25]))
                self.logs_table.setItem(row, 3, QTableWidgetItem(log.get('device', '-')))
                self.logs_table.setItem(row, 4, QTableWidgetItem(log.get('os', '-')))
                self.logs_table.setItem(row, 5, QTableWidgetItem(log.get('country', '-')))

        except Exception as e:
            print(f"Log güncelleme hatası: {e}")

    def handle_error(self, error_msg: str):
        """Hata durumunu işle"""
        self.connection_label.setText(f"● Bağlantı Yok ({error_msg})")
        self.connection_label.setStyleSheet("color: #dc3545;")


def main():
    app = QApplication(sys.argv)
    
    # Uygulama bilgileri
    app.setApplicationName("alienes.me Ziyaretçi Takip")
    app.setOrganizationName("alienes")
    
    window = VisitorMonitorApp()
    window.show()
    
    sys.exit(app.exec())


if __name__ == "__main__":
    main()

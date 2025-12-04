# Laravel Kategori ve Etiketleme Sistemi - İş Analizi Programı

## 🎯 Proje Tanımı

Performance Agent uygulamasından gelen aktivite verilerini (process_name ve title alanlarına göre) otomatik olarak kategorilere tagleyen bir Laravel iş analizi sistemi.

## 📋 Sistem Gereksinimleri

### 1. Mevcut Activities Tablosu Yapısı (Performance Agent)

**ÖNEMLİ:** Laravel projesi, Performance Agent'ın ürettiği `activities` tablosunu kullanacaktır. Bu tablo zaten mevcut ve şu yapıya sahiptir:

```sql
CREATE TABLE IF NOT EXISTS activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evt VARCHAR(50) NOT NULL DEFAULT 'activity',
    activity_type VARCHAR(50) NOT NULL DEFAULT 'window',
    process_name VARCHAR(255) NOT NULL,
    title TEXT NULL,
    start_time_utc DATETIME NOT NULL,
    end_time_utc DATETIME NOT NULL,
    duration_ms BIGINT NOT NULL,
    username VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    user_sid VARCHAR(255) NOT NULL DEFAULT '',
    motherboard_uuid VARCHAR(255) NOT NULL DEFAULT '',
    url TEXT NULL,
    browser VARCHAR(100) NULL,
    base_url VARCHAR(512) NULL,
    created_at_utc DATETIME NOT NULL,
    received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_activity_type (activity_type),
    INDEX idx_process_name (process_name),
    INDEX idx_start_time (start_time_utc),
    INDEX idx_username (username),
    INDEX idx_browser (browser),
    INDEX idx_base_url (base_url),
    INDEX idx_user_sid (user_sid),
    INDEX idx_motherboard_uuid (motherboard_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### Activities Tablosu Alan Detayları

| Alan Adı | Tip | Null | Default | Açıklama | Kullanım |
|----------|-----|------|---------|----------|----------|
| **id** | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key, benzersiz kayıt ID'si | Her aktivite için otomatik artan benzersiz ID |
| **evt** | VARCHAR(50) | NO | 'activity' | Event tipi | Genellikle 'activity' değeri. Sistem durumu için 'system_state' olabilir |
| **activity_type** | VARCHAR(50) | NO | 'window' | Aktivite tipi | 'window' (pencere aktivitesi) veya 'browser' (tarayıcı aktivitesi) |
| **process_name** | VARCHAR(255) | NO | - | Process/uygulama adı | Örn: 'chrome.exe', 'Code.exe', 'notepad.exe'. **Tagleme için kullanılacak ana alanlardan biri** |
| **title** | TEXT | YES | NULL | Pencere başlığı veya sayfa başlığı | Window için: pencere başlığı (örn: "Document - Notepad"). Browser için: sayfa başlığı (örn: "Google"). **Tagleme için kullanılacak ana alanlardan biri** |
| **start_time_utc** | DATETIME | NO | - | Aktivitenin başlangıç zamanı (UTC) | Aktivitenin ne zaman başladığı |
| **end_time_utc** | DATETIME | NO | - | Aktivitenin bitiş zamanı (UTC) | Aktivitenin ne zaman bittiği |
| **duration_ms** | BIGINT | NO | - | Aktivite süresi (milisaniye) | start_time_utc ile end_time_utc arasındaki fark |
| **username** | VARCHAR(255) | NO | - | Windows kullanıcı adı | Aktiviteyi yapan kullanıcının adı (örn: 'JohnDoe') |
| **domain** | VARCHAR(255) | NO | - | Domain adı | Kullanıcının domain'i (örn: 'DESKTOP', 'COMPANY') |
| **user_sid** | VARCHAR(255) | NO | '' | User Security Identifier | Windows kullanıcı tanımlayıcısı (örn: 'S-1-5-21-...') |
| **motherboard_uuid** | VARCHAR(255) | NO | '' | Motherboard UUID | Donanım tanımlayıcısı, cihaz kimliği için |
| **url** | TEXT | YES | NULL | Tam URL | Browser aktiviteleri için tam URL (örn: 'https://www.google.com/search?q=test'). Window aktiviteleri için genellikle NULL |
| **browser** | VARCHAR(100) | YES | NULL | Tarayıcı adı | Browser aktiviteleri için tarayıcı adı (örn: 'Chrome', 'Edge', 'Firefox'). Window aktiviteleri için NULL |
| **base_url** | VARCHAR(512) | YES | NULL | Base URL (protokol + domain) | URL'nin sadece domain kısmı (örn: 'https://www.google.com'). Hem window hem browser aktiviteleri için kullanılabilir |
| **created_at_utc** | DATETIME | NO | - | Kaydın oluşturulma zamanı (UTC) | Performance Agent tarafından oluşturulma zamanı |
| **received_at** | TIMESTAMP | NO | CURRENT_TIMESTAMP | MySQL'e alınma zamanı | Veritabanına insert edildiği zaman, otomatik olarak set edilir |

#### Activities Tablosu Kullanım Notları

1. **Tagleme İçin Kullanılacak Alanlar:**
   - `process_name`: Uygulama/process adına göre tagleme yapılabilir
   - `title`: Pencere başlığına veya sayfa başlığına göre tagleme yapılabilir
   - `url`: URL'ye göre tagleme yapılabilir (browser aktiviteleri için)
   - `base_url`: Domain bazlı tagleme yapılabilir
   - `browser`: Tarayıcı bazlı tagleme yapılabilir

2. **Aktivite Tipleri:**
   - `window`: Masaüstü uygulaması aktivitesi (process_name ve title kullanılır)
   - `browser`: Web tarayıcı aktivitesi (url, browser, title kullanılır)

3. **Zaman Alanları:**
   - Tüm zaman alanları UTC formatındadır
   - Laravel'de timezone dönüşümü yapılmalıdır

4. **Filtreleme İçin Kullanılacak Alanlar:**
   - `username`: Kullanıcı bazlı filtreleme
   - `domain`: Domain bazlı filtreleme
   - `start_time_utc`: Tarih aralığı filtreleme
   - `activity_type`: Aktivite tipi filtreleme
   - `motherboard_uuid`: Cihaz bazlı filtreleme

5. **Index'ler:**
   - Tabloda performans için birçok index tanımlıdır
   - Sık kullanılan sorgular için index'ler optimize edilmiştir

### 2. Yeni Eklenen Tablolar (Laravel Projesi)

#### categories Tablosu
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    level TINYINT NOT NULL DEFAULT 1 COMMENT '1: Ana kategori, 2: Alt kategori, 3: Alt-alt kategori',
    type ENUM('work', 'other') NOT NULL DEFAULT 'work' COMMENT 'İş veya Diğer',
    color VARCHAR(7) NULL COMMENT 'Hex renk kodu (#FF5733)',
    icon VARCHAR(100) NULL COMMENT 'Icon class veya path',
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_parent_id (parent_id),
    INDEX idx_type (type),
    INDEX idx_level (level),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### category_keywords Tablosu
```sql
CREATE TABLE category_keywords (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    keyword VARCHAR(255) NOT NULL COMMENT 'Aranacak kelime veya ifade',
    match_type ENUM('exact', 'contains', 'starts_with', 'ends_with', 'regex') DEFAULT 'contains',
    is_case_sensitive BOOLEAN DEFAULT FALSE,
    priority INT DEFAULT 0 COMMENT 'Yüksek öncelik önce kontrol edilir',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category_id (category_id),
    INDEX idx_keyword (keyword),
    INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### activity_categories Tablosu (Pivot Table)
```sql
CREATE TABLE activity_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    activity_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    matched_keyword VARCHAR(255) NULL COMMENT 'Hangi kelime eşleşti',
    match_type VARCHAR(50) NULL COMMENT 'Eşleşme tipi',
    confidence_score DECIMAL(5,2) DEFAULT 100.00 COMMENT 'Eşleşme güven skoru',
    is_manual BOOLEAN DEFAULT FALSE COMMENT 'Manuel mi otomatik mi taglendi',
    tagged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_activity_category (activity_id, category_id),
    INDEX idx_activity_id (activity_id),
    INDEX idx_category_id (category_id),
    INDEX idx_tagged_at (tagged_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## 🏗️ Model Yapısı

### Category Model
- Hiyerarşik kategori yapısı (parent-child ilişkisi)
- Kategorilerin alt kategorilerini getirme
- Kategori ağacını oluşturma
- "İş" ve "Diğer" tipine göre filtreleme
- Kategori yolunu string olarak getirme (örn: "İş > Yazılım > Web Geliştirme")

### CategoryKeyword Model
- Keyword'leri kategoriye bağlama
- Eşleşme tipine göre kontrol (contains, exact, starts_with, vb.)
- Öncelik sırasına göre sıralama

### Activity Model (Güncellenmiş)
- Kategorilere bağlanma (many-to-many)
- Otomatik tagleme fonksiyonu
- Kategoriye göre filtreleme
- Kategori istatistikleri

## 🔄 Otomatik Tagleme Mantığı

### Tagleme Kuralları:
1. **Öncelik Sistemi**: Yüksek priority'li keyword'ler önce kontrol edilir
2. **Eşleşme Tipleri**:
   - `exact`: Tam eşleşme (case-sensitive seçeneğe göre)
   - `contains`: İçeriyor mu kontrolü
   - `starts_with`: Başlıyor mu kontrolü
   - `ends_with`: Bitiyor mu kontrolü
   - `regex`: Regex pattern ile eşleşme

3. **Eşleşme Sırası**:
   - Önce process_name kontrol edilir
   - Sonra title kontrol edilir
   - Her iki alanda da eşleşme varsa, en yüksek priority kazanır

4. **Çoklu Kategori**:
   - Bir aktivite birden fazla kategoriye taglenebilir
   - Ancak aynı kategoriye tekrar taglenemez

5. **Eşleşme Güven Skoru**:
   - Exact match: 100%
   - Contains: 80%
   - Starts/Ends with: 70%
   - Regex: 60%

## 📝 Kategori Hiyerarşisi Örneği

```
📁 İş (work)
  ├── 💼 Yazılım Geliştirme
  │   ├── 🌐 Web Geliştirme
  │   │   ├── Frontend
  │   │   └── Backend
  │   ├── 📱 Mobil Uygulama
  │   └── 🖥️ Masaüstü Uygulama
  ├── 📊 Veri Analizi
  │   ├── Excel/Spreadsheet
  │   └── Database İşlemleri
  ├── 📧 İletişim
  │   ├── Email
  │   └── Mesajlaşma
  └── 📝 Dokümantasyon

📁 Diğer (other)
  ├── 🎮 Eğlence
  │   ├── Oyunlar
  │   └── Video İzleme
  ├── 🌐 Sosyal Medya
  │   ├── Facebook
  │   ├── Twitter
  │   └── Instagram
  ├── 🎵 Müzik
  └── 📰 Haber
```

## 🎨 Admin Panel Özellikleri

### Kategori Yönetimi
- Kategori ekleme/düzenleme/silme
- Drag & drop ile kategori sıralama
- Kategori hiyerarşisini görsel olarak yönetme
- Kategori renk ve icon seçimi
- Kategori durumunu aktif/pasif yapma

### Keyword Yönetimi
- Keyword ekleme/düzenleme/silme
- Eşleşme tipi seçimi
- Öncelik belirleme
- Keyword'leri toplu import/export
- Keyword test paneli (test string girişi ile anlık eşleşme kontrolü)

### Aktivite Görüntüleme
- Taglenmiş aktiviteleri görüntüleme
- Taglenmemiş aktiviteleri listeleme
- Kategoriye göre aktivite filtreleme
- Aktivite detayında kategorileri görüntüleme
- Manuel kategori tagleme/kaldırma

### İstatistikler
- Kategori bazında aktivite sayıları
- Zaman dilimine göre kategori dağılımı
- Kullanıcı bazında kategori kullanımı
- En çok taglenen kategoriler
- Tagleme başarı oranı

## 🔧 API Endpoint'leri

### Kategori API'leri
```
GET    /api/categories                    - Tüm kategorileri listele (ağaç yapısında)
GET    /api/categories/{id}               - Kategori detayı
POST   /api/categories                    - Yeni kategori oluştur
PUT    /api/categories/{id}               - Kategori güncelle
DELETE /api/categories/{id}               - Kategori sil
GET    /api/categories/{id}/children      - Alt kategorileri getir
GET    /api/categories/type/{type}        - Tipine göre kategoriler (work/other)
```

### Keyword API'leri
```
GET    /api/keywords                      - Tüm keyword'leri listele
GET    /api/keywords/category/{id}        - Kategoriye ait keyword'ler
POST   /api/keywords                      - Yeni keyword ekle
PUT    /api/keywords/{id}                 - Keyword güncelle
DELETE /api/keywords/{id}                 - Keyword sil
POST   /api/keywords/bulk-import          - Toplu keyword import
POST   /api/keywords/test                 - Keyword test et
```

### Tagleme API'leri
```
POST   /api/activities/{id}/tag           - Aktiviteye manuel kategori tagle
DELETE /api/activities/{id}/tag/{catId}   - Aktiviteden kategori kaldır
POST   /api/activities/auto-tag           - Tüm taglenmemiş aktiviteleri otomatik tagle
POST   /api/activities/auto-tag/{id}      - Belirli aktiviteyi otomatik tagle
GET    /api/activities/tagged             - Taglenmiş aktiviteleri getir
GET    /api/activities/untagged           - Taglenmemiş aktiviteleri getir
GET    /api/activities/category/{catId}   - Kategoriye göre aktiviteler
```

### İstatistik API'leri
```
GET    /api/statistics/categories         - Kategori istatistikleri
GET    /api/statistics/category/{id}      - Belirli kategori istatistikleri
GET    /api/statistics/tagging-rate       - Tagleme başarı oranı
GET    /api/statistics/time-distribution  - Zaman dilimine göre kategori dağılımı
```

## 🚀 İlk Kurulum Adımları

### 1. Veritabanı Migrations
```bash
php artisan make:migration create_categories_table
php artisan make:migration create_category_keywords_table
php artisan make:migration create_activity_categories_table
php artisan migrate
```

### 2. Seeders (İlk Veriler)
```bash
php artisan make:seeder CategorySeeder
php artisan make:seeder CategoryKeywordSeeder
```

### 3. Başlangıç Kategorileri
Seeder'da şu kategoriler oluşturulacak:
- **İş (work)** - Ana kategori
  - Yazılım Geliştirme
  - Veri Analizi
  - İletişim
  - Dokümantasyon
- **Diğer (other)** - Ana kategori
  - Eğlence
  - Sosyal Medya
  - Müzik
  - Haber

### 4. Örnek Keyword'ler
Her kategori için örnek keyword'ler eklenmeli:
- **Yazılım Geliştirme** → "Visual Studio", "VS Code", "IntelliJ", "code", "developer", "programming"
- **Excel/Spreadsheet** → "excel", "sheets", "spreadsheet", ".xlsx", "google sheets"
- **Email** → "outlook", "gmail", "thunderbird", "mail"

## 🔄 Otomatik Tagleme Servisi

### Background Job
- Her yeni aktivite eklendiğinde otomatik tagleme
- Cron job ile taglenmemiş aktiviteleri periyodik kontrol
- Queue sistemi ile performanslı tagleme

### Tagleme Algoritması
1. Taglenmemiş aktiviteleri getir
2. Her aktivite için:
   - Process_name'i al
   - Title'ı al
   - Tüm aktif keyword'leri priority'ye göre sırala
   - Her keyword için eşleşme kontrolü yap
   - Eşleşme bulunursa kategoriyi tagle
   - Confidence score hesapla
3. Tagleme sonuçlarını logla

## 📊 Raporlama Özellikleri

### Kategori Bazlı Raporlar
- Günlük/Haftalık/Aylık kategori kullanım raporu
- Kategori bazında süre analizi (dakika/saat)
- Kategori trend analizi
- Kategori karşılaştırma raporu

### Kullanıcı Bazlı Raporlar
- Kullanıcının en çok kullandığı kategoriler
- Kullanıcının çalışma saatleri analizi
- Kullanıcının üretkenlik skoru (İş/Diğer oranı)

### Export Özellikleri
- PDF rapor export
- Excel/CSV export
- JSON API export

## 🎯 Kullanıcı Arayüzü Gereksinimleri

### Admin Panel
- Modern, responsive tasarım
- Drag & drop kategori yönetimi
- Real-time tagleme önizleme
- Grafik ve chart'lar ile görselleştirme

### Dashboard
- Kategori dağılımı pie chart
- Zaman bazlı kategori trend chart
- En çok kullanılan kategoriler listesi
- Taglenmemiş aktivite sayısı uyarısı

## 🔐 Güvenlik ve Yetkilendirme

- Admin yetkisi gerektiren endpoint'ler
- Kategori ve keyword yönetimi için rol bazlı erişim
- Aktivite görüntüleme için kullanıcı bazlı filtreleme

## 📝 Notlar ve Öneriler

1. **Performans**: Büyük veri setlerinde tagleme işlemi queue ile yapılmalı
2. **Cache**: Kategori ağacı ve keyword'ler cache'lenmeli
3. **Test**: Keyword test paneli mutlaka olmalı
4. **Logging**: Tagleme işlemleri loglanmalı
5. **Backup**: Kategori ve keyword verileri düzenli yedeklenmeli

---

**Bu dokümantasyon, Laravel'de kategori bazlı otomatik etiketleme sistemi için kapsamlı bir rehberdir. AI asistanına bu dosyayı vererek tüm sistemi oluşturmasını sağlayabilirsiniz.**


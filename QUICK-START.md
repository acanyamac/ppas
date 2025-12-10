# 🚀 Perfas - Hızlı Başlangıç Kılavuzu

## 📝 Giriş

Bu kılavuz, yeni modern Tailwind CSS tabanlı arayüzü kullanmaya başlamanız için gereken tüm adımları içerir.

## ✅ Kurulum Tamamlandı mı?

Eğer npm paketleri kurulmadıysa:
```bash
cd c:\Users\yamac\OneDrive\Masaüstü\Performace\PerformanceAgent-Laravel
npm install
```

## 🎯 Yeni Arayüzü Kullanmaya Başlama

### 1. Vite Development Server'ı Başlatın

```bash
npm run dev
```

Bu komut Tailwind CSS'i derleyecek ve değişiklikleri otomatik olarak yeniden yükleyecektir.

### 2. Laravel Server'ı Başlatın

Ayrı bir terminal penceresinde:
```bash
php artisan serve
```

### 3. View Dosyalarını Değiştirin

#### Dashboard için:

**Dosya:** `app/Http/Controllers/DashboardController.php` veya route tanımınız

```php
// Eski dashboard yerine:
return view('dashboard-tailwind', $data);
```

#### Kategoriler için:

**Dosya:** `app/Http/Controllers/Performance/CategoryController.php`

```php
public function index()
{
    $categories = Category::with(['parent', 'keywords', 'children_tree'])->get();
    
    // Eski view yerine:
    return view('performance.categories.index-new', compact('categories'));
}
```

## 🎨 Component Kullanımı

### Alert Component

```blade
{{-- Success Alert --}}
<x-alert type="success">
    İşlem başarıyla tamamlandı!
</x-alert>

{{-- Error Alert --}}
<x-alert type="error">
    Bir hata oluştu!
</x-alert>

{{-- Warning Alert --}}
<x-alert type="warning">
    Dikkat! Bu işlem geri alınamaz.
</x-alert>

{{-- Info Alert --}}
<x-alert type="info">
    Bilgi: Yeni özellikler eklendi.
</x-alert>
```

### Button Component

```blade
{{-- Primary Button --}}
<x-button type="primary" icon="plus">
    Yeni Ekle
</x-button>

{{-- Success Button with link --}}
<x-button type="success" href="{{ route('categories.create') }}" icon="save">
    Kaydet
</x-button>

{{-- Danger Button --}}
<x-button type="danger" icon="trash" size="sm">
    Sil
</x-button>

{{-- Outline Button --}}
<x-button type="outline" icon="download" icon-position="right">
    İndir
</x-button>
```

### Stats Card Component

```blade
<x-stats-card 
    title="Toplam Kullanıcı" 
    :value="$totalUsers" 
    icon="users"
    color="primary"
    :subtitle="'Son 7 günde +' . $newUsers . ' yeni'"
    :trend="['direction' => 'up', 'value' => '+12%', 'label' => 'geçen haftaya göre']"
/>
```

## 🎨 Renk Sistemi

### Tailwind Renkleri

```html
<!-- Primary (Mor) -->
<div class="bg-primary-500 text-white">Primary</div>

<!-- Success (Yeşil) -->
<div class="bg-green-500 text-white">Success</div>

<!-- Warning (Sarı) -->
<div class="bg-yellow-500 text-white">Warning</div>

<!-- Danger (Kırmızı) -->
<div class="bg-red-500 text-white">Danger</div>

<!-- Gray (Gri) -->
<div class="bg-gray-500 text-white">Gray</div>
```

### Gradient Renkleri

```html
<div class="gradient-primary">Mor Gradient</div>
<div class="gradient-success">Yeşil Gradient</div>
<div class="gradient-warning">Sarı Gradient</div>
<div class="gradient-danger">Kırmızı Gradient</div>
```

## 📱 Responsive Tasarım

### Breakpoint'ler

```html
<!-- Mobile First Approach -->
<div class="text-sm md:text-base lg:text-lg xl:text-xl">
    Responsive Text
</div>

<!-- Grid System -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Cards -->
</div>

<!-- Flex System -->
<div class="flex flex-col md:flex-row md:items-center gap-4">
    <!-- Items -->
</div>
```

### Tailwind Breakpoint'leri:
- `sm`: 640px
- `md`: 768px
- `lg`: 1024px
- `xl`: 1280px
- `2xl`: 1536px

## 🌙 Dark Mode

### Dark Mode Kullanımı

```html
<!-- Light ve Dark mode için farklı renkler -->
<div class="bg-white dark:bg-gray-800">
    <h1 class="text-gray-900 dark:text-white">Başlık</h1>
    <p class="text-gray-600 dark:text-gray-400">Açıklama</p>
</div>
```

### Dark Mode Toggle

Header'da otomatik olarak eklenmiş dark mode butonu var. Manuel olarak değiştirmek için:

```javascript
toggleTheme()
```

## 🎯 Layout Kullanımı

### Yeni Master Layout

```blade
@extends('layouts.tailwind.master')

@section('title', 'Sayfa Başlığı')

@section('page-title', 'Ana Başlık')
@section('page-description', 'Sayfa açıklaması')

@section('breadcrumb')
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</span>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Alt Sayfa</span>
        </div>
    </li>
@endsection

@section('content')
    <!-- Your content here -->
@endsection

@section('scripts')
    <!-- Your custom scripts -->
@endsection
```

## 🎨 Özel CSS Sınıfları

### Cards

```html
<!-- Basic Card -->
<div class="card">
    <div class="card-header">
        <h5 class="text-lg font-semibold">Başlık</h5>
    </div>
    <div class="card-body">
        İçerik
    </div>
</div>

<!-- Stats Card -->
<div class="stats-card">
    <!-- İçerik -->
</div>
```

### Badges

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-danger">Danger</span>
```

### Buttons

```html
<button class="btn btn-primary">Primary Button</button>
<button class="btn btn-secondary">Secondary Button</button>
```

## 🔧 Özelleştirme

### Renkleri Değiştirme

`tailwind.config.js` dosyasında:

```javascript
theme: {
  extend: {
    colors: {
      primary: {
        500: '#YOUR_COLOR',  // Ana renginiz
        600: '#DARKER_COLOR',  // Hover rengi
      }
    }
  }
}
```

Değişiklik yaptıktan sonra:
```bash
npm run dev  # veya npm run build
```

### Yeni Animasyon Ekleme

`tailwind.config.js` dosyasında:

```javascript
animation: {
  'custom-bounce': 'customBounce 1s ease-in-out infinite',
},
keyframes: {
  customBounce: {
    '0%, 100%': { transform: 'translateY(0)' },
    '50%': { transform: 'translateY(-10px)' },
  }
}
```

Kullanım:
```html
<div class="animate-custom-bounce">Bounce!</div>
```

## 📊 DataTables Kullanımı

```blade
@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "pageLength": 25,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json"
            }
        });
    });
</script>
@endsection
```

## 🚨 Sorun Giderme

### Tailwind CSS çalışmıyor

1. Vite server'ın çalıştığından emin olun:
```bash
npm run dev
```

2. Cache'i temizleyin:
```bash
php artisan cache:clear
php artisan view:clear
```

3. Tarayıcı cache'ini temizleyin (Ctrl+F5)

### Dark mode çalışmıyor

localStorage'da 'theme' anahtarını kontrol edin:

```javascript
// Console'da çalıştırın
console.log(localStorage.getItem('theme'));

// Manuel olarak değiştirin
localStorage.setItem('theme', 'dark');
// veya
localStorage.setItem('theme', 'light');
```

### Animasyonlar çalışmıyor

1. `app.js` yüklendiğinden emin olun
2. Tarayıcı console'unda hata var mı kontrol edin
3. Alpine.js yüklendiğinden emin olun

## 💡 İpuçları

1. **Mobile First**: Her zaman mobil tasarımdan başlayın
2. **Dark Mode**: Tüm renklerde dark mode versiyonu ekleyin
3. **Accessibility**: ARIA labels kullanın
4. **Performance**: Gereksiz animasyonlardan kaçının
5. **Consistency**: Tasarım sistemini takip edin

## 📞 Destek

Sorun yaşarsanız:
1. `MODERNIZATION-README.md` dosyasını kontrol edin
2. Tailwind CSS dokümantasyonuna bakın
3. Laravel Vite dokümantasyonunu inceleyin

## 🎉 Tebrikler!

Artık modern, responsive bir arayüze sahipsiniz! 🚀

---

**Son Güncelleme:** {{ date('Y-m-d H:i') }}
**Versiyon:** 2.0.0

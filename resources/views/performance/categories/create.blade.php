@extends('layouts.master')

@section('title', 'Yeni Kategori')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Yeni Kategori</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kategori oluşturun ve ayarlarını yapılandırın</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('categories.index') }}" class="text-primary-600 hover:text-primary-700">Kategoriler</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Yeni</span>
    </li>
@endsection

@section('content')
<form action="{{ route('categories.store') }}" method="POST" x-data="{ formData: { name: '', type: '', color: '#3b82f6', icon: 'fa-folder' } }">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header border-b border-gray-200 dark:border-gray-700">
                    <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-folder-plus text-primary-500"></i>
                        Kategori Bilgileri
                    </h5>
                </div>
                <div class="card-body space-y-6">
                    <!-- Name & Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kategori Adı <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   x-model="formData.name"
                                   class="form-input @error('name') border-red-500 @enderror" 
                                   value="{{ old('name') }}" 
                                   required
                                   placeholder="Kategori adını girin">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tip <span class="text-red-500">*</span>
                            </label>
                            <select name="type" x-model="formData.type" class="form-select @error('type') border-red-500 @enderror" required>
                                <option value="">Seçiniz...</option>
                                <option value="work" {{ old('type') == 'work' ? 'selected' : '' }}>İş</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Diğer</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Parent Kategori
                        </label>
                        <select name="parent_id" class="form-select">
                            <option value="">Ana Kategori (Parent yok)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->getFullPath() }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Parent seçilmezse ana kategori olarak oluşturulur
                        </p>
                    </div>

                    <!-- Color & Icon -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Renk
                            </label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       name="color" 
                                       id="colorPicker" 
                                       x-model="formData.color"
                                       class="form-input flex-1" 
                                       value="{{ old('color', '#3b82f6') }}"
                                       placeholder="#3b82f6">
                                <button type="button" class="btn btn-secondary w-12" id="colorPickerBtn">
                                    <i class="fas fa-palette"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Icon (Font Awesome)
                            </label>
                            <input type="text" 
                                   name="icon" 
                                   x-model="formData.icon"
                                   class="form-input" 
                                   value="{{ old('icon') }}" 
                                   placeholder="fa-folder">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Örn: fa-folder, fa-code
                            </p>
                        </div>
                    </div>

                    <!-- Sort Order & Active -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sıralama
                            </label>
                            <input type="number" 
                                   name="sort_order" 
                                   class="form-input" 
                                   value="{{ old('sort_order', 0) }}"
                                   min="0">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Küçük değerler önce gösterilir
                            </p>
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_active" 
                                       class="form-checkbox h-5 w-5 text-primary-600 rounded" 
                                       value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Aktif
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Sidebar -->
        <div class="lg:col-span-1">
            <div class="card sticky top-6">
                <div class="card-header border-b border-gray-200 dark:border-gray-700">
                    <h5 class="font-bold text-gray-900 dark:text-white text-sm">
                        <i class="fas fa-eye text-primary-500"></i>
                        Önizleme
                    </h5>
                </div>
                <div class="card-body">
                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center"
                             :style="'background-color: ' + formData.color">
                            <i :class="'fas ' + formData.icon + ' text-white text-xl'"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white" x-text="formData.name || 'Kategori Adı'"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                <span x-show="formData.type === 'work'">İş</span>
                                <span x-show="formData.type === 'other'">Diğer</span>
                                <span x-show="!formData.type">Tip seçilmedi</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-6 bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800">
                <div class="card-body">
                    <h6 class="font-bold text-blue-900 dark:text-blue-300 mb-3">
                        <i class="fas fa-info-circle"></i> Yardım
                    </h6>
                    <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                        <p><strong>Kategori Adı:</strong> Benzersiz bir ad girin</p>
                        <p><strong>Tip:</strong> İş aktiviteleri için "İş"</p>
                        <p><strong>Parent:</strong> Alt kategori için parent seçin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-3 mt-6">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-2"></i>
            Kaydet
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-times mr-2"></i>
            İptal
        </a>
    </div>
</form>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
<script>
    const pickr = Pickr.create({
        el: '#colorPickerBtn',
        theme: 'classic',
        default: '{{ old("color", "#3b82f6") }}',
        swatches: [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
            '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'
        ],
        components: {
            preview: true,
            hue: true,
            interaction: { hex: true, input: true, save: true }
        }
    });

    pickr.on('save', (color) => {
        document.getElementById('colorPicker').value = color.toHEXA().toString();
        document.getElementById('colorPicker').dispatchEvent(new Event('input'));
        pickr.hide();
    });
</script>
@endsection

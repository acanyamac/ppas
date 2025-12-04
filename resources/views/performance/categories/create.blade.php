@extends('layouts.master')

@section('title', 'Yeni Kategori')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
@endsection

@section('breadcrumb-title')
    <h3>Yeni Kategori</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategoriler</a></li>
    <li class="breadcrumb-item active">Yeni Kategori</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Kategori Oluştur</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori Adı <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tip <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">Seçiniz...</option>
                                    <option value="work" {{ old('type') == 'work' ? 'selected' : '' }}>İş</option>
                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Diğer</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Parent Kategori</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">Ana Kategori (Parent yok)</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->getFullPath() }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Parent seçilmezse ana kategori olarak oluşturulur</small>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Renk</label>
                                <div class="input-group">
                                    <input type="text" name="color" id="colorPicker" 
                                           class="form-control" value="{{ old('color', '#7366ff') }}">
                                    <button type="button" class="btn btn-outline-secondary" id="colorPickerBtn">
                                        <i class="fa fa-palette"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Icon (Font Awesome)</label>
                                <input type="text" name="icon" class="form-control" 
                                       value="{{ old('icon') }}" placeholder="fa-folder">
                                <small class="form-text text-muted">Örn: fa-folder, fa-code</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sıralama</label>
                                <input type="number" name="sort_order" class="form-control" 
                                       value="{{ old('sort_order', 0) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_active" class="form-check-input" 
                                           id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Kaydet
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> İptal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
<script>
    // Color Picker
    const pickr = Pickr.create({
        el: '#colorPickerBtn',
        theme: 'classic',
        default: '{{ old('color', '#7366ff') }}',
        swatches: [
            '#7366ff', '#f73164', '#51bb25', '#ffc107',
            '#17a2b8', '#6c757d', '#dc3545', '#28a745'
        ],
        components: {
            preview: true,
            opacity: false,
            hue: true,
            interaction: {
                hex: true,
                rgba: false,
                hsla: false,
                hsva: false,
                cmyk: false,
                input: true,
                clear: false,
                save: true
            }
        }
    });

    pickr.on('save', (color, instance) => {
        document.getElementById('colorPicker').value = color.toHEXA().toString();
        pickr.hide();
    });
</script>
@endsection

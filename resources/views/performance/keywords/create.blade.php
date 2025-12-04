@extends('layouts.master')

@section('title', 'Yeni Keyword')

@section('breadcrumb-title')
    <h3>Yeni Keyword</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item"><a href="{{ route('keywords.index') }}">Keyword'ler</a></li>
    <li class="breadcrumb-item active">Yeni Keyword</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Keyword Oluştur</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('keywords.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Seçiniz...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->getFullPath() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keyword <span class="text-danger">*</span></label>
                            <input type="text" name="keyword" class="form-control @error('keyword') is-invalid @enderror" 
                                   value="{{ old('keyword') }}" required placeholder="Örn: Visual Studio Code">
                            @error('keyword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Process name, title veya URL'de aranacak kelime</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Eşleşme Tipi <span class="text-danger">*</span></label>
                                <select name="match_type" class="form-select @error('match_type') is-invalid @enderror" required>
                                    <option value="">Seçiniz...</option>
                                    <option value="exact" {{ old('match_type') == 'exact' ? 'selected' : '' }}>Tam Eşleşme (100%)</option>
                                    <option value="contains" {{ old('match_type') == 'contains' ? 'selected' : '' }} selected>İçeriyor (80%)</option>
                                    <option value="starts_with" {{ old('match_type') == 'starts_with' ? 'selected' : '' }}>Başlıyor (70%)</option>
                                    <option value="ends_with" {{ old('match_type') == 'ends_with' ? 'selected' : '' }}>Bitiyor (70%)</option>
                                    <option value="regex" {{ old('match_type') == 'regex' ? 'selected' : '' }}>Regex (60%)</option>
                                </select>
                                @error('match_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Öncelik (1-10) <span class="text-danger">*</span></label>
                                <input type="number" name="priority" class="form-control @error('priority') is-invalid @enderror" 
                                       value="{{ old('priority', 5) }}" min="1" max="10" required>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Yüksek öncelik önce eşleşir</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_case_sensitive" class="form-check-input" 
                                       id="isCaseSensitive" value="1" {{ old('is_case_sensitive') ? 'checked' : '' }}>
                                <label class="form-check-label" for="isCaseSensitive">
                                    Büyük/küçük harf duyarlı
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" 
                                       id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Kaydet
                            </button>
                            <a href="{{ route('keywords.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> İptal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Eşleşme Tipleri</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Tam Eşleşme:</strong> 
                            <small>Kelime birebir eşleşir (100% güven)</small>
                        </li>
                        <li class="mb-2">
                            <strong>İçeriyor:</strong> 
                            <small>Kelime içinde geçer (80% güven)</small>
                        </li>
                        <li class="mb-2">
                            <strong>Başlıyor:</strong> 
                            <small>Kelime ile başlar (70% güven)</small>
                        </li>
                        <li class="mb-2">
                            <strong>Bitiyor:</strong> 
                            <small>Kelime ile biter (70% güven)</small>
                        </li>
                        <li class="mb-2">
                            <strong>Regex:</strong> 
                            <small>Regex pattern eşleşmesi (60% güven)</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

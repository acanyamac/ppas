@extends('layouts.master')

@section('title', 'Keyword Düzenle')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Keyword Düzenle</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">                                       
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('keywords.index') }}">Keywordler</a></li>
                    <li class="breadcrumb-item active">Düzenle</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Keyword Düzenleme Formu -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Keyword Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('keywords.update', $keyword->id) }}" method="POST" class="theme-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="keyword">Keyword</label>
                            <input class="form-control @error('keyword') is-invalid @enderror" id="keyword" name="keyword" type="text" value="{{ old('keyword', $keyword->keyword) }}" placeholder="Google Chrome">
                            @error('keyword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="category_id">Varsayılan Kategori</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $keyword->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="match_type">Eşleşme Tipi</label>
                            <select class="form-select @error('match_type') is-invalid @enderror" id="match_type" name="match_type">
                                <option value="contains" {{ old('match_type', $keyword->match_type) == 'contains' ? 'selected' : '' }}>İçerir (Contains)</option>
                                <option value="exact" {{ old('match_type', $keyword->match_type) == 'exact' ? 'selected' : '' }}>Tam Eşleşme (Exact)</option>
                                <option value="starts_with" {{ old('match_type', $keyword->match_type) == 'starts_with' ? 'selected' : '' }}>İle Başlar (Starts With)</option>
                                <option value="ends_with" {{ old('match_type', $keyword->match_type) == 'ends_with' ? 'selected' : '' }}>İle Biter (Ends With)</option>
                                <option value="regex" {{ old('match_type', $keyword->match_type) == 'regex' ? 'selected' : '' }}>Regex</option>
                            </select>
                            <small class="form-text text-muted">Aktivite başlığı veya process adında bu keyword nasıl aranacak?</small>
                            @error('match_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="priority">Öncelik (1-10)</label>
                            <input class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" type="number" min="1" max="10" value="{{ old('priority', $keyword->priority) }}">
                            <small class="form-text text-muted">Çakışma durumunda yüksek öncelikli keyword geçerli olur.</small>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Güncelle</button>
                            <a href="{{ route('keywords.index') }}" class="btn btn-light">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bağlamsal İstisnalar (Overrides) -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Bağlamsal İstisnalar (Contextual Overrides)</h5>
                    <span class="badge badge-info">Bu keyword için birim veya kullanıcı bazlı özel kurallar</span>
                </div>
                <div class="card-body">
                    <!-- Yeni İstisna Ekleme Formu -->
                    <div class="bg-light p-3 mb-4 rounded">
                        <h6>Yeni İstisna Ekle</h6>
                        <form action="{{ route('keywords.overrides.store', $keyword->id) }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-md-3">
                                <label class="form-label">Tip</label>
                                <select class="form-select @error('type') is-invalid @enderror" name="type" id="override_type" onchange="toggleOverrideInputs()">
                                    <option value="unit">Birim Bazlı</option>
                                    <option value="user">Kullanıcı Bazlı</option>
                                </select>
                            </div>

                            <div class="col-md-3" id="unit_input_group">
                                <label class="form-label">Birim Seçiniz</label>
                                <select class="form-select @error('unit_id') is-invalid @enderror" name="unit_id">
                                    <option value="">Seçiniz...</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 d-none" id="user_input_group">
                                <label class="form-label">Kullanıcı Seçiniz</label>
                                <select class="form-select @error('computer_user_id') is-invalid @enderror" name="computer_user_id">
                                    <option value="">Seçiniz...</option>
                                    @foreach($computerUsers as $cUser)
                                        <option value="{{ $cUser->id }}">{{ $cUser->name ?? $cUser->username }} ({{ $cUser->username }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Hedef Kategori</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success w-100">İstisna Ekle</button>
                            </div>
                        </form>
                    </div>

                    <!-- Mevcut İstisnalar Tablosu -->
                    @if($keyword->overrides->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tip</th>
                                        <th>Birim / Kullanıcı</th>
                                        <th>Hedef Kategori</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keyword->overrides as $override)
                                        <tr>
                                            <td>
                                                @if($override->unit_id)
                                                    <span class="badge badge-primary">Birim</span>
                                                @else
                                                    <span class="badge badge-warning">Kullanıcı</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($override->unit_id)
                                                    {{ $override->unit->name ?? 'Silinmiş Birim' }}
                                                @else
                                                    {{ $override->computerUser->name ?? $override->computerUser->username ?? 'Silinmiş Kullanıcı' }}
                                                @endif
                                            </td>
                                            <td>{{ $override->category->name }}</td>
                                            <td>
                                                <form action="{{ route('keywords.overrides.destroy', $override->id) }}" method="POST" onsubmit="return confirm('Bu istisnayı silmek istediğinize emin misiniz?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Sil</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-light text-center" role="alert">
                            Henüz tanımlanmış bir istisna bulunmuyor.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function toggleOverrideInputs() {
        var type = document.getElementById('override_type').value;
        if (type === 'unit') {
            document.getElementById('unit_input_group').classList.remove('d-none');
            document.getElementById('user_input_group').classList.add('d-none');
        } else {
            document.getElementById('unit_input_group').classList.add('d-none');
            document.getElementById('user_input_group').classList.remove('d-none');
        }
    }
</script>
@endsection

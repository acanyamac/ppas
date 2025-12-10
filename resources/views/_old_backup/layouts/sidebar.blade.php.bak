<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('/') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>

        <div class="logo-icon-wrapper">
            <a href="#">
                <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
            </a>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="#"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}"
                                alt=""></a>
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>

                    {{-- Dashboard --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('dashboard') }}">
                            <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg>
                            <svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="mega-menu sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-others') }}"></use>
                            </svg>
                            <span>Yönetimsel İşlemler</span>
                        </a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    @unlessrole('Anket Kullanıcısı')
                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div class="submenu-title">
                                                    <h5>Birim İşlemleri</h5>
                                                </div>
                                                <ul class="submenu-content opensubmegamenu">
                                                    <li><a href="{{ route('birim.index') }}">Birimler</a></li>
                                                    <li><a href="{{ route('birim.create') }}">Birim Ekle</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div class="submenu-title">
                                                    <h5>Ünvan Tanımları</h5>
                                                </div>
                                                <ul class="submenu-content opensubmegamenu">
                                                    <li><a href="{{ route('unvan.index') }}">Ünvanlar</a></li>
                                                    <li><a href="{{ route('unvan.create') }}">Ünvan Ekle</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endunlessrole

                                    @role('Super Admin|Admin')
                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div class="submenu-title">
                                                    <h5>Rol İşlemleri</h5>
                                                </div>
                                                <ul class="submenu-content opensubmegamenu">
                                                    <li><a href="{{ route('roller.index') }}">Roller</a></li>
                                                    <li><a href="{{ route('roller.create') }}">Rol izinleri</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div class="submenu-title">
                                                    <h5>Kullanıcı İşlemleri</h5>
                                                </div>
                                                <ul class="submenu-content opensubmegamenu">
                                                    <li><a href="{{ route('kullanicilar.index') }}">Kullanıcılar</a></li>
                                                    <li><a href="{{ route('kullanicilar.create') }}">Kullanıcı Ekle</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endrole

                                    @role('Super Admin')
                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div class="submenu-title">
                                                    <h5>Çözüm Önerileri</h5>
                                                </div>
                                                <ul class="submenu-content opensubmegamenu">
                                                    <li><a href="{{ route('cozum-onerileri.index') }}">Listele</a></li>
                                                    <li><a href="{{ route('cozum-onerileri.import') }}">İçeri Aktar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </li>





                    {{-- Performance Agent Menüleri --}}
                    {{-- Kategori Yönetimi --}}
                    <li class="mega-menu sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-layout') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-layout') }}"></use>
                            </svg>
                            <span>Kategori Yönetimi</span>
                        </a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Kategoriler</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('categories.index') }}">Kategoriler</a></li>
                                                <li><a href="{{ route('categories.create') }}">Yeni Kategori</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- Keyword Yönetimi --}}
                    <li class="mega-menu sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                            </svg>
                            <span>Keyword Yönetimi</span>
                        </a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Keywords</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('keywords.index') }}">Keyword'ler</a></li>
                                                <li><a href="{{ route('keywords.create') }}">Yeni Keyword</a></li>
                                                <li><a href="{{ route('keywords.test') }}">Keyword Test</a></li>
                                                <li><a href="{{ route('keywords.import') }}">Toplu İçe Aktar</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- Aktivite Yönetimi --}}
                    <li class="mega-menu sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-task') }}"></use>
                            </svg>
                            <span>Aktivite Yönetimi</span>
                        </a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Aktiviteler</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('activities.index') }}">Tüm Aktiviteler</a></li>
                                                <li><a href="{{ route('activities.tagged') }}">Taglenmiş</a></li>
                                                <li><a href="{{ route('activities.untagged') }}">Taglenmemiş</a></li>
                                                <li><a href="{{ route('activities.auto-tag') }}">Otomatik Tagleme</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- İstatistik & Raporlar --}}
                    <li class="mega-menu sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-charts') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-charts') }}"></use>
                            </svg>
                            <span>İstatistik & Raporlar</span>
                        </a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Raporlar</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('statistics.index') }}">Kategori İstatistikleri</a></li>
                                                <li><a href="{{ route('statistics.tagging-rate') }}">Tagleme Oranı</a></li>
                                                <li><a href="{{ route('statistics.time-distribution') }}">Zaman Dağılımı</a></li>
                                                <li><a href="{{ route('statistics.work-other') }}">İş/Diğer Oranı</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- Kullanıcı Yönetimi --}}
                    <li class="mega-menu sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>Kullanıcı Yönetimi</span>
                        </a>
                        <div class="mega-menu-container menu-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col mega-box">
                                        <div class="link-section">
                                            <div class="submenu-title">
                                                <h5>Bilgisayar Kullanıcıları</h5>
                                            </div>
                                            <ul class="submenu-content opensubmegamenu">
                                                <li><a href="{{ route('computer-users.index') }}">Bilgisayar Kullanıcıları</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>



                    {{-- Boş üçlü sidebar item - silinmemeli --}}
                    <li class=""><a class="sidebar-link" href="#"><svg class="stroke-icon"></svg><svg
                                class="fill-icon"></svg><span></span></a></li>
                    <li class=""><a class="sidebar-link" href="#"><svg class="stroke-icon"></svg><svg
                                class="fill-icon"></svg><span></span></a></li>
                    <li class=""><a class="sidebar-link" href="#"><svg class="stroke-icon"></svg><svg
                                class="fill-icon"></svg><span></span></a></li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>

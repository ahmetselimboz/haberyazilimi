<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <!-- sidebar menu-->
                @if (Auth::check() and Auth::user()->status == 1)
                    <ul class="sidebar-menu" data-widget="tree">
                        <li><a href="{{ route('secure.index') }}"> <i class="fa fa-dashboard me-1 fs-18"></i> <span>Panel
                                    Anasayfa</span>
                            </a></li>
                        <li><a href="{{ route('users.index') }}"> <i class="fa fa-user-circle-o me-1 fs-18"></i>
                                <span>Üyeler</span>
                            </a></li>
                        <li><a href="{{ route('category.index') }}"> <i class="fa fa-folder-o me-1 fs-18"></i>
                                <span>Kategoriler</span>
                            </a></li>
                        <li><a href="{{ route('post.index') }}"> <i class="fa fa-list-ul me-1 fs-18"></i>
                                <span>Haberler</span> </a></li>
                        <li><a href="{{ route('menus') }}"> <i class="fa fa-ioxhost me-1 fs-18"></i>
                                <span>Menüler</span> </a></li>
                        <li><a href="{{ route('image-gallery') }}"> <i class="fa fa-picture-o me-1 fs-18"></i>
                                <span>Resim Galerisi</span> </a></li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-cubes"></i><span>İçerik Yönetimi</span><span
                                    class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('page.index') }}"> <i class="icon-Commit"></i>
                                        <span>Sayfalar</span> </a></li>
                                <li><a href="{{ route('article.index') }}"> <i class="icon-Commit"></i>
                                        <span>Makaleler</span> </a></li>
                                {{-- <li><a href="{{ route('biography.index') }}"> <i class="icon-Commit"></i>
                                        <span>Biyografiler</span>
                                    </a></li> --}}
                                <li><a href="{{ route('enewspaper.index') }}"> <i class="icon-Commit"></i> <span>E
                                            Gazeteler</span>
                                    </a></li>
                                <li><a href="{{ route('comment.index') }}"> <i class="icon-Commit"></i>
                                        <span>Yorumlar</span> </a></li>
                                <li><a href="{{ route('video.index') }}"> <i class="icon-Commit"></i> <span>Video
                                            Galeriler</span>
                                    </a></li>
                                {{-- <li><a href="{{ route('photogallery.index') }}"> <i class="icon-Commit"></i> <span>Foto
                                            Galeriler</span>
                                    </a></li> --}}
                                {{-- <li><a href="{{ route('survey.index') }}"> <i class="icon-Commit"></i>
                                        <span>Anketler</span> </a></li> --}}
                                <li><a href="{{ route('ads.index') }}"> <i class="icon-Commit"></i>
                                        <span>Reklamlar</span> </a></li>
                                {{-- <li><a href="{{ route('firm.index') }}"> <i class="icon-Commit"></i>
                                        <span>Firma Rehberi</span> </a></li> --}}
                                {{-- <li><a href="{{ route('clsfad.index') }}"> <i class="icon-Commit"></i> <span>Seri
                                            İlanlar</span>
                                    </a></li> --}}
                                <li><a href="{{ route('official_advert.index') }}"> <i class="icon-Commit"></i>
                                        <span>Resmi
                                            İlanlar</span>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-sliders"></i><span>Sıralama Yönetimi</span><span
                                    class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('sortableSlide') }}"> <i class="icon-Commit"></i> <span>Manşet
                                            Sıralama</span>
                                    </a></li>
                                <li><a href="{{ route('sortableHomePage') }}"> <i class="icon-Commit"></i>
                                        <span>Anasayfa
                                            Sıralama</span>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-google"></i><span>Google Ürünleri & SEO</span><span
                                    class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('googleAnalytic') }}"> <i class="icon-Commit"></i> <span>Google
                                            Analitik</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('seocheck', ['type' => '1']) }}"> <i class="icon-Commit"></i>
                                        <span>Başlık Sorunları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('seocheck', ['type' => '2']) }}"> <i class="icon-Commit"></i>
                                        <span>Açıklama Sorunları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('seocheck', ['type' => '3']) }}"> <i class="icon-Commit"></i>
                                        <span>Etiket Sorunları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('gmail') }}"> <i class="icon-Commit"></i> <span>Google
                                            Gmail</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('serp') }}"> <i class="icon-Commit"></i> <span>Google SERP</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('trends') }}"> <i class="icon-Commit"></i> <span>Google
                                            Trendler</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-rss"></i><span>Ajanslar</span><span
                                    class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('agencies', ['agency' => 'iha']) }}"> <i class="icon-Commit"></i>
                                        <span>IHA Haber Ajansı</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agencies', ['agency' => 'hibya']) }}"> <i
                                            class="icon-Commit"></i>
                                        <span>HIBYA Haber Ajansı</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-puzzle-piece"></i>
                                <span>Eklentiler</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('plugins.index') }}"> <i class="icon-Commit"></i>
                                        <span>Mevcut Eklentiler</span> </a></li>
                                <li><a href="{{ route('plugin.market') }}"> <i class="icon-Commit"></i>
                                        <span>Eklenti Mağazası</span> </a></li>


                            </ul>
                        </li>
                        <li><a href="{{ route('message') }}"> <i class="fa fa-envelope me-1 fs-18"></i> <span>İletişim
                                    Talepleri</span>
                            </a></li>
                        <li><a href="{{ route('activitylogs') }}"> <i class="fa fa-database me-1 fs-18"></i>
                                <span>Sistem
                                    Kayıtları</span>
                            </a></li>
                        <li><a href="{{ route('settings') }}"> <i class="fa fa-cog me-1 fs-18"></i>
                                <span>Ayarlar</span>
                            </a></li>
                    </ul>
                @elseif(Auth::check() and Auth::user()->status == 2)
                    <ul class="sidebar-menu" data-widget="tree">
                        <li><a href="{{ route('secure.index') }}"> <i class="fa fa-dashboard me-1 fs-18"></i>
                                <span>Panel
                                    Anasayfa</span>
                            </a></li>
                        <li><a href="{{ route('category.index') }}"> <i class="fa fa-folder-o me-1 fs-18"></i>
                                <span>Kategoriler</span>
                            </a></li>
                        <li><a href="{{ route('post.index') }}"> <i class="fa fa-list-ul me-1 fs-18"></i>
                                <span>Haberler</span> </a></li>
                    </ul>
                @endif
            </div>
        </div>
    </section>
</aside>

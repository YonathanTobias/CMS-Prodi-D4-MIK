@extends('layouts.frontend')

@section('title', 'Pusat Unduhan - ' . get_setting('division_short_name', 'Divisi'))

@section('content')
<!-- Header Banner -->
<section class="py-14 lg:py-16 text-white relative overflow-hidden" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl space-y-3">
            <div class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-wider px-3.5 py-1.5 rounded-full bg-white/15 text-white border border-white/20 backdrop-blur-sm">
                <i class="fa-solid fa-folder-open"></i>
                <span>Repository & Berkas Resmi</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">Pusat Unduhan Dokumen</h1>
            <p class="text-sm sm:text-base text-purple-100/90 leading-relaxed">
                Buku pedoman akademik, modul praktikum, formulir administrasi, SOP, dan format penulisan skripsi/tugas akhir {{ get_setting('division_short_name', 'Prodi D4 MIK') }}.
            </p>
        </div>
    </div>
</section>

<!-- Main Content Area -->
<section class="py-12 bg-slate-50 dark:bg-slate-950 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Search & Filter Card -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200/80 dark:border-slate-800 flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Filter Categories -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('documents', array_filter(['q' => request('q')])) }}" 
                   class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center {{ !request('kategori') ? 'bg-theme-primary text-white shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    <i class="fa-solid fa-layer-group mr-2"></i>
                    <span>Semua Kategori</span>
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('documents', array_filter(['kategori' => $cat->slug, 'q' => request('q')])) }}" 
                   class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center {{ request('kategori') == $cat->slug ? 'bg-theme-primary text-white shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] {{ request('kategori') == $cat->slug ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $cat->documents_count }}</span>
                </a>
                @endforeach
            </div>

            <!-- Search input -->
            <form action="{{ route('documents') }}" method="GET" class="flex items-center space-x-2">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative flex-1 lg:w-72">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama berkas atau pedoman..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-theme-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 text-white text-xs font-bold transition shadow-sm">
                    Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('documents', array_filter(['kategori' => request('kategori')])) }}" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-white text-xs transition" title="Reset Pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>
        </div>

        @if(request('q'))
            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center">
                <span>Menampilkan hasil pencarian untuk: <strong class="text-slate-900 dark:text-white">"{{ request('q') }}"</strong> ({{ $documents->total() }} berkas ditemukan)</span>
            </div>
        @endif

        <!-- Documents List -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800 divide-y divide-slate-100 dark:divide-slate-800 overflow-hidden">
            @forelse($documents as $doc)
            @php
                $isUrl = str_starts_with($doc->file_path, 'http');
            @endphp
            <div class="p-5 sm:p-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition flex flex-col md:flex-row md:items-center justify-between gap-5 group">
                <!-- Left: File Icon + Content Details -->
                <div class="flex items-start space-x-4 sm:space-x-5 flex-grow">
                    <!-- File Format Icon Avatar -->
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 shadow-sm border transition group-hover:scale-105 duration-200
                        @if($doc->file_type == 'GDRIVE') bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border-amber-200 dark:border-amber-800
                        @elseif($doc->file_type == 'PDF') bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border-rose-200 dark:border-rose-800
                        @elseif(in_array($doc->file_type, ['DOC', 'DOCX'])) bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800
                        @elseif(in_array($doc->file_type, ['XLS', 'XLSX'])) bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800
                        @elseif(in_array($doc->file_type, ['PPT', 'PPTX'])) bg-orange-50 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 border-orange-200 dark:border-orange-800
                        @elseif(in_array($doc->file_type, ['ZIP', 'RAR'])) bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 border-purple-200 dark:border-purple-800
                        @else bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 border-purple-200 dark:border-purple-800 @endif">
                        
                        @if($doc->file_type == 'GDRIVE')
                            <i class="fa-brands fa-google-drive"></i>
                        @elseif($doc->file_type == 'PDF')
                            <i class="fa-solid fa-file-pdf"></i>
                        @elseif(in_array($doc->file_type, ['DOC', 'DOCX']))
                            <i class="fa-solid fa-file-word"></i>
                        @elseif(in_array($doc->file_type, ['XLS', 'XLSX']))
                            <i class="fa-solid fa-file-excel"></i>
                        @elseif(in_array($doc->file_type, ['PPT', 'PPTX']))
                            <i class="fa-solid fa-file-powerpoint"></i>
                        @elseif(in_array($doc->file_type, ['ZIP', 'RAR']))
                            <i class="fa-solid fa-file-zipper"></i>
                        @else
                            <i class="fa-solid fa-file-lines"></i>
                        @endif
                    </div>

                    <!-- Texts & Metadata -->
                    <div class="space-y-1.5 flex-grow">
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-theme-primary transition leading-snug">
                            {{ $doc->title }}
                        </h3>

                        @if($doc->description)
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-3xl">
                                {{ $doc->description }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-2.5 sm:gap-4 text-xs text-slate-500 dark:text-slate-400 pt-1">
                            @if($doc->category)
                                <span class="px-2.5 py-0.5 rounded-full bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 text-[10px] font-bold">
                                    {{ $doc->category->name }}
                                </span>
                            @endif
                            <span class="flex items-center"><i class="fa-solid fa-hard-drive mr-1.5 text-slate-400"></i> {{ $doc->file_size ?: 'Ukuran bervariasi' }}</span>
                            <span class="flex items-center"><i class="fa-solid fa-download mr-1.5 text-slate-400"></i> {{ $doc->downloads_count }} kali diunduh</span>
                            <span class="flex items-center"><i class="fa-regular fa-calendar mr-1.5 text-slate-400"></i> Diperbarui {{ $doc->updated_at->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Download Action Button -->
                <div class="flex-shrink-0 self-start md:self-center pt-2 md:pt-0">
                    <a href="{{ route('documents.download', $doc->id) }}" {{ $isUrl ? 'target=_blank rel=noopener' : '' }} 
                       class="px-5 py-2.5 rounded-xl bg-theme-primary text-white font-bold text-xs inline-flex items-center shadow-md hover:opacity-90 hover:scale-[1.02] active:scale-[0.98] transition">
                        @if($isUrl)
                            <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Buka Dokumen
                        @else
                            <i class="fa-solid fa-download mr-2"></i> Unduh Berkas
                        @endif
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-20 text-slate-400 dark:text-slate-500 space-y-3">
                <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-3xl">
                    <i class="fa-regular fa-folder-open"></i>
                </div>
                <h4 class="text-base font-bold text-slate-700 dark:text-slate-200">Tidak ada dokumen yang ditemukan</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Coba gunakan kata kunci pencarian yang lain atau pilih kategori yang berbeda.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($documents->hasPages())
        <div class="mt-8">
            {{ $documents->links() }}
        </div>
        @endif

    </div>
</section>
@endsection

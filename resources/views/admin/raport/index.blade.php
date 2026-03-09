@extends('admin.layouts.admin')

@section('title', 'Raport')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Managemen Raport</h1>
            <p class="text-gray-600 mt-1">Pilih kelas untuk mengelola nilai dan mencetak raport siswa.</p>
        </div>
        <div class="hidden md:block">
            <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-2">
                <span class="text-sm text-amber-800 font-medium italic">Tahun Ajaran: {{ session('selected_tahun_ajaran') ?: \App\Models\MasterTahunAjaran::getAktif() ?: date('y').'/'.(date('y')+1) }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @foreach($classes as $c)
            @php $k = $c->tingkat; @endphp
            <a href="{{ route('admin.raport.byKelas', $k) }}" class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:border-[#47663D]/20 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-[#47663D]/5 rounded-full group-hover:bg-[#47663D]/10 transition-colors"></div>
                
                <div class="relative flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#47663D] to-[#5a7d52] rounded-xl flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-[#47663D]/20">
                        {{ $k }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Kelas {{ $k }}</h3>
                        <p class="text-sm text-gray-500">{{ $c->nama_surah }}</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center text-sm font-medium text-[#47663D] group-hover:translate-x-1 transition-transform">
                    Kelola Raport 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Rentang Predikat (Inline Version) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-12">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Rentang Nilai Predikat</h2>
            <p class="text-sm text-gray-500 mt-1">Atur batas minimal nilai untuk mendapatkan predikat A, B, dan C per tahun ajaran.</p>
        </div>

        <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
            {{-- Hidden Forms for HTML Validity & CSRF Security --}}
            @foreach($tahunAjaranList as $t)
            <form id="form-predikat-{{ $t->id }}" action="{{ route('admin.settings.rentang-predikat.store') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="id" value="{{ $t->id }}">
            </form>
            @endforeach

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Tahun Ajaran</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-600">Min A</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-600">Min B</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-600">Min C</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tahunAjaranList as $t)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-700 font-medium">{{ $t->nama }}</span>
                                    @if($t->is_aktif) 
                                        <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Aktif</span> 
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input form="form-predikat-{{ $t->id }}" type="number" name="min_a" value="{{ $t->min_a }}" min="0" max="100" class="w-20 px-3 py-1.5 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input form="form-predikat-{{ $t->id }}" type="number" name="min_b" value="{{ $t->min_b }}" min="0" max="100" class="w-20 px-3 py-1.5 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input form="form-predikat-{{ $t->id }}" type="number" name="min_c" value="{{ $t->min_c }}" min="0" max="100" class="w-20 px-3 py-1.5 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button form="form-predikat-{{ $t->id }}" type="submit" class="inline-flex items-center px-4 py-2 bg-[#47663D] text-white text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-[#5a7d52] transition-colors">
                                    Simpan
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Toast Notification --}}
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            init() {
                @if(session('success'))
                    this.showToast({!! json_encode(session('success')) !!}, 'success');
                @endif
                @if(session('error'))
                    this.showToast({!! json_encode(session('error')) !!}, 'error');
                @endif
            },
            showToast(msg, type) {
                this.message = msg;
                this.type = type;
                this.show = true;
                setTimeout(() => this.show = false, 5000);
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-8 right-8 z-[110]"
         x-cloak>
        <div :class="type === 'success' ? 'bg-emerald-600' : 'bg-red-600'" 
             class="flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl text-white">
            <template x-if="type === 'success'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </template>
            <span class="font-semibold" x-text="message"></span>
            <button @click="show = false" class="ml-4 hover:opacity-70 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
</div>
@endsection

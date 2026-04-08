@extends('admin.layouts.admin')

@section('title', 'Hak Akses & Fitur')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{ activeTab: 'sdm' }">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Pengaturan Akses Fitur (Granular)</h1>
        <p class="text-sm text-gray-600">
            Atur secara spesifik fitur apa saja yang bisa diakses oleh setiap role. Admin selalu memiliki akses penuh tanpa batas.
        </p>
    </div>

    <form action="{{ route('admin.settings.accessibility.save') }}" method="POST">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Role Info -->
            <div class="bg-gray-50 border-b border-gray-200 p-4 hidden md:flex gap-4">
                <div class="flex-1 text-sm text-gray-700 font-medium tracking-wide uppercase">Fitur & Aktivitas</div>
                @foreach($roles as $roleKey => $roleLabel)
                    @if($roleKey !== 'admin')
                        <div class="w-24 text-center font-bold text-[#47663D]">{{ $roleLabel }}</div>
                    @endif
                @endforeach
            </div>

            <!-- Accordion List -->
            <div class="divide-y divide-gray-100">
                @foreach($features as $menuKey => $menuData)
                    <div x-data="{ open: false }" class="bg-white">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition focus:outline-none border-b sm:border-b-0 border-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#47663D]/10 text-[#47663D] flex items-center justify-center text-lg">
                                    <i class="{{ $menuData['icon'] ?? 'fas fa-folder' }}"></i>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-gray-900">{{ $menuData['label'] }}</h3>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Modul Utama</p>
                                </div>
                            </div>
                            <i class="fas" :class="open ? 'fa-chevron-up text-[#47663D]' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        
                        <div x-show="open" x-collapse>
                            <div class="p-0 sm:p-4 bg-gray-50/30">
                                <div class="sm:border sm:rounded-xl overflow-hidden bg-white shadow-sm sm:shadow-none">
                                    <table class="w-full text-sm text-left border-collapse">
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($menuData['actions'] as $actionKey => $actionLabel)
                                                @php $fullKey = $menuKey . '.' . $actionKey; @endphp
                                                <tr class="flex flex-col md:table-row hover:bg-gray-50/50">
                                                    <td class="py-4 px-4 text-gray-700 bg-gray-50/50 md:bg-transparent border-b md:border-b-0 border-gray-100">
                                                        <span class="font-bold text-gray-900 md:font-medium md:text-gray-700">{{ $actionLabel }}</span>
                                                        <div class="text-[10px] sm:text-xs text-gray-400 mt-0.5 font-mono">ID: {{ $fullKey }}</div>
                                                    </td>
                                                    
                                                    @foreach($roles as $roleKey => $roleLabel)
                                                        @if($roleKey !== 'admin')
                                                            @php
                                                                $row = $existing[$roleKey][$fullKey] ?? null;
                                                                $checked = $row ? (bool) $row->allowed : false;
                                                            @endphp
                                                            <td class="py-3 px-4 md:w-24 border-l-0 md:border-l border-gray-100 flex justify-between items-center md:table-cell hover:bg-gray-50 sm:hover:bg-transparent">
                                                                <span class="md:hidden text-xs font-semibold text-gray-600 tracking-wider uppercase">{{ $roleLabel }}</span>
                                                                <label class="inline-flex items-center cursor-pointer">
                                                                    <input type="checkbox" name="rules[{{ $roleKey }}][{{ str_replace('.', '_', $fullKey) }}]" value="1" {{ $checked ? 'checked' : '' }} class="sr-only peer">
                                                                    <div class="relative w-12 h-6 sm:w-11 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#47663D]"></div>
                                                                </label>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-[#47663D] text-white rounded-lg shadow-sm hover:bg-[#3d5734] font-medium transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Aksesibilitas
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

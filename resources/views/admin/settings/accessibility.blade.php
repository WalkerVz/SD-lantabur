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

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-lg flex items-center gap-3">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.accessibility.save') }}" method="POST">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Role Info -->
            <div class="bg-gray-50 border-b border-gray-200 p-4 flex gap-4">
                <div class="flex-1 text-sm text-gray-700 font-medium">Pengaturan Akses Berdasarkan Role:</div>
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
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition focus:outline-none">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#47663D]/10 text-[#47663D] flex items-center justify-center">
                                    <i class="{{ $menuData['icon'] ?? 'fas fa-folder' }}"></i>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-semibold text-gray-800">{{ $menuData['label'] }}</h3>
                                </div>
                            </div>
                            <i class="fas" :class="open ? 'fa-chevron-up text-[#47663D]' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        
                        <div x-show="open" x-collapse>
                            <div class="p-4 pt-0 pb-6 bg-gray-50/50">
                                <div class="border rounded-lg overflow-hidden bg-white">
                                    <table class="w-full text-sm text-left">
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($menuData['actions'] as $actionKey => $actionLabel)
                                                @php $fullKey = $menuKey . '.' . $actionKey; @endphp
                                                <tr class="hover:bg-gray-50/50">
                                                    <td class="py-3 px-4 text-gray-700">
                                                        <span class="font-medium">{{ $actionLabel }}</span>
                                                        <div class="text-xs text-gray-400 mt-0.5">Kode: {{ $fullKey }}</div>
                                                    </td>
                                                    
                                                    @foreach($roles as $roleKey => $roleLabel)
                                                        @if($roleKey !== 'admin')
                                                            @php
                                                                $row = $existing[$roleKey][$fullKey] ?? null;
                                                                $checked = $row ? (bool) $row->allowed : false;
                                                            @endphp
                                                            <td class="py-3 px-4 w-24 text-center border-l border-gray-50">
                                                                <label class="inline-flex items-center cursor-pointer">
                                                                    <input type="checkbox" name="rules[{{ $roleKey }}][{{ str_replace('.', '_', $fullKey) }}]" value="1" {{ $checked ? 'checked' : '' }} class="sr-only peer">
                                                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#47663D]"></div>
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

@extends('admin.layouts.admin')

@section('title', 'Pengaturan Accessibility')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Pengaturan Akses Fitur</h1>
        <p class="text-sm text-gray-600">
            Atur fitur apa saja yang bisa diakses oleh setiap role. Admin selalu memiliki akses penuh.
        </p>
    </div>

    <form action="{{ route('admin.settings.accessibility.save') }}" method="POST" class="bg-white rounded-xl shadow border border-gray-100 p-6">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Fitur</th>
                        @foreach($roles as $roleKey => $roleLabel)
                            <th class="px-3 py-2 text-center font-semibold text-gray-700">{{ $roleLabel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($features as $featureKey => $featureLabel)
                        <tr class="border-b border-gray-100">
                            <td class="px-3 py-2">{{ $featureLabel }}</td>
                            @foreach($roles as $roleKey => $roleLabel)
                                @php
                                    $checked = false;
                                    if ($roleKey === 'admin') {
                                        $checked = true;
                                    } else {
                                        $row = $existing[$roleKey][$featureKey] ?? null;
                                        $checked = $row ? (bool) $row->allowed : false;
                                    }
                                @endphp
                                <td class="px-3 py-2 text-center">
                                    @if($roleKey === 'admin')
                                        <span class="inline-flex items-center justify-center px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                            Selalu aktif
                                        </span>
                                    @else
                                        <input type="checkbox"
                                               name="rules[{{ $roleKey }}][{{ $featureKey }}]"
                                               value="1"
                                               {{ $checked ? 'checked' : '' }}
                                               class="h-4 w-4 text-[#47663D] border-gray-300 rounded focus:ring-[#47663D]">
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium text-sm">
                Simpan Pengaturan
            </button>
        </div>
    </form>

    <p class="text-xs text-gray-500">
        Pengaturan ini digunakan untuk mengontrol tampilan menu bagi role non-admin. Pembatasan level lanjut (misalnya per-halaman)
        dapat ditambahkan kemudian sesuai kebutuhan.
    </p>
</div>
@endsection


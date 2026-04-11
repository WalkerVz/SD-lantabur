<?php

namespace App\Http\Middleware;

use App\Models\FeatureAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    protected array $featureMap = [
        'admin.settings.accessibility' => 'settings.accessibility',
        'admin.sdm.'                   => 'sdm',
        'admin.struktur.'             => 'sdm',
        'admin.siswa.'                => 'siswa',
        'admin.pembayaran.'           => 'pembayaran',
        'admin.raport.'               => 'raport',
        'admin.mapel.'                => 'mapel',
        'admin.news.'                 => 'halaman_depan',
        'admin.gallery.'              => 'halaman_depan',
        'admin.slider.'               => 'halaman_depan',
        'admin.video.'                => 'halaman_depan',
        'admin.settings.'             => 'settings',
        'admin.dashboard'             => 'dashboard',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user    = Auth::user();
        $feature = $this->resolveFeature($request->route()->getName());

        // Jika route ini terkait sebuah feature, cek izin akses
        if ($feature !== null && ! FeatureAccess::can($user->role ?? 'guru', $feature)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }

    protected function resolveFeature(?string $routeName): ?string
    {
        if ($routeName === null) {
            return null;
        }

        foreach ($this->featureMap as $prefix => $feature) {
            if (str_starts_with($routeName, $prefix)) {
                return $feature;
            }
        }

        return null; 
    }
}

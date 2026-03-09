<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Helper to get setting value by key
     */
    public static function getVal($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Helper to get properly formatted WhatsApp Link
     * Converts "0812-3456-7890" -> "https://wa.me/6281234567890"
     */
    public static function getWaLink($key = 'contact_phone', $defaultPhone = '0822-8835-9565')
    {
        $phone = self::getVal($key, $defaultPhone);
        
        // Remove spaces, hyphens, and other non-numeric chars
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if it starts with 0 to replace with 62 for WA API
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }
        
        return 'https://wa.me/' . $cleanPhone;
    }
}

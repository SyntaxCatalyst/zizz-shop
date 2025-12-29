<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Daftarkan semua kolom agar bisa diisi secara massal
    protected $fillable = [
        'okeconnect_merchant_id',
        'okeconnect_api_key',
        'qris_generator_codeqr',
        'support_whatsapp_number',
        'support_email',
        'support_instagram_url',
        'support_facebook_url',
        'support_telegram_username',
        'receipt_footer_text',
        'whatsapp_order_template',
        'pterodactyl_domain',
        'pterodactyl_api_key',
        'pterodactyl_egg_id',
        'pterodactyl_nest_id',
        'pterodactyl_location_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute; // <-- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_url',
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // /**
    //  * Mutator untuk field sementara 'image_link_input'.
    //  * Fungsi ini akan berjalan OTOMATIS setiap kali kita mencoba mengisi 'image_link_input'.
    //  */
    // protected function imageLinkInput(): Attribute
    // {
    //     return Attribute::make(
    //         set: function ($value) {
    //             // Jika ada nilai yang masuk ke 'image_link_input' dari form
    //             if ($value) {
    //                 // Langsung set atribut 'image_url' yang asli di database dengan nilai tersebut.
    //                 $this->attributes['image_url'] = $value;
    //             }
    //             // Kita return array kosong agar 'image_link_input' sendiri tidak disimpan ke database.
    //             return [];
    //         }
    //     );
    // }
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Niyat extends Model {
    protected $table = 'niyat';
    protected $fillable = ['type', 'title_en', 'arabic_text', 'transliteration', 'translation_en', 'translation_ur', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}
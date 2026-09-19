<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dua extends Model {
    protected $fillable = ['category_id', 'title_en', 'title_ur', 'arabic_text', 'transliteration', 'translation_en', 'translation_ur', 'reference', 'is_featured', 'is_active'];
    protected $casts    = ['is_featured' => 'boolean', 'is_active' => 'boolean'];
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
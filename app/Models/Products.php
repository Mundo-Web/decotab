<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
  use HasFactory;
  protected $fillable = [
    'producto',
    'precio',
    'descuento',
    'sku',
    'stock',
    'imagen',
    'imagen_2',
    'imagen_3',
    'imagen_4',
    'imagen_ambiente',
    'destacar',
    'recomendar',
    'atributes',
    'visible',
    'status',
    'extract',
    'description',
    'costo_x_art',
    'peso',
    'categoria_id',
    'subcategory_id',
    'color',
    'image_texture',
    'slug'
  ];

  public function categoria()
  {
    return Category::find($this->categoria_id);
  }

  public function subcategory()
  {
    return SubCategory::find($this->subcategory_id);
  }

  public function galeria()
  {
    return $this->hasMany(Galerie::class, 'product_id');
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'tags_xproducts', 'producto_id', 'tag_id');
  }

  public function scopeActiveDestacado($query)
  {
    return $query->where('status', true)->where('destacar', true);
  }

  public function attributeValues()
  {
    return $this->hasMany(AttributesValues::class, 'product_id');
  }

  public function attributes()
  {
    return $this->belongsToMany(Attributes::class, 'attribute_product_values', 'product_id', 'attribute_id')
      ->withPivot('attribute_value_id');
  }
}

<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return[
            'slug' => [
                'source' => 'name'        
            ]
        ];
    }

    public function scopeFilter($query,array $filters){
        // $query->when($filters['sc'] ?? false, function($query,$sc){
        //     return $query->where('slug','=',$sc);
        // });
        $query->when($filters['search'] ?? false, function($query,$search){
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        });
        $query->when($filters['sc'] ?? false, function($query,$sc){
            return $query->whereHas('subcategory',function($query) use ($sc){
                $query->where('slug',$sc);
            });
        });
    }
    
    

    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orderdetail(){
        return $this->hasMany(OrderDetail::class);
    }
}
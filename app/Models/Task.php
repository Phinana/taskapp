<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use App\Interfaces\SearchableInterface;

class Task extends Model implements Searchable
{
    use HasFactory;
    protected $fillable = [
        'title',
        'difficulty',
        'reward'
    ];

    public function getSearchResult(): SearchResult
     {
        $url = route('result_search', $this->slug);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
     }
}

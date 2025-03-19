<?php

declare(strict_types=1);

namespace App\Models;

use Shopper\Core\Models\Category as Model;
use Illuminate\Database\Eloquent\Builder;


class Category extends Model
{
    //
    public function scopeRoot( Builder $query): Builder
{
    return $query->whereNull('parent_id');
}

}

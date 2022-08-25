<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function posts($id) {
        $category = Category::findOrFail($id);

        return $category->posts;
    }
}

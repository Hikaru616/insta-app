<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryPost;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category) {

        $this->category = $category;
    }

    public function index() {

        $all_categories = $this->category->latest()->get();

        return view('admin.categories.index')
                ->with('all_categories',$all_categories);
    }

    public function store(Request $request) {

        $request->validate([
            'category' => 'required'
        ]);

        $this->category->name = $request->category;
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id) {

        $request->validate([
            'category'=>'required'
        ]);

        $category = $this->category->findOrFail($id);
        $category->name = $request->category;
        $category->save();

        return redirect()->back();
    }

    public function destroy($id) {

        $category = $this->category->findOrFail($id);
        $category->forcedelete();

        return redirect()->back();
    }


}

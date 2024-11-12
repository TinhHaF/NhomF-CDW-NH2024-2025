<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $subcategories = $query->paginate(10);
        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Hiển thị form để tạo danh mục con mới.
     */
    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục cha
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Lưu danh mục con mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:subcategories',
            'description' => 'nullable|string|max:100|unique:subcategories',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Danh mục con đã được tạo!');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục con.
     */
   
    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            $subcategory = Subcategory::findOrFail($decryptedId);
            $categories = Category::all();
            return view('admin.subcategories.edit', compact('subcategory', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('subcategories.index')
                ->with('error', 'ID không hợp lệ hoặc không tìm thấy danh mục con!');
        }
    }

    /**
     * Cập nhật thông tin danh mục con.
     */
    public function update(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);

            $request->validate([
                'name' => 'required|string|max:50|unique:subcategories,name,' . $decryptedId,
                'description' => 'nullable|string|max:100|unique:subcategories,description,',
                'category_id' => 'required|exists:categories,id',
            ]);

            $subcategory = Subcategory::findOrFail($decryptedId);
            $subcategory->update([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            return redirect()->route('subcategories.index')
                ->with('success', 'Danh mục con đã được cập nhật!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục con!')
                ->withInput();
        }
    }

    /**
     * Xóa danh mục con.
     */
    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            $subcategory = Subcategory::findOrFail($decryptedId);
            $subcategory->delete();

            return redirect()->route('subcategories.index')
                ->with('success', 'Danh mục con đã bị xóa!');
        } catch (\Exception $e) {
            return redirect()->route('subcategories.index')
                ->with('error', 'Có lỗi xảy ra khi xóa danh mục con!');
        }
    }
}

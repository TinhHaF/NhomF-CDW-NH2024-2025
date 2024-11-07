<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\QueryException;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Nếu có giá trị tìm kiếm, lọc theo tên danh mục và phân trang
        if ($search) {
            $categories = Category::where('name', 'like', '%' . $search . '%')->paginate(10);
        } else {
            // Nếu không có tìm kiếm, lấy tất cả danh mục và phân trang
            $categories = Category::paginate(10);
        }

        // Trả về view với các danh mục
        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validate đầu vào
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        // Tạo mới danh mục
        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        // Giải mã ID
        try {
            $id = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'ID không hợp lệ.');
        }

        // Tìm kiếm theo ID đã giải mã
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Danh mục không tồn tại.');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'ID không hợp lệ.');
        }

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Danh mục không tồn tại.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        try {
            $category->update($validated);

            return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()
                    ->withErrors(['name' => 'Tên danh mục này đã tồn tại.'])
                    ->withInput();
            }

            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'ID không hợp lệ.');
        }

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Danh mục không tồn tại.');
        }

        if ($category->posts()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Không thể xóa danh mục vì có bài viết liên quan.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công.');
    }
    public function show($id)
    {
        // Tìm kiếm danh mục theo ID
        $category = Category::find($id);

        // Kiểm tra nếu danh mục không tồn tại
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Lỗi!');
        }

        // Trả về view chi tiết danh mục
        return view('admin.categories.index', compact('category'));
    }
}

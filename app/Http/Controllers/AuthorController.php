<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors); // Trả về danh sách tác giả
    }
}

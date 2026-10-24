<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View|string
    {
        return view('account.wishlist', [
            'products' => $request->user()->wishlist()->with('category')->paginate(12),
        ])->fragmentIf(ProductController::wantsNextChunk($request), 'infinite');
    }
}

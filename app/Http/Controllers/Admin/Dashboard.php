<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Attribute;
use App\Models\Variant;
use App\Models\Brands;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function workout_videos()
    {
            $product = Product::all();
            return view('admin.product', compact('product'));
        
    }

    public function add_workout_video()
    {
        $uploadedFileUrl = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();
        return view('admin.product-add', compact('category', 'variants', 'attributes', 'brands', 'country', 'subcategory'));
    }

    public function order()
    {
        $user = Auth::user();
        if ($user) {
            return view('admin.order');
        } else {
            return redirect('/admin/login');
        }
    }

    public function homepage()
    {
        $homepage = DB::table('homepage')->where('homepage_id', 1)->first();
        return view('admin.homepage', compact('homepage'));
    }

    public function category()
    {
        $category = Category::all()->sortBy('categories_id');
        return view('admin.category', compact('category'));
    }

    public function sub_category()
    {
        $subcategory = Sub_category::join('categories', 'categories_id', 'sub_cateogry_category_id')->get();
        return view('admin.sub-category', compact('subcategory'));
    }

    public function add_new_category()
    {
        return view('admin.category-add');
    }

    public function add_new_sub_category()
    {
        $category = Category::all()->sortBy('categories_id');
        return view('admin.sub-category-add', compact('category'));
    }

    public function edit_category($id)
    {
        $category = DB::table('category')->where('category_id', $id)->first();
        return view('admin.edit-category', compact('category'));
    }

    public function attribute()
    {
        $user = Auth::user();
        if ($user) {
            $attribute = Attribute::all()->sortBy('attribute_id');
            return view('admin.attribute', compact('attribute'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function add_attribute()
    {
        $user = Auth::user();
        if ($user) {
            return view('admin.add-attribute');
        } else {
            return redirect('/admin/login');
        }
    }

    public function edit_attribute($id)
    {
        $user = Auth::user();
        if ($user) {
            $attribute = Attribute::where('attribute_id', $id)->first();
            return view('admin.edit-attribute', compact('attribute'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function variant()
    {
        $user = Auth::user();
        if ($user) {
            $variant = DB::table('variant')->join('attribute', 'attribute_id', 'variant_attribute_id')->get();
            return view('admin.variant', compact('variant'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function add_variant()
    {
        $user = Auth::user();
        if ($user) {
            $attribute = Attribute::all()->sortBy('attribute_id');
            return view('admin.add-variant', compact('attribute'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function edit_variant($id)
    {
        $user = Auth::user();
        if ($user) {
            $attribute = Attribute::all()->sortBy('attribute_id');
            $variant = Variant::where('variant_id', $id)->first();
            return view('admin.edit-variant', compact('attribute', 'variant'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function subscribers()
    {
        $user = Auth::user();
        if ($user) {
            $subscribers = Newssubscribers::all()->sortBy('newsletter_id');
            return view('admin.subscribers', compact('subscribers'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function orders()
    {
        $user = Auth::user();
        if ($user) {
            $order = DB::table('order')
                ->join('order_item', 'order_item_order_id', 'order_id')
                ->join('product', 'product_id', 'order_item_product_id')
                ->get();
            return view('admin.order', compact('order'));
        } else {
            return redirect('/admin/login');
        }
    }

    public function order_view($id)
    {
        $order = DB::table('order')->where('order_id', $id)->first();
        $order_item = DB::table('order_item')->where('order_item_order_id', $id)->get();
        foreach ($order_item as $items) {
            $products[] = DB::table('product')->where('product_id', $items->order_item_product_id)->get();
        }
        $product = $products;
        return view('admin.invoice', compact('order', 'product'));
    }

    public function gallery()
    {
        $gallery = DB::table('gallery')->orderBy('gallery_id', 'DESC')->where('gallery_id', '!=', 1)->get();
        return view('admin.gallery', compact('gallery'));
    }

    public function gift()
    {
        $gifts = DB::table('gift')->orderBy('gift_id', 'DESC')->get();
        return view('admin.gifts', compact('gifts'));
    }

    public function add_gift()
    {
        return view('admin.add-gift');
    }

    public function edit_gift()
    {
        return view('admin.edit-gift');
    }

    public function brand()
    {
        $brands = Brands::all();
        return view('admin.brands', compact('brands'));
    }

    public function store_brand()
    {
        return view('admin.add-brand');
    }

    public function global()
    {
        $user = Auth::user();
        if ($user) {
            $global_setting = DB::table('global_setting')->where('global_setting_id', '1')->first();
            return view('admin.global', compact('global_setting'));
        } else {
            return redirect('/admin/login');
        }
    }
}

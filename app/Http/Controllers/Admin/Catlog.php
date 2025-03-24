<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Variant;
use App\Models\Product_variant;
use App\Models\Gift;
use App\Models\Sub_category;
use App\Models\Brands;
use App\Models\Gallery;

class Catlog extends Controller
{
    public function store_product(Request $request)
    {
        $product = new Product();

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $filess = [];
            foreach ($files as $file) {
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('storage/products/'), $filename);
                $filess[] = $filename;
            }
            $product->product_images = json_encode($filess);
        }

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_short_description = $request->product_short_description;
        $product->product_sku = $request->product_sku;
        $product->product_brand = $request->product_brand_id;
        $product->product_category = $request->product_category;
        $product->product_sub_category_id = $request->product_sub_category_id;
        $product->product_brand = $request->product_brand;
        $product->product_country = $request->product_country;
        $product->product_price = $request->product_price;
        $product->product_discounted_price = $request->product_discounted_price;
        $product->product_status = $request->product_status;
        $saved = $product->save();
        $id = $product->product_id;
        $variant = $request->product_variant;
        if (!empty($variant)) {
            foreach ($variant as $variants) {
                $productvariant = new Product_variant();
                $productvariant->product_variant_variant_id = $variants;
                $productvariant->product_variant_product_id = $id;
                $productvariant->save();
            }
        }
        if ($saved) {
            return redirect()->back()->with('success', 'Your Product is Successfully Added');
        } else {
            return redirect()->back()->with('error', 'Oops Error!');
        }
    }

    public function edit_product(Request $request, $id)
    {
        $product = Product::find($id);

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $filess = [];
            foreach ($files as $file) {
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('storage/products/'), $filename);
                $filess[] = $filename;
            }
            $product->product_images = json_encode($filess);
        }

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_short_description = $request->product_short_description;
        $product->product_sku = $request->product_sku;
        $product->product_brand = $request->product_brand;
        $product->product_category = $request->product_category;
        $product->product_brand = $request->product_brand;
        $product->product_country = $request->product_country;
        $product->product_price = $request->product_price;
        $product->product_discounted_price = $request->product_discounted_price;
        $product->product_status = $request->product_status;
        $saved = $product->save();

        $oldvariant = DB::table('product_variant')->where('product_variant_product_id', $id)->delete();
        $variant = $request->product_variant;
        if (isset($variant)) {
            foreach ($variant as $variants) {
                $productvariant = new Product_variant();
                $productvariant->product_variant_variant_id = $variants;
                $productvariant->product_variant_product_id = $id;
                $productvariant->save();
            }
        }

        if ($saved) {
            return redirect()->back()->with('success', 'Your Product is Successfully Updated!');
        } else {
            return redirect()->back()->with('error', 'Oops Error!');
        }
    }

    public function store_category(Request $request)
    {
        $category = new Category();
        if ($request->hasfile('category_image')) {
            $imageName = time() . '.' . $request->category_image->extension();
            $request->category_image->move(public_path('storage/category'), $imageName);
            $category->categories_image = $imageName;
        }

        $category->categories_name = $request->category_name;
        $saved = $category->save();
        if ($saved) {
            return redirect()->back()->with('success', "Successfully Added New Category");
        } else {
            return redirect()->back()->with('error', "Oops! System is Hot");
        }
    }

    public function edit_category(Request $request, $id)
    {
        $category = Category::find($id);
        if ($request->hasfile('category_image')) {
            $imageName = time() . '.' . $request->category_image->extension();
            $request->category_image->move(public_path('storage/category'), $imageName);
            $category->categories_image = $imageName;
        }
        $category->categories_name = $request->category_name;

        $saved = $category->save();
        if ($saved) {
            return redirect()->back()->with('success', "Successfully Updated Category");
        } else {
            return redirect()->back()->with('error', "Oops! System is Hot");
        }
    }

    public function store_sub_category(Request $request)
    {
        $category = new Sub_category();
        $category->sub_cateogry_name = $request->sub_cateogry_name;
        $category->sub_cateogry_category_id = $request->sub_cateogry_category_id;
        $saved = $category->save();
        if ($saved) {
            return redirect()->back()->with('success', "Successfully Added New Sub Category");
        } else {
            return redirect()->back()->with('error', "Oops! System is Hot");
        }
    }

    public function store_attribute(Request $request)
    {
        $attribute = new Attribute();
        $attribute->attribute_name = $request->attribute_name;
        $attribute->attribute_type = $request->attribute_type;
        $save = $attribute->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Attribute Added');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function edit_attribute(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        $attribute->attribute_name = $request->attribute_name;
        $attribute->attribute_type = $request->attribute_type;
        $attribute->attribute_updated_by = Auth::id();
        $save = $attribute->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Attribute Updated');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function store_variant(Request $request)
    {
        $variant = new Variant();
        $variant->variant_name = $request->variant_name;
        $variant->variant_price = $request->variant_price;
        $variant->variant_sku = $request->variant_sku;
        $variant->variant_attribute_id = $request->variant_attrbuite_id;

        $save = $variant->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Variant Added');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function edit_variant(Request $request, $id)
    {
        $variant = Variant::find($id);
        $variant->variant_name = $request->variant_name;
        $variant->variant_price = $request->variant_price;
        $variant->variant_sku = $request->variant_sku;
        $variant->variant_attrbuite_id = $request->variant_attrbuite_id;
        $variant->variant_updated_by = Auth::id();
        $save = $variant->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Variant Updated!');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function add_gift(Request $request)
    {
        $gift = new Gift();
        $gift->gift_code = $request->gift_code;
        $gift->gift_discount = $request->gift_discount;
        $gift->gift_expirty = $request->gift_expirty;

        if ($request->hasfile('gift_image')) {
            $giftimage = time() . '.' . $request->gift_image->extension();
            $request->gift_image->move(public_path('storage/gift'), $giftimage);
            $gift->gift_image = $giftimage;
        }

        $save = $gift->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Gift Added!');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function edit_gift(Request $request, $id)
    {
        $gift = Gift::find($id);
        $gift->gift_code = $request->gift_code;
        $gift->gift_discount = $request->gift_discount;
        $gift->gift_expirty = $request->gift_expirty;

        if ($request->hasfile('gift_image')) {
            $giftimage = time() . '.' . $request->gift_image->extension();
            $request->gift_image->move(public_path('storage/gift'), $giftimage);
            $gift->gift_image = $giftimage;
        }

        $save = $gift->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Gift Added!');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function store_brand(Request $request)
    {
        $brand = new Brands();

        if ($request->hasfile('brands_image')) {
            $giftimage = time() . '.' . $request->gift_image->extension();
            $request->gift_image->move(public_path('storage/brand'), $giftimage);
            $brand->brands_image = $giftimage;
        }
        $brand->brands_name = $request->brands_name;

        $save = $brand->save();
        if ($save == 'true') {
            return redirect()->back()->with('success', 'Brand Added!');
        } else {
            return redirect()->back()->with('error', 'Error in Submitting');
        }
    }

    public function destroy($id)
    {
        $Product = Product::find($id);

        $Product->delete();

        return redirect()->back()->with('success', 'Product Deleted!');
    }

    public function destroy_gift($id)
    {
        $Gift = Gift::find($id);

        $Gift->delete();

        return redirect()->back()->with('success', 'Gift Card Deleted!');
    }


    public function post_gallery(Request $request){
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $gallery = new Gallery();
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('storage/gallery/'), $filename);
                $gallery->gallery_media = $filename;
                $gallery->save();
            }
        }
        return redirect()->back()->with('success', 'Gallery Added!');
    }
}

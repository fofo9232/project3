<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Brand;
use App\User;
use Auth;
use Session;
use Newsletter;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home(){

        $featured=Product::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();
        
        $banners=Banner::where('status','active')->limit(3)->orderBy('id','DESC')->get();
        
        $products=Product::where('status','active')->orderBy('id','DESC')->limit(8)->get();
        $category=Category::where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();
        
        return view('frontend.index')

                ->with('banners',$banners)
                ->with('product_lists',$products)
                ->with('category_lists',$category);
    }

    public function productCategory($slug){

        $categories= Category::with('products')->where('slug',$slug)->first();
        return view('frontend.pages.product-lists')->with('categories',$categories);
    }
}

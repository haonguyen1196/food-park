<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::where('status', 1)->latest()->get();

        //get section title
        $titles = $this->getSectionTitle();
        $whyChooseUs = WhyChooseUs::where('status', 1)->latest()->get();

        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->latest()->get();

        $dailyOffers = DailyOffer::with('product')->where('status', 1)->take(15)->latest()->get();

        return view('frontend.home.index', compact('sliders', 'titles', 'whyChooseUs', 'categories', 'dailyOffers'));
    }

    public function getSectionTitle()
    {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title'
        ];
        $titles = SectionTitle::whereIn('key', $keys)->get()->pluck('value', 'key');

        return $titles;
    }

    public function showProduct(string $slug) : View
    {
        $product = Product::with('productImages', 'productSizes', 'productOptions')->where(['slug' => $slug, 'status' => 1])->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('status', 1)
        ->take(8)->latest()->get();
        return view('frontend.pages.product-view', compact('product' , 'relatedProducts'));
    }

    public function loadProductModal($productId)
    {
        $product = Product::with( 'productSizes', 'productOptions')->where('id', $productId)->firstOrFail();
        return view('frontend.layouts.ajax-files.product-popup-modal', compact('product'))->render();
    }
}

<?php
 
 namespace App\Http\Controllers;
 
 use Illuminate\Http\Request;
 use App\Models\Product;
 use App\Models\Category;

 
 class ShopController extends Controller
 {
    
    public function index(Request $request)
{
    // Variables par défaut pour les produits et catégories
    $products = Product::orderBy('created_at','DESC')->paginate(12);
    $o_column = "";
    $o_order = "";
    $order = $request->query('order') ? $request->query('order') : -1;
    $categories = Category::orderBy('name','ASC')->get();
    
    // Récupération des filtres
    $f_categories = $request->query('categories');
    $min_price = $request->query('min') ? $request->query('min') : 1;
    $max_price = $request->query('max') ? $request->query('max') : 500;
    $f_color = $request->query('color');  // Nouveau paramètre pour la couleur
    
    // Gestion de l'ordre des produits
    switch ($order) {
        case 1:
            $o_column = 'created_at';
            $o_order = 'DESC';
            break;
        case 2:
            $o_column = 'created_at';
            $o_order = 'ASC';
            break;
        case 3:
            $o_column = 'regular_price';
            $o_order = 'ASC';
            break;
        case 4:
            $o_column = 'regular_price';
            $o_order = 'DESC';
            break;
        default:
            $o_column = 'id';
            $o_order = 'DESC';
    }

    // Filtrage des produits selon les critères
    $products = Product::where(function($query) use ($f_categories) {
        $query->whereIn('category_id', explode(',', $f_categories))
              ->orWhereRaw("'" . $f_categories . "' = ''");
    })
    ->where(function($query) use($min_price, $max_price) {
        $query->whereBetween('regular_price', [$min_price, $max_price])
              ->orWhereBetween('sale_price', [$min_price, $max_price]);
    })
    ->where(function($query) use($f_color) {
        if ($f_color) {
            $query->where('color', $f_color);  // Filtrer par couleur
        }
    })
    ->orderBy($o_column, $o_order)
    ->paginate(12);
    
    // Retourner la vue avec les filtres appliqués
    return view('shop', compact("products", "order", "f_categories", "categories", "min_price", "max_price", "f_color"));
}
 public function product_details($product_slug)
{
    $product = Product::where("slug",$product_slug)->first();
    $rproducts = Product::where("slug","<>",$product_slug)->get()->take(8);
    return view('details',compact("product","rproducts"));
}

}
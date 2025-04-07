<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::instance('cart')->content();
        return view('cart',compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        Cart::instance('cart')->add($request->id,$request->name,$request->quantity,$request->price)->associate('App\Models\Product');        
            
        return redirect()->back()->with('success', 'Product is Added to Cart Successfully!');
    
    }
public function increase_item_quantity($rowId)
{
    $product = Cart::instance('cart')->get($rowId);
    $qty = $product->qty + 1;
    Cart::instance('cart')->update($rowId,$qty);
    return redirect()->back();
}
public function reduce_item_quantity($rowId){
    $product = Cart::instance('cart')->get($rowId);
    $qty = $product->qty - 1;
    Cart::instance('cart')->update($rowId,$qty);
    return redirect()->back();
}
public function remove_item_from_cart($rowId)
{
    Cart::instance('cart')->remove($rowId);
    return redirect()->back();
}
public function empty_cart()
{
    Cart::instance('cart')->destroy();
    return redirect()->back();
}
public function checkout()
{
    if(!Auth::check())
    {
        return redirect()->route("login");
    }
    $address = Address::where('user_id',Auth::user()->id)->where('isdefault',1)->first();              
    return view('checkout',compact("address"));
}
public function place_order(Request $request)
{
    $user_id = Auth::user()->id;
    $address = Address::where('user_id',$user_id)->where('isdefault',true)->first();

    if(!$address) {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'zip' => 'required|numeric|digits:6',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required'           
        ]);

        // Création d'un nouvel address si aucun n'existe
        $address = new Address();    
        $address->user_id = $user_id;    
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = '';
        $address->isdefault = true;
        $address->save();
    }

    $this->setAmountForCheckout();

  // Création de la commande
$order = new Order();
$order->user_id = $user_id;

// Get the checkout session data
$checkout = session()->get('checkout', []);

// Ensure the required data exists before using it
$order->subtotal = $checkout['subtotal'] ?? 0; // Default to 0 if not set
$order->discount = $checkout['discount'] ?? 0; // Default to 0 if not set
$order->tax = $checkout['tax'] ?? 0; // Default to 0 if not set
$order->total = $checkout['total'] ?? 0; // Default to 0 if not set

// Order address details
$order->name = $address->name;
$order->phone = $address->phone;
$order->locality = $address->locality;
$order->address = $address->address;
$order->city = $address->city;
$order->state = $address->state;
$order->country = $address->country;
$order->landmark = $address->landmark;
$order->zip = $address->zip;

$order->save();
              

    // Ajouter les éléments de commande
    foreach(Cart::instance('cart')->content() as $item) {
        $orderitem = new OrderItem();
        $orderitem->product_id = $item->id;
        $orderitem->order_id = $order->id;
        $orderitem->price = $item->price;
        $orderitem->quantity = $item->qty;
        $orderitem->save();                   
    }

    // Gestion des modes de paiement
    if($request->mode == "card") {
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = "pending"; // Le statut est "pending" jusqu'à ce que le paiement soit effectué
        $transaction->save();
        // Logique de paiement par carte ici
        // Exemple : appel à une API pour traiter le paiement
    }
    elseif($request->mode == "paypal") {
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = "pending"; // Le statut est "pending" jusqu'à ce que le paiement soit effectué
        $transaction->save();
        // Logique de paiement PayPal ici
        // Exemple : appel à une API PayPal pour traiter le paiement
    }
    elseif($request->mode == "cod") {
        // Mode de paiement à la livraison (Cash on Delivery)
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = "pending"; // Le statut est "pending" jusqu'à ce que le paiement soit effectué
        $transaction->save();
    }

    // Vider le panier et les sessions associées
    Cart::instance('cart')->destroy();
    session()->forget('checkout');
    session()->forget('coupon');
    session()->forget('discounts');
    session()->put('order_id', $order->id);

    // Rediriger vers la confirmation de commande
    return redirect()->route('cart.confirmation');
}

public function setAmountForCheckout()
{ 
    if (!Cart::instance('cart')->count()) {
        session()->forget('checkout');
        return false;
    }    

    if (session()->has('coupon')) {
        session()->put('checkout', [
            'discount' => session()->get('discounts')['discount'] ?? 0,
            'subtotal' => session()->get('discounts')['subtotal'] ?? 0,
            'tax' => session()->get('discounts')['tax'] ?? 0,
            'total' => session()->get('discounts')['total'] ?? 0
        ]);
    } else {
        session()->put('checkout', [
            'discount' => 0,
            'subtotal' => floatval(Cart::instance('cart')->subtotal()),
            'tax' => floatval(Cart::instance('cart')->tax()),
            'total' => floatval(Cart::instance('cart')->total())
        ]);
    }

    return true;
}
public function confirmation()
{   
    if(session()->has('order_id'))
    {
        $order=Order::find(session()->get('order_id'));
        return view('order-confirmation',compact('order'));

    }
    return redirect()->route('cart.index');
}

    
}

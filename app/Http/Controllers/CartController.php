<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;




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
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
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

            $address = Address::create([
                'user_id' => $user_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'zip' => $request->zip,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'locality' => $request->locality,
                'landmark' => $request->landmark,
                'isdefault' => true
            ]);
        }

        $this->setAmountForCheckout();

        if (!session()->has('checkout')) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty or session expired.');
        }

        $order = Order::create([
            'user_id' => $user_id,
            'subtotal' => session('checkout.subtotal', 0),
            'discount' => session('checkout.discount', 0),
            'tax' => session('checkout.tax', 0),
            'total' => session('checkout.total', 0),
            'name' => $address->name,
            'phone' => $address->phone,
            'locality' => $address->locality,
            'address' => $address->address,
            'city' => $address->city,
            'state' => $address->state,
            'country' => $address->country,
            'landmark' => $address->landmark,
            'zip' => $address->zip,
        ]);

        foreach (Cart::instance('cart')->content() as $item) {
            OrderItem::create([
                'product_id' => $item->id,
                'order_id' => $order->id,
                'price' => $item->price,
                'quantity' => $item->qty,
            ]);
        }

        if ($request->mode == "paypal") {
            try {
                \Log::info('PayPal config:', config('paypal'));
                $provider = new PayPalClient();
                $provider->setApiCredentials(config('paypal'));
                
                // Get PayPal Access Token (Not Order Token)
                $paypalToken = $provider->getAccessToken();  // This is the correct token needed for authorization
    
                \Log::info('PayPal Access Token:', ['token' => $paypalToken]);
                $paypalOrder = $provider->createOrder([
                    "intent" => "CAPTURE",  // ✅ This should be "CAPTURE"
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => session()->get('checkout')['total']
                            ]
                        ]
                    ],
                    "payment_method" => [
                                "payee_preferred"=> "UNRESTRICTED" ,
                    ],
                    "application_context" => [
                        'return_url' => route('cart.paypal.success'),
                        'cancel_url' => route('cart.paypal.cancel'),
                    ]
                ]);

                session()->put('order_id', $order->id);
                \Log::info('PayPal Order Response:', $paypalOrder);
    
                // Find the approval URL
                $approvalUrl = null;
                if (isset($paypalOrder['links'])) {
                    foreach ($paypalOrder['links'] as $link) {
                        if ($link['rel'] === 'approve') {
                            $approvalUrl = $link['href'];
                            break;
                        }
                    }
                }
    
                // Debugging: Log the approval URL
                \Log::info('approval url:', ['approvalUrl' => $approvalUrl]);
    
                // Ensure redirection happens
                if ($approvalUrl) {
                    return redirect()->away($approvalUrl);
                } else {
                    return back()->with('error', 'PayPal approval URL not found.');
                }
    
            } catch (\Exception $e) {
                \Log::error('PayPal Order Creation Error: ' . $e->getMessage());
                return back()->with('error', 'PayPal Error: ' . $e->getMessage());
            }
        
    
        }
        elseif($request->mode =="card"){
            Stripe::setApiKey(env('STRIPE_SECRET'));
        try{
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $this->card_no,
                    'exp_month' => $this->exp_month,
                    'exp_year' => $this->exp_year,
                    'cvc' => $this->cvc
                ]
            ]);
            if(!isset($token['id']))
            {
                session()->flash('stripe_error','The stripe token was not generated correctly!');
                $this->thankyou = 0;
            }
            $customer = $stripe->customers()->create([
                'name' => $this->firstname . ' ' . $this->lastname,
                'email' =>$this->email,
                'phone' =>$this->mobile,
                'address' => [
                    'line1' =>$this->line1,
                    'postal_code' => $this->zipcode,
                    'city' => $this->city,
                    'state' => $this->province,
                    'country' => $this->country
                ],
                'shipping' => [
                    'name' => $this->firstname . ' ' . $this->lastname,
                    'address' => [
                        'line1' =>$this->line1,
                        'postal_code' => $this->zipcode,
                        'city' => $this->city,
                        'state' => $this->province,
                        'country' => $this->country
                    ],
                ],
                'source' => $token['id']
            ]);
            $charge = $stripe->charges()->create([
                'customer' => $customer['id'],
                'currency' => 'USD',
                'amount' => session()->get('checkout')['total'],
                'description' => 'Payment for order no ' . $order->id
            ]);
            if($charge['status'] == 'succeeded')
            {
                $this->makeTransaction($order->id,'approved');
                $this->resetCart();
            }
            else
            {
                session()->flash('stripe_error','Error in Transaction!');
                $this->thankyou = 0;
            }
        } catch(Exception $e){
            session()->flash('stripe_error',$e->getMessage());
            $this->thankyou = 0;
        }} 
        elseif ($request->mode == "cod") {
            Transaction::create([
                'user_id' => $user_id,
                'order_id' => $order->id,
                'mode' => 'cod',
                'status' => "pending"
            ]);
        }

        Cart::instance('cart')->destroy();
        session()->put('order_id', $order->id);

        return redirect()->route('cart.confirmation');
    }

    public function paypalSuccess(Request $request)
    {
        $orderId = session()->get('order_id'); 
    
        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Session expired. Order not found.');
        }
    
        $order = Order::where('user_id', Auth::id())->latest()->first();
        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }
        
    
        $token = $request->get('token');
        if (!$token) {
            return redirect()->route('cart.index')->with('error', 'Invalid PayPal token.');
        }
    
        $paypal = new PayPalClient();
        $paypal->setApiCredentials(config('paypal'));
    
        try {
            $accessToken = $paypal->getAccessToken();
            $response = $paypal->capturePaymentOrder($token);
    
            \Log::info('PayPal response: ', $response);
    
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $order->update(['status' => 'confirmed']);
                
                Transaction::create([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'mode' => 'paypal',
                    'status' => 'completed',
                    'transaction_id' => $response['id'] ?? null
                ]);
    
                // Clear cart session
                Cart::instance('cart')->destroy();
                session()->forget(['checkout', 'coupon', 'discounts']);
    
                return view('order-confirmation', compact('order'));
            } else {
                return redirect()->route('cart.index')->with('error', 'Payment failed or was not completed.');
            }
        } catch (\Exception $e) {
            \Log::error('Error during PayPal capture: ' . $e->getMessage());
            return redirect()->route('cart.checkout')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    

    


    public function paypalCancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment was canceled.');
    }

    public function confirmation()
    {
        if (!session()->has('order_id')) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        $order = Order::find(session()->get('order_id'));

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        return view('order-confirmation', compact('order'));
    }

    public function setAmountForCheckout()
    { 
        if (!Cart::instance('cart')->count() > 0) {
            session()->forget('checkout');
            return;
        }    

        session()->put('checkout', [
            'discount' => session()->get('discounts')['discount'] ?? 0,
            'subtotal' => Cart::instance('cart')->subtotal(),
            'tax' => Cart::instance('cart')->tax(),
            'total' => Cart::instance('cart')->total()
        ]);
    }
}
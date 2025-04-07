<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Order;  
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Drivers\GD\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
        {   
            $orders=Order::orderby('created_at','DESC')->get()->take(10);
            $dashboardDatas=DB::select("SELECT 
                                    SUM(total) AS TotalAmount,
                                    SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                                    SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                                    SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount,
                                    COUNT(*) AS Total,
                                    SUM(IF(status = 'ordered', 1, 0)) AS TotalOrdered,
                                    SUM(IF(status = 'delivered', 1, 0)) AS TotalDelivered,
                                    SUM(IF(status = 'canceled', 1, 0)) AS TotalCanceled
                                FROM 
                                    Orders;
                            ");
            $monthlyDatas=DB::select("SELECT 
                            M.id AS MonthNo,
                            M.name AS MonthName,
                            IFNULL(D.TotalAmount, 0) AS TotalAmount,
                            IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
                            IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                            IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
                        FROM 
                            month_names M
                        LEFT JOIN (
                            SELECT 
                                DATE_FORMAT(created_at, '%b') AS MonthName,
                                MONTH(created_at) AS MonthNo,
                                SUM(total) AS TotalAmount,
                                SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                                SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                                SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount
                            FROM 
                                Orders
                            WHERE 
                                YEAR(created_at) = YEAR(NOW())
                            GROUP BY 
                                YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                            ORDER BY 
                                MONTH(created_at)
                        ) D ON D.MonthNo = M.id;

                    ");   
                
            $AmountM=implode(',',collect($monthlyDatas)->pluck('TotalAmount')->toArray());
            $orderedAmountM=implode(',',collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
            $DeliveredAmountM=implode(',',collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
            $CanceledAmountM=implode(',',collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

                
            $TotalAmount=collect($monthlyDatas)->sum('TotalAmount');
            $TotalOrderedAmount=collect($monthlyDatas)->sum('TotalOrderedAmount');
            $TotalDeliveredAmount=collect($monthlyDatas)->sum('TotalDeliveredAmount');
            $TotalCanceledAmount=collect($monthlyDatas)->sum('TotalCanceledAmount');


            return view("admin.index",compact('orders','dashboardDatas','AmountM','orderedAmountM','DeliveredAmountM','CanceledAmountM','TotalAmount','TotalOrderedAmount','TotalDeliveredAmount','TotalCanceledAmount'));
        }

    public function products()
        {
            $products= Product::orderBy('created_at','desc')->paginate(10);
            return view ('admin.products',compact('products'));
        }

    public function add_product()
        {
            $categories = Category::Select('id','name')->orderBy('name')->get();
            return view("admin.product-add",compact('categories'));
        }

    public function product_store(Request $request)
        {
            $request->validate([
                'name'=>'required',
                'slug'=>'required|unique:products,slug',
                'category_id'=>'required',          
                'short_description'=>'required',
                'description'=>'required',
                'regular_price'=>'required',
                'sale_price'=>'required',
                'SKU'=>'required',
                'stock_status'=>'required',
                'featured'=>'required',
                'quantity'=>'required',
                'image'=>'required|mimes:png,jpg,jpeg|max:2048'            
            ]);
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->regular_price = $request->regular_price;
            $product->sale_price = $request->sale_price;
            $product->SKU = $request->SKU;
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;
            $product->quantity = $request->quantity;
            $current_timestamp = Carbon::now()->timestamp;
            if($request->hasFile('image'))
            {        
                if (File::exists(public_path('uploads/products').'/'.$product->image)) {
                    File::delete(public_path('uploads/products').'/'.$product->image);
                }
                if (File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)) {
                    File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
                }            
            
                $image = $request->file('image');
                $imageName = $current_timestamp.'.'.$image->extension();
                $this->GenerateThumbnailImage($image,$imageName);            
                $product->image = $imageName;
            }
            $gallery_arr = array();
            $gallery_images = "";
            $counter = 1;
            if($request->hasFile('images'))
            {
                $oldGImages = explode(",",$product->images);
                foreach($oldGImages as $gimage)
                {
                    if (File::exists(public_path('uploads/products').'/'.trim($gimage))) {
                        File::delete(public_path('uploads/products').'/'.trim($gimage));
                    }
                    if (File::exists(public_path('uploads/products/thumbails').'/'.trim($gimage))) {
                        File::delete(public_path('uploads/products/thumbails').'/'.trim($gimage));
                    }
                }
                $allowedfileExtension=['jpg','png','jpeg'];
                $files = $request->file('images');
                foreach($files as $file){                
                    $gextension = $file->getClientOriginalExtension();                                
                    $check=in_array($gextension,$allowedfileExtension);            
                    if($check)
                    {
                        $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;   
                        $this->GenerateThumbnailImage($file,$gfilename);                    
                        array_push($gallery_arr,$gfilename);
                        $counter = $counter + 1;
                    }
                }
                $gallery_images = implode(',', $gallery_arr);
            }
            $product->images = $gallery_images;
            $product->category_id = $request->category_id;
            $product->save();
            return redirect()->route('admin.products')->with('status', 'Product updated successfully!');
        }
        public function GenerateThumbnailImage($image, $imageName)
            {
                $destinationPath = public_path('uploads\products\thumbnails');
                $manager=new ImageManager(new Driver());
                $img=$manager->read($image->path());
                $img->cover(124, 124, 'center');
                $img->save($destinationPath . '/' . $imageName);
            }

    public function edit_product($id)
        {
            $product = Product::find($id);
            $categories = Category::Select('id','name')->orderBy('name')->get();
            return view('admin.product-edit',compact('product','categories'));
        }

        public function update_product(Request $request, $id) 
        {
            $product = Product::findOrFail($id); // Find product or fail
        
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:products,slug,'.$id,
                'category_id' => 'required',         
                'short_description' => 'required',
                'description' => 'required',
                'regular_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'SKU' => 'required',
                'stock_status' => 'required',
                'featured' => 'required',
                'quantity' => 'required|integer|min:0',
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'images.*' => 'nullable|mimes:jpg,png,jpeg|max:2048' 
            ]);
        
            // Update product details
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->regular_price = $request->regular_price;
            $product->sale_price = $request->sale_price;
            $product->SKU = $request->SKU;
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;
            $product->quantity = $request->quantity;
            
            $current_timestamp = Carbon::now()->timestamp;
        
            // Handle Main Image Upload
            if ($request->hasFile('image')) {        
                if ($product->image && file_exists(public_path('uploads/'.$product->image))) {
                    unlink(public_path('uploads/'.$product->image)); // Delete old image
                }
                
                $file_extention = $request->file('image')->extension();            
                $file_name = $current_timestamp . '.' . $file_extention;
                $path = $request->image->storeAs('products', $file_name, 'public_uploads');
                $product->image = $path;
            }
        
            // Handle Gallery Images Upload
            if ($request->hasFile('images')) {
                $existing_images = explode(',', $product->images ?? '');
                $gallery_arr = array_filter($existing_images); // Keep old images
                $counter = count($gallery_arr) + 1;
        
                foreach ($request->file('images') as $file) {                
                    $gextension = $file->getClientOriginalExtension();
                    if (in_array($gextension, ['jpg','png','jpeg'])) {
                        $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;                    
                        $gpath = $file->storeAs('products', $gfilename, 'public_uploads');
                        array_push($gallery_arr, $gpath);
                        $counter++;
                    }
                }
                $product->images = implode(',', $gallery_arr);
            }
        
            $product->save();
            
            return redirect()->route('admin.products')->with('status', 'Product updated successfully!');
        }
        

    public function delete_product($id)
        {
            $product = Product::find($id);        
            $product->delete();
            return redirect()->route('admin.products')->with('status','Record has been deleted successfully !');
        } 

    public function categories()
        {
                $categories = Category::orderBy('id','DESC')->paginate(10);
                return view("admin.categories",compact('categories'));
        }

    public function add_category()
        {
            return view("admin.category-add");
        }

    public function add_category_store(Request $request)
        {        
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories,slug',
                'image' => 'mimes:png,jpg,jpeg|max:2048'
            ]);
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbnailImage($image,$file_name);
            $category->image = $file_name;        
            $category->save();
            return redirect()->route('admin.categories')->with('status','Record has been added successfully !');
        }
        public function GenerateCategoryThumbnailImage($image, $imageName)
            {
                $destinationPath = public_path('uploads/categories');
                $manager=new ImageManager(new Driver());
                $img=$manager->read($image->path());
                $img->cover(124, 124, 'center');
                $img->save($destinationPath . '/' . $imageName);
            }

    public function edit_category($id)
        {
            $category = Category::find($id);
            return view('admin.category-edit',compact('category'));
        }
    
    public function update_category(Request $request)
        {
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,' . $request->id,
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'  // Make image optional
            ]);
        
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->slug = $request->slug;
        
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
                    File::delete(public_path('uploads/categories') . '/' . $category->image);
                }
        
                // Process the new image
                $image = $request->file('image');
                $file_extension = $image->extension();  // Correct method to get the file extension
                $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        
                // Assuming GenerateCategoryThumbnailImage is a method you have defined to handle the image
                $this->GenerateCategoryThumbnailImage($image, $file_name);
        
                // Save the new image name
                $category->image = $file_name;
            }
        
            $category->save();    
        
            return redirect()->route('admin.categories')->with('status', 'Record has been updated successfully!');
        }
        

    public function delete_category($id)
        {
            $category = Category::find($id);
            if (File::exists(public_path('uploads/categories').'/'.$category->image)) {
                File::delete(public_path('uploads/categories').'/'.$category->image);
            }
            $category->delete();
            return redirect()->route('admin.categories')->with('status','Record has been deleted successfully !');
        }

    
    public function orders()
    {
            $orders = Order::orderBy('created_at','DESC')->paginate(12);
            return view("admin.orders",compact('orders'));
    }

    public function order_details($order_id){

          $order = Order::find($order_id);
          $orderItems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
          $transaction = Transaction::where('order_id',$order_id)->first();
          return view("admin.order-details",compact('order','orderitems','transaction'));
    }

    public function update_order_status(Request $request){        
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if($request->order_status=='delivered')
        {
            $order->delivered_date = Carbon::now();
        }
        else if($request->order_status=='canceled')
        {
            $order->canceled_date = Carbon::now();
        }        
        $order->save();
        if($request->order_status=='delivered')
        {
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = "approved";
            $transaction->save();
        }
        return back()->with("status", "Status changed successfully!");
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }

}

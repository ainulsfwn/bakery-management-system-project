<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Food;

use App\Models\Cart;

use App\Models\Order; // <--- MAKE SURE THIS EXACT LINE IS HERE!

use App\Models\Book;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function my_home()
    {
        $food = Food::all();
        return view('home.index', compact('food'));
    }
    
    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth::user()->usertype;
          
            if ($usertype == 'user') {
                $food = Food::all();
                return view('home.index', compact('food'));
            } else {
                $total_user = User::where('usertype','=','user')->count();
                $total_food = Food::count();
                $total_order = Order::count();
                $total_delivered = Order::where('delivery_status','=','Delivered')->count();
                return view('admin.index',compact('total_user','total_food','total_order','total_delivered'));
            } 
        }
        return redirect()->route('login');
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $foodItem = Food::find($id);

            $cart_title = $foodItem->title;
            $cart_details = $foodItem->detail;
            $cart_price = Str::remove('RM', $foodItem->price);
            $cart_image = $foodItem->image;

            $cart = new Cart;
            $cart->title = $cart_title;
            $cart->details = $cart_details;
            $cart->price = (float)$cart_price * (int)$request->qty;
            $cart->image = $cart_image;
            $cart->quantity = $request->qty;
            $cart->userid = Auth::user()->id; // Saved as 'userid'

            $cart->save();
            return redirect()->back();
        } else {
            return redirect("login");
        }
    }

    public function my_cart()
    {
        // 1. Get the ID of the logged-in user
        $user_id = Auth::user()->id;

        // 2. Fetch the cart items using 'userid' to perfectly match the add_cart format
        $data = Cart::where('userid', '=', $user_id)->get();

        // 3. Pass that data to your cart page
        return view('home.my_cart', compact('data'));
    }

    /* --- METHOD ADDED FROM TUTORIAL #12 --- */
    public function remove_cart($id)
    {
        // Find the specific item in the cart table using its unique ID
        $cartItem = Cart::find($id);

        // Delete that specific row from the database
        $cartItem->delete();

        // Send the user directly back to their cart screen with the updated list
        return redirect()->back();
    }

    /* --- NEW METHOD ADDED FROM TUTORIAL #14 --- */
    public function confirm_order(Request $request)
    {
        // 1. Get the currently logged-in user's ID
        $userid = Auth::user()->id;

        // 2. Fetch all cart items belonging to this specific user
        $cart_items = Cart::where('userid', '=', $userid)->get();

        // 3. Loop through every item in their cart and copy it to the orders table
        foreach ($cart_items as $item) {
            $order = new Order;

            // Save delivery info from the form inputs
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->userid = $userid;

            // Save bakery product data copied from the cart item
            $order->title = $item->title;
            $order->quantity = $item->quantity;
            $order->price = $item->price;
            $order->image = $item->image;

            $order->save();

           

            // 4. Delete the item from the cart table now that it is safely an official order
            $item->delete();
        }

        // 5. Redirect back to the cart page with a fresh success message
        return redirect()->back()->with('message', 'Order Placed Successfully!');
    }

    public function book_table(Request $request)
    {
        $data = new Book;

        $data->phone = $request->phone;

        $data->guest = $request->n_guest;

        $data->time = $request->time;

        $data->date = $request->date;

        $data->save();

        return redirect()->back();

        
    
    }
}
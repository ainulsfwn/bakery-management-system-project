<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Food;

use App\Models\Book;

use App\Models\Order;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW ADD FOOD PAGE
    |--------------------------------------------------------------------------
    */
    public function add_product()
    {
        return view('admin.add_product');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE FOOD INTO DATABASE (WITH IMAGE FIX)
    |--------------------------------------------------------------------------
    */
    public function upload_food(Request $request)
    {
        // VALIDATION
        $request->validate([
            'title'   => 'required',
            'details' => 'required',
            'price'   => 'required',
            'image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $food = new Food();

        // TEXT DATA
        $food->title  = $request->title;
        $food->detail = $request->details;
        $food->price  = $request->price;

        // IMAGE UPLOAD FIX
        if ($request->hasFile('image')) {

            $image = $request->image;

            // unique name
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // move image to public folder
            $image->move(public_path('food_images'), $imageName);

            // SAVE FILE NAME ONLY INTO DATABASE
            $food->image = $imageName;
        }

        $food->save();

        return redirect()->back()->with('success', 'Food added successfully!');
    }

    public function view_product()
    {
        $data = Food::all();
        return view('admin.show_food',compact('data'));
    }

    public function delete_product($id)
{
    $food = Food::findOrFail($id);

    // delete image juga (optional best practice)
    if ($food->image) {
        $image_path = public_path('food_images/'.$food->image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $food->delete();

    return redirect()->back()->with('success', 'Food deleted successfully');
}
// update food
public function update_product($id)
{
    $food = Food::find($id);
    return view('admin.update_product', compact('food'));
}

//edit food
public function edit_product(Request $request,$id)
{
    $food = Food::find($id);

    $food->title = $request->title;

    $food->detail = $request->details;

    $food->price = $request->price;

    $image = $request->image;

    if($image)
        {
    $imagename=time().'.'.$image->getClientOriginalExtension();

    $request->image->move('food_images',$imagename);

        $food->image = $imagename;
        }


    $food->save();

    return redirect('view_product');
}

// orders for adminPage
public function orders()
{
    $data = Order::all(); // Changed from $food to $data to match the tutorial
    return view('admin.order', compact('data'));
}

public function on_the_way($id)
{
    $data = Order::find($id);

    $data->delivery_status = "On the way";

    $data->save();

    return redirect()->back();


}

public function delivered($id)
{
    $data = Order::find($id);

    $data->delivery_status = "delivered";

    $data->save();

    return redirect()->back();


}

public function cancel($id)
{
    $data = Order::find($id);

    $data->delivery_status = "cancel";

    $data->save();

    return redirect()->back();
}

public function reservations()
{
    $book = Book::all();
    return view('admin.reservation', compact('book'));
}
}
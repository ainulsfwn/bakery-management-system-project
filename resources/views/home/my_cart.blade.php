<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')

    <style>
        /* 1. NAVBAR HEIGHT AND LOGO POSITIONING */
        .custom-navbar {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto !important;
        }

        .brand-img {
            max-height: 120px;
            width: auto;
            object-fit: contain;
        }

        .brand-txt {
            font-size: 12px;
            color: #fff;
            font-weight: bold;
            margin-top: 2px;
            text-transform: uppercase;
        }

        /* 2. TABLE CONTAINER AND STYLING */
        .cart_container {
            margin: 140px auto 40px auto;
            width: 85%;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: red;
            color: white;
            padding: 15px;
            font-size: 18px;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 15px;
            color: #fff;
            text-align: center;
            border-bottom: 1px solid #444;
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* 3. TOTAL PRICE DISPLAY STYLING */
        .total_deg {
            font-size: 24px;
            color: #fff;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: inline-block;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}#gallery">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}#book-table">Book Table</a></li>
            </ul>
            
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="assets/imgs/logo-kedai.png" class="brand-img" alt="Logo">
                <span class="brand-txt">Bakery Shop</span>
            </a>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/')}}#blog">Blog</a>
                </li>

                @if (Route::has('login'))
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('my_cart')}}">Cart</a>
                    </li>

                    <form action="{{route('logout')}}" method="POST" class="d-inline">
                        @csrf
                        <input class="btn btn-primary ml-xl-4" type="submit" value="Logout">
                    </form>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <div class="cart_container">
        <table>
            <thead>
                <tr>
                    <th>Bakery Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Remove</th>
                </tr>

            </thead>
            <tbody>
                <?php $total_price = 0; ?>

                @foreach($data as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>RM {{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <img width="120" src="food_images/{{ $item->image }}" alt="{{ $item->title }}" style="border-radius: 8px;">
                    </td>
                    <td>
                        <a class="btn btn-danger" onclick="return confirm('Are you sure to remove this bakery item?')" href="{{ url('remove_cart', $item->id) }}">
                           Remove
                        </a>
                    </td>
                </tr>

                <?php $total_price = $total_price + $item->price; ?>
                @endforeach
            </tbody>
        </table>

        <div class="total_deg">
            Total Price for Cart: RM {{ $total_price }}
        </div>

        <div class="order_form_container" style="margin-top: 40px; background-color: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 8px; max-width: 500px; margin-left: auto; margin-right: auto; text-align: left; border: 1px solid #444;">
            <h3 style="color: #fff; text-align: center; margin-bottom: 20px; font-weight: bold;">Delivery Information</h3>
            
            <form action="{{ url('confirm_order') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label style="color: #fff; display: block; margin-bottom: 5px;">Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #555; background-color: #222; color: #fff;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="color: #fff; display: block; margin-bottom: 5px;">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #555; background-color: #222; color: #fff;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="color: #fff; display: block; margin-bottom: 5px;">Phone Number</label>
                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #555; background-color: #222; color: #fff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: #fff; display: block; margin-bottom: 5px;">Delivery Address</label>
                    <textarea name="address" required rows="3" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #555; background-color: #222; color: #fff;">{{ Auth::user()->address }}</textarea>
                </div>

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-info" style="padding: 10px 30px; font-size: 18px; font-weight: bold; width: 100%;">
                        Confirm Order
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
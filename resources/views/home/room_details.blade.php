<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* ✨ Enhanced room display styling */
        .room-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
            height: 100%;
        }

        .room-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.15);
        }

        .room-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-bottom: 3px solid #007bff;
        }

        .room-info {
            padding: 25px;
        }

        .room-info h3 {
            font-weight: 700;
            font-size: 28px;
            color: #222;
            margin-bottom: 10px;
        }

        .room-info p {
            font-size: 15px;
            color: #555;
            line-height: 1.6;
        }

        .room-tags {
            margin-top: 15px;
        }

        .room-tag {
            display: inline-block;
            background: #eef4ff;
            color: #007bff;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 14px;
            margin-right: 8px;
            font-weight: 600;
        }

        .room-price {
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
            color: #28a745;
        }

        @media (max-width: 768px) {
            .room-card img {
                height: 250px;
            }
            .room-info h3 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body class="main-layout">
    <!-- loader -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>
    <!-- end loader -->

    <!-- header -->
    <header>
        @include('home.header')
    </header>

    <div class="our_room">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Our Room</h2>
                        <p>Lorem Ipsum available, but the majority have suffered</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- ✨ Updated Room Section -->
                <div class="col-md-8 mb-4">
                    <div class="room-card">
                        <img src="room/{{$room->image}}" alt="Room Image">
                        <div class="room-info">
                            <h3>{{$room->room_title}}</h3>
                            <p>{{$room->description}}</p>

                            <div class="room-tags">
                                <span class="room-tag">Type: {{$room->room_type}}</span>
                                <span class="room-tag">WiFi: {{$room->wifi}}</span>
                            </div>

                            <div class="room-price">
                                ₹{{$room->price}} / Night
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ✨ End Updated Room Section -->

                <!-- Booking form (unchanged) -->
                <div class="col-md-4">
                    <h1 style="font-size: 40px">Book Room</h1>
                    <div>
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{session()->get('message')}}
                        </div>
                        @endif
                    </div>

                    <div class="room_form">
                        @if($errors)
                        @foreach($errors->all() as $errors)
                        <li style="color: red; list-style: none;">
                            {{$errors}}
                        </li>
                        @endforeach
                        @endif

                        <form action="{{ url('/add_booking', $room->id) }}" method="post">
                            @csrf
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Name" name="name"
                            @if(Auth::id()) value="{{Auth::user()->name}}" @endif required>

                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email"
                            @if(Auth::id()) value="{{Auth::user()->email}}" @endif required>

                            <label>Phone Number</label>
                            <input type="text" class="form-control" placeholder="Phone Number" name="phone"
                            @if(Auth::id()) value="{{Auth::user()->phone}}" @endif required>

                            <label>Start Date</label>
                            <input type="date" class="form-control" placeholder="start date" name="startdate" id="startdate">

                            <label>End Date</label>
                            <input type="date" class="form-control" placeholder="End date" name="enddate" id="enddate">

                            <br>
                            <button type="submit" class="btn btn-primary w-100">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    @include('home.footer')

    <!-- Load JS files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
        $(function(){
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10) month = '0' + month;
            if(day < 10) day = '0' + day;
            var minDate = year + '-' + month + '-' + day;
            $('#startdate').attr('min', minDate);
            $('#enddate').attr('min', minDate);
        });
    </script>
</body>
</html>

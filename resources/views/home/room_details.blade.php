<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <p>Lorem Ipsum available, but the majority have suffered </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Room details -->
                <div class="col-md-8">
                    <div id="serv_hover" class="room">
                        <div style="padding: 20px" class="room_img">
                            <figure><img style="height: 300px;width: 800px" src="room/{{$room->image}}" alt="#"/></figure>
                        </div>
                        <div class="bed_room">
                            <h3>{{$room->room_title}}</h3>
                            <p style="padding: 10px">{{$room->description}}</p>
                            <h4 style="padding: 10px">Room Type: {{$room->room_type}}</h4>
                            <h4 style="padding: 10px">Wifi: {{$room->wifi}}</h4>
                            <h3 style="padding: 10px">Price: {{$room->price}}</h3>
                        </div>
                    </div>
                </div>

                <!-- Booking form -->
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
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    @include('home.footer')
    <!-- end footer -->

    <!-- Load JS files in correct order -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>

    <!-- Your custom date script (AFTER jQuery) -->
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

<!DOCTYPE html>
<html>
  <head>
    @include("admin.css")

    <style type="text/css">
        label {
            display: inline-block;
            width: 200px;
        }

    </style>
  </head>
  <body>
    @include("admin.header")
    @include("admin.sidebar")
    <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

            <div>
                <h1 style="font-size: 30px; font-weight:bold;">Add Room</h1>
                <form action="{{url('add_room')}}" method="POST" enctype="multipart/form-data">
                    @csrf`
                    <div>
                        <label for="">Room Title</label>
                        <input type="text" name="title">
                    </div>
                    <br>
                    <div>
                        <label for="">
                            Description
                        </label>

                        <textarea name="description" id="" cols="30" rows="10"></textarea>
                    </div>
                    <br>
                    <div>
                        <label for="">Room Type</label>
                        <select name="type">
                            <option selected value="regular">Regular</option>
                            <option value="premium">Premium</option>
                            <option value="deluxe">Deluxe</option>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label for="">Price</label>
                        <input type="number" name="price" placeholder="Enter Price">
                    </div>
                    <br>
                    <div>
                        <label for="">Free Wifi</label>
                        <select name="wifi">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label for="">Upload Room Image</label>

                        <input type="file"name="image">
                    </div>
                    <br>
                    <div>
                        <input type="submit" value="Add Room" class="btn btn-primary">
                    </div>
                </form>
            </div>

          </div>
        </div>
    </div>


    @include("admin.footer")
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    @include("admin.css")

    <style>
      body {
        background: #f4f6f9;
      }

      .form-container {
        background: #fff;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        max-width: 600px;
        margin: 40px auto;
        transition: 0.3s;
      }

      .form-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      }

      .form-container h1 {
        font-weight: 700;
        font-size: 28px;
        text-align: center;
        margin-bottom: 25px;
        color: #333;
      }

      label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
      }

      input[type="text"],
      input[type="number"],
      select,
      textarea {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: border 0.2s ease;
      }

      input:focus,
      select:focus,
      textarea:focus {
        border-color: #007bff;
        outline: none;
      }

      .btn-submit {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: #007bff;
        color: white;
        font-weight: 600;
        transition: background 0.3s ease;
      }

      .btn-submit:hover {
        background: #0056b3;
      }

      .preview-img {
        width: 100%;
        max-height: 250px;
        object-fit: cover;
        border-radius: 10px;
        margin-top: 10px;
        display: none;
      }

      .current-img {
        width: 100%;
        max-height: 250px;
        border-radius: 10px;
        object-fit: cover;
        margin-bottom: 15px;
      }
    </style>
  </head>

  <body>
    @include("admin.header")
    @include("admin.sidebar")

    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">
          <div class="form-container">
            <h1>Update Room</h1>

            <form
              id="updateRoomForm"
              action="{{ url('edit_room', $data->id) }}"
              method="POST"
              enctype="multipart/form-data"
            >
              @csrf

              <div class="mb-3">
                <label for="title">Room Title</label>
                <input
                  type="text"
                  id="title"
                  name="title"
                  class="form-control"
                  value="{{ $data->room_title }}"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="description">Description</label>
                <textarea
                  name="description"
                  id="description"
                  class="form-control"
                  rows="4"
                  required
                >{{ $data->description }}</textarea>
              </div>

              <div class="mb-3">
                <label for="type">Room Type</label>
                <select id="type" name="type" class="form-select" required>
                  <option value="{{ $data->room_type }}" selected>
                    {{ ucfirst($data->room_type) }}
                  </option>
                  <option value="regular">Regular</option>
                  <option value="premium">Premium</option>
                  <option value="deluxe">Deluxe</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="price">Price (₹)</label>
                <input
                  type="number"
                  id="price"
                  name="price"
                  class="form-control"
                  min="1"
                  value="{{ $data->price }}"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="wifi">Free WiFi</label>
                <select id="wifi" name="wifi" class="form-select" required>
                  <option value="{{ $data->wifi }}" selected>
                    {{ ucfirst($data->wifi) }}
                  </option>
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              </div>

              <div class="mb-3">
                <label>Current Room Image</label>
                <img
                  src="/room/{{ $data->image }}"
                  alt="Current Room"
                  class="current-img"
                />
              </div>

              <div class="mb-3">
                <label for="image">Upload New Image</label>
                <input
                  type="file"
                  id="image"
                  name="image"
                  class="form-control"
                  accept="image/*"
                  onchange="previewImage(event)"
                />
                <img id="preview" class="preview-img" />
              </div>

              <button type="submit" class="btn-submit">Update Room</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @include("admin.footer")

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // Image Preview
      function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
          const output = document.getElementById("preview");
          output.src = reader.result;
          output.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
      }

      // Confirm update before submitting
      document
        .getElementById("updateRoomForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();
          Swal.fire({
            title: "Confirm Update",
            text: "Are you sure you want to update this room?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#007bff",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, update it!",
          }).then((result) => {
            if (result.isConfirmed) {
              e.target.submit();
            }
          });
        });
    </script>
  </body>
</html>

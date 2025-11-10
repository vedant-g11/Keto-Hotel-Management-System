<!DOCTYPE html>
<html lang="en">
  <head>
    @include("admin.css")

    <style>
      body {
        background: #f4f6f9;
      }

      .table-container {
        max-width: 95%;
        margin: 40px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 20px;
        transition: 0.3s;
      }

      .table-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      }

      h1 {
        text-align: center;
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 25px;
        color: #333;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
      }

      thead {
        background-color: #007bff;
        color: white;
      }

      th, td {
        padding: 12px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
      }

      tr:hover {
        background-color: #f1f9ff;
        transition: 0.2s;
      }

      img {
        width: 100px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
      }

      .btn {
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 6px;
      }

      .btn-danger {
        background-color: #e74c3c;
        border: none;
      }

      .btn-danger:hover {
        background-color: #c0392b;
      }

      .btn-success {
        background-color: #27ae60;
        border: none;
      }

      .btn-success:hover {
        background-color: #1e8449;
      }

      .btn-warning {
        background-color: #f39c12;
        border: none;
      }

      .btn-warning:hover {
        background-color: #d68910;
      }

      .search-bar {
        text-align: right;
        margin-bottom: 15px;
      }

      .search-bar input {
        width: 250px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        transition: 0.2s;
      }

      .search-bar input:focus {
        border-color: #007bff;
        outline: none;
      }

      @media (max-width: 768px) {
        table {
          font-size: 13px;
        }

        img {
          width: 70px;
          height: 60px;
        }

        .search-bar input {
          width: 100%;
        }
      }
    </style>
  </head>

  <body>
    @include("admin.header")
    @include("admin.sidebar")

    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">

          <div class="table-container">
            <h1>Booking Management</h1>

            <div class="search-bar">
              <input
                type="text"
                id="searchInput"
                placeholder="Search bookings..."
                onkeyup="filterTable()"
              />
            </div>

            <div class="table-responsive">
              <table id="bookingTable">
                <thead>
                  <tr>
                    <th>Room ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Arrival Date</th>
                    <th>Departure Date</th>
                    <th>Status</th>
                    <th>Room Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Delete</th>
                    <th>Status Update</th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($data as $booking)
                  <tr>
                    <td>{{ $booking->room_id }}</td>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->start_date }}</td>
                    <td>{{ $booking->end_date }}</td>
                    <td>
                      <span
                        class="badge bg-{{ $booking->status == 'Approved' ? 'success' : ($booking->status == 'Rejected' ? 'danger' : 'secondary') }}"
                      >
                        {{ ucfirst($booking->status) }}
                      </span>
                    </td>
                    <td>{{ $booking->room->room_title ?? 'N/A' }}</td>
                    <td>₹{{ $booking->room->price ?? 'N/A' }}</td>
                    <td>
                      @if($booking->room && $booking->room->image)
                        <img src="/room/{{ $booking->room->image }}" alt="Room Image" />
                      @else
                        <span class="text-muted">N/A</span>
                      @endif
                    </td>

                    <td>
                      <button
                        class="btn btn-danger"
                        onclick="confirmDelete('{{ url('delete_booking', $booking->id) }}')"
                      >
                        Delete
                      </button>
                    </td>

                    <td>
                      <button
                        class="btn btn-success"
                        onclick="confirmApprove('{{ url('approve_book', $booking->id) }}')"
                      >
                        Approve
                      </button>
                      <button
                        class="btn btn-warning"
                        onclick="confirmReject('{{ url('reject_book', $booking->id) }}')"
                      >
                        Reject
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

    @include("admin.footer")

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // SweetAlert confirmation for Delete
      function confirmDelete(url) {
        Swal.fire({
          title: "Are you sure?",
          text: "This booking will be permanently deleted!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#e74c3c",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = url;
          }
        });
      }

      // Approve booking confirmation
      function confirmApprove(url) {
        Swal.fire({
          title: "Approve this booking?",
          text: "This will mark the booking as approved.",
          icon: "success",
          showCancelButton: true,
          confirmButtonColor: "#27ae60",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Approve"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = url;
          }
        });
      }

      // Reject booking confirmation
      function confirmReject(url) {
        Swal.fire({
          title: "Reject this booking?",
          text: "The booking will be marked as rejected.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#f39c12",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Reject"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = url;
          }
        });
      }

      // Live search filter
      function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("bookingTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
          let tdArray = tr[i].getElementsByTagName("td");
          let visible = false;
          for (let td of tdArray) {
            if (td.innerText.toLowerCase().includes(filter)) {
              visible = true;
              break;
            }
          }
          tr[i].style.display = visible ? "" : "none";
        }
      }
    </script>
  </body>
</html>

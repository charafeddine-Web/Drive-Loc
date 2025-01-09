<?php
require_once '../../autoload.php';

// use Classes\Category;
// use Classes\Reservation;
// use Classes\Vehicle;

session_start();
if ((!isset($_SESSION['id_user']) && $_SESSION['id_role'] !== 2)) {
    header("Location: ../../Visiteur/login.php");
    exit;
}
// try {
//     $categories = Category::ShowCategory();
//     $categoryVehicles = [];
//     foreach ($categories as $category) {
//         $vehicles = Vehicle::getVehiclesByCategory($category['id_category']);
//         $categoryVehicles[$category['id_category']] = $vehicles;
//     }
// } catch (\PDOException $e) {
//     echo "Error fetching categories and vehicles: " . $e->getMessage();
//     return false;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #1d4ed8;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .card {
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff, #f3f4f6);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        .logo-text {
            background: linear-gradient(135deg, #000000 0%, #1e3a8a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .reserved-badge {
            animation: pulse 2s infinite;
            box-shadow: 0 0 15px rgba(251, 146, 60, 0.5);
        }

        .page {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .page.active {
            display: block;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body style="scroll-behavior: smooth;">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed z-50 w-full">
        <div class="max-w-7xl mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo Section -->
                <div class="flex items-center space-x-3">
                    <i
                        class="fa-solid fa-car-side text-4xl bg-gradient-to-r from-black to-blue-900 text-transparent bg-clip-text"></i>
                    <div>
                        <span class="text-3xl font-bold logo-text tracking-wider">Drive</span>
                        <span class="text-3xl font-black logo-text">Loc</span>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button id="hamburgerr" class="text-2xl text-gray-800 focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>

                <!-- Navigation Links Section -->
                <div class="hidden lg:flex items-center space-x-12">
                    <div class="flex space-x-8">
                        <a href="../../client/index.php" id="showCars"
                            class="nav-link  text-lg font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-car-rear mr-2"></i>  Cars
                        </a>
                        <a  href="../../client/index.php" id="showReservations"
                            class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-clock-rotate-left mr-2"></i>  Reservations
                        </a>
                        <a href="./index.php" id="showBlog"
                            class="nav-link text-lg  font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-book-open mr-2"></i> 
                            Blogs
                        </a>
                        <a href="./favoris.php" id="showBlog"
                            class="nav-link  text-lg  font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-book-open mr-2"></i>favoris
                        </a>
                        <a href="./comments.php" id="showBlogMobile"
                            class="nav-link text-lg active font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                            <i class="fa-solid fa-comments mr-2"></i> Mes Comment
                        </a>
                    </div>

                    <div class="flex items-center space-x-6">
                        <form action="../../Visiteur/logout.php" method="POST">
                            <button type="submit" name="submit"
                                class="bg-black hover:bg-gray-800 text-white px-6 py-2.5 rounded-full transition-colors duration-300 flex items-center space-x-2">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="lg:hidden bg-white shadow-lg fixed inset-0 z-40 hidden">
            <div class="flex flex-col items-center py-6">
                <button id="closeMenuu" class="text-3xl text-gray-800 absolute top-0 right-4 pb-8">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <a href="../../client/index.php" id="showCarsMobile"
                    class="nav-link  text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-car-rear mr-2"></i>  Cars
                </a>
                <a  href="../../client/index.php" id="showReservationsMobile"
                    class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i>  Reservations
                </a>
                <a href="./index.php" id="showBlogMobile"
                    class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-book-open mr-2"></i> Blogs
                </a>
                <a href="./favoris.php" id="showBlogMobile"
                    class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-book-open mr-2"></i> favoris
                </a>
                <a href="./comments.php" id="showBlogMobile"
                            class="nav-link text-lg active font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                            <i class="fa-solid fa-comments mr-2"></i> Mes Comments
                </a>
                <form action="../../Visiteur/logout.php" method="post">
                    <button type="submit"
                        class="bg-black hover:bg-gray-800 text-white py-2.5 px-6 rounded-full transition-colors duration-300 mt-4 w-full text-center">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
               
            </div>
        </div>
    </nav>
    <div id="ArticlePage" class="page active max-w-7xl mx-auto p-6 bg-gray-50" style="transform: translateY(100px);">
        
       
    </div>



    <!-- Modal for Vehicle Reservation -->
    <div id="reservationModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <div class="flex justify-end">
                <button id="closeModal" class="mt-4 text-red-500">Close</button>
            </div>

            <h3 id="modalModel" class="text-xl font-semibold text-gray-800"></h3>
            <p id="modalTransmission" class="text-sm text-gray-500"></p>
            <p id="modalFuel" class="mt-2 text-gray-600"></p>
            <p id="modalPrice" class="mt-2 text-gray-600"></p>

            <form id="reservationForm" method="POST" action="reserver.php" class="mt-4">
                <input type="hidden" id="vehicle_id" name="vehicle_id">
                <input type="hidden" id="idUser" name="idUser" value="<?php echo $_SESSION['id_user']; ?>">

                <div class="mb-4">
                    <label for="pickupLocation" class="block text-gray-600">Pick-up Location</label>
                    <input type="text" id="pickupLocation" name="pickupLocation" 
                        required class="w-full p-2 rounded-md border border-gray-300">
                </div>
                <div class="mb-4">
                    <label for="dropoffLocation" class="block text-gray-600">Drop-off Location</label>
                    <input type="text" id="dropoffLocation" name="dropoffLocation"
                    required class="w-full p-2 rounded-md border border-gray-300">
                </div>
                <div class="mb-4">
                    <label for="startDate" class="block text-gray-600">Start Date</label>
                    <input type="date" id="startDate" name="startDate"
                    required  class="w-full p-2 rounded-md border border-gray-300">
                </div>
                <div class="mb-4">
                    <label for="endDate" class="block text-gray-600">End Date</label>
                    <input type="date" id="endDate" required name="endDate" class="w-full p-2 rounded-md border border-gray-300">
                </div>
                <button type="submit" name="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md w-full">Reserve
                    Now</button>
            </form>
        </div>
    </div>





    <div id="reservationsPage" class="page max-w-7xl mx-auto p-6 bg-gray-50">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">My Reservations</h2>

        <!-- <?php
        $client_res = new Reservation(null, null, null, null, null, null, null, null);
        if (isset($_SESSION['id_user'])) {
            $id = $_SESSION['id_user'];
        }
        $rs = $client_res->ShowAllRes_client($id);
        ?> -->

        <?php if ($rs): ?>
            <?php foreach ($rs as $r):
                $status = htmlspecialchars($r['status']);
                $statusClass = 'text-gray-500';

                switch ($status) {
                    case 'pending':
                        $statusClass = 'bg-yellow-100 text-yellow-700';
                        break;
                    case 'accepted':
                        $statusClass = 'bg-green-100 text-green-700';
                        break;
                    case 'rejected':
                        $statusClass = 'bg-red-100 text-red-700';
                        break;
                }
                ?>
                <!-- Reservation Card -->
                <div
                    class="reservation-card bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-105">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <img class="w-80 h-80 object-cover rounded-lg shadow-md"
                            src="../assets/image/<?php echo htmlspecialchars($r['imageVeh']); ?>" alt="Car Image">

                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-800">
                                Car Model: <span class="font-semibold"><?php echo htmlspecialchars($r['model']); ?></span>
                            </h3>
                            <p class="text-sm text-gray-600 mt-2">
                                Reservation Start Date: <span
                                    class="font-medium"><?php echo htmlspecialchars($r['start_date']); ?></span>
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                Reservation End Date: <span
                                    class="font-medium"><?php echo htmlspecialchars($r['end_date']); ?></span>
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                Pick-up Location: <span
                                    class="font-medium"><?php echo htmlspecialchars($r['pickup_location']); ?></span>
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                Drop-off Location: <span
                                    class="font-medium"><?php echo htmlspecialchars($r['dropoff_location']); ?></span>
                            </p>
                            <p class="mt-4">
                                <span class="inline-block px-3 py-1 rounded-full <?php echo $statusClass; ?>">
                                    Status: <?php echo ucfirst($status); ?>
                                </span>
                            </p>

                            <div class="flex flex-wrap gap-4 mt-6">
                <button
                    class="bg-blue-600 text-white py-2 px-8 rounded-lg hover:bg-blue-700 transition duration-200 transform hover:scale-105 shadow-md edit-button"
                    data-reservation-id="<?php echo $r['id_res']; ?>">
                    Modify Reservation
                </button>
                <button
                    class="bg-red-600 text-white py-2 px-8 rounded-lg hover:bg-red-700 transition duration-200 transform hover:scale-105 shadow-md delete-button"
                    data-reservation-id="<?php echo htmlspecialchars($r['id_res']); ?>">
                    Cancel Reservation
                </button>
                <button
                    class="bg-green-600 text-white py-2 px-8 rounded-lg hover:bg-green-700 transition duration-200 transform hover:scale-105 shadow-md reviewbutton"
                    data-vehicle-id="<?php echo htmlspecialchars($r['idVeh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    data-user-id="<?php echo htmlspecialchars($id ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    Add Review
                </button>
            </div>
                    </div>
                </div>
                <?php

                if (isset($_GET['status'])) {
                    $status = $_GET['status'];
                    if ($status === 'deleted') {
                        echo "<script>
                        Swal.fire('Deleted!', 'The reservation has been canceled.', 'success');
                    </script>";
                    } elseif ($status === 'error') {
                        echo "<script>
                        Swal.fire('Error!', 'Failed to cancel the reservation.', 'error');
                    </script>";
                    } elseif ($status === 'invalid') {
                        echo "<script>
                        Swal.fire('Error!', 'Invalid reservation ID.', 'error');
                    </script>";
                    }
                }
                ?>
                <!-- Edit Form -->
                <div id="editReservationForm-<?php echo $r['id_res']; ?>"
                    class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
                    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-3xl">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Reservation</h2>

                        <form action="editReservation.php" method="POST" class="space-y-6">
                            <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($r['id_res']); ?>">

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-600">Reservation Start
                                    Date</label>
                                <input type="date" id="start_date" name="start_date"
                                    class="w-full mt-2 p-4 rounded-md border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="<?php echo htmlspecialchars($r['start_date']); ?>">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-600">Reservation End
                                    Date</label>
                                <input type="date" id="end_date" name="end_date"
                                    class="w-full mt-2 p-4 rounded-md border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="<?php echo htmlspecialchars($r['end_date']); ?>">
                            </div>

                            <div>
                                <label for="pickup_location" class="block text-sm font-medium text-gray-600">Pick-up
                                    Location</label>
                                <input type="text" id="pickup_location" name="pickup_location"
                                    class="w-full mt-2 p-4 rounded-md border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="<?php echo htmlspecialchars($r['pickup_location']); ?>">
                            </div>

                            <div>
                                <label for="dropoff_location" class="block text-sm font-medium text-gray-600">Drop-off
                                    Location</label>
                                <input type="text" id="dropoff_location" name="dropoff_location"
                                    class="w-full mt-2 p-4 rounded-md border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="<?php echo htmlspecialchars($r['dropoff_location']); ?>">
                            </div>

                            <div class="flex justify-end gap-4">
                                <button type="button"
                                    class="bg-gray-600 text-white py-2 px-6 rounded-lg hover:bg-gray-700 transition duration-200 close-button"
                                    data-reservation-id="<?php echo $r['id_res']; ?>">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600 text-lg mt-8 text-center">No reservations available at the moment.</p>
        <?php endif; ?>
    </div>
<!-- Add Review Modal -->
<div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg relative">
        <button id="closeReviewModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✕</button>
        <h3 class="text-xl font-bold text-gray-800 mb-4">Add Your Review</h3>
        <form id="reviewForm" action="addReview.php" method="POST">
            <input type="hidden" id="reviewVehicleId" name="vehicle_id">
            <input type="hidden" id="reviewuserId" name="user_id">
            <div class="mb-4">
                <label for="reviewRating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                <select id="reviewRating" name="rating" class="w-full mt-1 p-2 border rounded-lg">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="reviewComment" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea id="reviewComment" name="comment" rows="4" class="w-full mt-1 p-2 border rounded-lg"></textarea>
            </div>
            <button type="submit" name="submit"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                Submit Review
            </button>
        </form>
    </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', () => {
    const reviewModal = document.getElementById('reviewModal');
    const closeReviewModal = document.getElementById('closeReviewModal');
    const reviewForm = document.getElementById('reviewForm');

    document.querySelectorAll('.reviewbutton').forEach(button => {
        button.addEventListener('click', () => {
            const vehicleId = button.getAttribute('data-vehicle-id');
            const userId = button.getAttribute('data-user-id'); 

            document.getElementById('reviewVehicleId').value = vehicleId;
            document.getElementById('reviewuserId').value = userId;

            reviewModal.classList.remove('hidden');
        });
    });
    closeReviewModal.addEventListener('click', () => {
        reviewModal.classList.add('hidden');
    });
    reviewForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(reviewForm);

        fetch('addReview.php', {
    method: 'POST',
    body: formData,
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Review added successfully!');
            reviewModal.classList.add('hidden');
            reviewForm.reset();
        } else {
            alert(`Error: ${data.message || 'Unknown error'}`);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('A network error occurred. Please try again.');
    });

    });
    reviewModal.addEventListener('click', (event) => {
        if (event.target === reviewModal) {
            reviewModal.classList.add('hidden');
        }
    });
});


</script>
   

    <script>
        //pour model edit
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', () => {
                const reservationId = button.getAttribute('data-reservation-id');
                document.getElementById(`editReservationForm-${reservationId}`).classList.remove('hidden');
            });
        });

        document.querySelectorAll('.close-button').forEach(button => {
            button.addEventListener('click', () => {
                const reservationId = button.getAttribute('data-reservation-id');
                document.getElementById(`editReservationForm-${reservationId}`).classList.add('hidden');
            });
        });

        //pour delete reservation
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', () => {
                const reservationId = button.getAttribute('data-reservation-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `deleteReservation.php?id=${reservationId}`;
                    }
                });
            });
        });

        //pour reserponsive 
        const hamburgerr = document.getElementById("hamburgerr");
        const mobileMenu = document.getElementById("mobileMenu");
        const closeMenuu = document.getElementById("closeMenuu");

        hamburgerr.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });

        closeMenuu.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
        document.addEventListener('DOMContentLoaded', function () {
            const showCars = document.getElementById('showCars');
            const showReservations = document.getElementById('showReservations');
            const carsPage = document.getElementById('carsPage');
            const reservationsPage = document.getElementById('reservationsPage');

            function switchPage(show, hide, activeBtn, inactiveBtn) {
                hide.classList.remove('active');
                show.classList.add('active');
                inactiveBtn.classList.remove('active');
                activeBtn.classList.add('active');
            }

            showCars.addEventListener('click', () => {
                switchPage(carsPage, reservationsPage, showCars, showReservations);
            });

            showReservations.addEventListener('click', () => {
                switchPage(reservationsPage, carsPage, showReservations, showCars);
            });
        });
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.pushState(null, null, location.href);
        };


        // pour les reservation 
        document.querySelectorAll('.vehicle-card').forEach(card => {
            card.addEventListener('click', function () {
                const vehicleId = card.getAttribute('data-vehicle-id');
                console.log(`Vehicle ID: ${vehicleId}`);
                document.getElementById('vehicle_id').value = vehicleId;
                document.getElementById('reservationModal').classList.remove('hidden');
            });
        });

        function handleCardClick(vehicleId) {
            console.log("Sending Vehicle ID:", vehicleId);

            fetch('get_vehicle_details.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ vehicleId: vehicleId }),
            })
                .then(response => {
                    console.log("Response received:", response);
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched Data:', data);

                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    document.getElementById('modalModel').innerText = data.model || 'N/A';
                    document.getElementById('modalTransmission').innerText = `Transmission: ${data.transmissionType || 'N/A'}`;
                    document.getElementById('modalFuel').innerText = `Fuel: ${data.fuelType || 'N/A'}`;
                    document.getElementById('modalPrice').innerText = `Price: $${data.price_per_day || 'N/A'}/day`;

                    document.getElementById('reservationModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                });

        }

        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('reservationModal').classList.add('hidden');
        });

    </script>

</body>

</html>
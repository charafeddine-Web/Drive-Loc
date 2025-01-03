<?php
require_once '../autoload.php'; 

use Classes\Category;
use Classes\Vehicle;
use Classes\Reservation;

try {
 $categories = Category::ShowCategory();
 $categoryVehicles = [];
 foreach ($categories as $category) {
     $vehicles = Vehicle::getVehiclesByCategory($category['id_category']);
     $categoryVehicles[$category['id_category']] = $vehicles;
 }
} catch (\PDOException $e) {
 echo "Error fetching categories and vehicles: " . $e->getMessage();
 return false;
}

if (isset($_POST['submit'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $pickup_location = $_POST['pickupLocation'];
    $dropoff_location = $_POST['dropoffLocation'];
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];

    // Create a new Reservation instance
    $reservation = new Reservation(null,null,null,null,null,null,null,null);
    $response = $reservation->addReservation( $vehicle_id,$pickup_location, $dropoff_location,$start_date, $end_date );
    echo json_encode($response);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
                <i class="fa-solid fa-car-side text-4xl bg-gradient-to-r from-black to-blue-900 text-transparent bg-clip-text"></i>
                <div>
                    <span class="text-3xl font-bold logo-text tracking-wider">Drive</span>
                    <span class="text-3xl font-black logo-text">Loc</span>
                </div>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button id="hamburger" class="text-2xl text-gray-800 focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <!-- Navigation Links Section -->
            <div class="hidden lg:flex items-center space-x-12">
                <div class="flex space-x-8">
                    <button id="showCars" class="nav-link active text-lg font-semibold hover:text-blue-800 transition-colors flex items-center">
                        <i class="fa-solid fa-car-rear mr-2"></i> Available Cars
                    </button>
                    <button id="showReservations" class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors flex items-center">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> My Reservations
                    </button>
                </div>
                
                <div class="flex items-center space-x-6">
                    <form action="../Visiteur/logout.php" method="post">
                        <button type="submit" class="bg-black hover:bg-gray-800 text-white px-6 py-2.5 rounded-full transition-colors duration-300 flex items-center space-x-2">
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
            <button id="closeMenu" class="text-3xl text-gray-800 absolute top-0 right-4 pb-8">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <button id="showCarsMobile" class="nav-link active text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                <i class="fa-solid fa-car-rear mr-2"></i> Available Cars
            </button>
            <button id="showReservationsMobile" class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                <i class="fa-solid fa-clock-rotate-left mr-2"></i> My Reservations
            </button>
            <form action="../Visiteur/logout.php" method="post">
                <button type="submit" class="bg-black hover:bg-gray-800 text-white py-2.5 px-6 rounded-full transition-colors duration-300 mt-4 w-full text-center">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>
<div id="carsPage" class="page active max-w-7xl mx-auto p-6 bg-gray-50" style="transform: translateY(100px);">
    <!-- Title and No Cars Message -->
    <div class="flex flex-col items-center justify-center p-8 text-center">
        <div class="animate-bounce">
            <i data-feather="car" class="w-16 h-16 text-red-500"></i>
        </div>
        <?php if (empty($categoryVehicles)): ?>
            <h2 class="mt-4 text-3xl font-bold text-gray-800">
                No Cars Available
            </h2>
            <p class="mt-2 text-lg text-gray-600">
                There are currently no cars in the inventory.
                Please check back later.
            </p>
        <?php endif; ?>
    </div>

    <div class="flex flex-col justify-start md:flex-row gap-8">
        <div class="w-full md:w-1/4 h-auto bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter</h3>
            <div class="space-y-6">
                <div>
                    <input type="text" id="searchInput" class="w-full p-4 rounded-md border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by model..." onkeyup="filterVehicles()">
                </div>
                <div class="flex flex-col gap-4 ">
                    <div class="filters">
                        <select id="categoryFilter">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id_category']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
              
            </div>
        </div>
        <div id="vehicleList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
        <?php
           $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
           $itemsPerPage = 3;
           $selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
           $vehicles = Vehicle::PaginateVeh($currentPage, $itemsPerPage, $selectedCategory);
           $totalVehicles = Vehicle::getTotalVehiclesCount($selectedCategory);
           $totalPages = ceil($totalVehicles / $itemsPerPage); 
        ?>
        <div class="w-full md:w-full">
            <div class="space-y-12" id="vehicleList">
                <?php foreach ($categories as $category): ?>
                    <div class="category-section mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p class="text-gray-600 mb-8 text-lg"><?php echo htmlspecialchars($category['description']); ?></p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                            <?php if (isset($categoryVehicles[$category['id_category']]) && count($categoryVehicles[$category['id_category']]) > 0): ?>
                                <?php foreach ($categoryVehicles[$category['id_category']] as $vehicle): ?>
                                    <div class="vehicle-card bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-105 relative"
                                        data-vehicle-id="<?php echo $vehicle['id_vehicle']; ?>"> <!-- Use id_vehicle for the vehicle ID -->
                                        <img src="../assets/image/<?php echo htmlspecialchars($vehicle['imageVeh']); ?>" alt="<?php echo htmlspecialchars($vehicle['model']); ?>" class="w-full h-48 object-cover rounded-t-lg mb-4">

                                        <div class="mt-4 flex flex-col items-center justify-center">
                                            <h4 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($vehicle['model']); ?></h4>
                                            <p class="text-sm text-gray-500">Transmission: <?php echo htmlspecialchars($vehicle['transmissionType']); ?> | Mileage: <?php echo htmlspecialchars($vehicle['mileage']); ?>/Km</p>
                                            <p class="mt-2 text-gray-600">Fuel: <?php echo htmlspecialchars($vehicle['fuelType']); ?></p>
                                            <p class="mt-2 text-gray-600">Price: $<?php echo number_format($vehicle['price_per_day'], 2); ?>/day </p>

                                            <button id="details" class="mt-4 mx-auto bg-blue-500 hover:bg-blue-700 text-white py-2 px-12 md:px-15 md:py-1 rounded-md transition duration-200 transform hover:scale-105">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <p class="text-gray-600 text-lg">No vehicles available in this category.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination flex justify-center mt-8">
                <nav aria-label="Page navigation">
                    <ul class="flex space-x-2">
                        <?php
                        $maxPagesToShow = 5;
                        $startPage = max(1, $currentPage - floor($maxPagesToShow / 2));
                        $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

                        if ($endPage - $startPage + 1 < $maxPagesToShow) {
                            $startPage = max(1, $endPage - $maxPagesToShow + 1);
                        }
                        ?>

                        <?php if ($currentPage > 1): ?>
                            <li><a href="?page=<?php echo $currentPage - 1; ?>" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Previous</a></li>
                        <?php endif; ?>
                        
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li>
                                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 <?php echo ($i == $currentPage) ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded-lg">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <li><a href="?page=<?php echo $currentPage + 1; ?>" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
          </div>
        </div>
        
    </div>
</div>
<!-- Modal for Vehicle Reservation -->
<!-- Modal for Vehicle Reservation -->
<div id="reservationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <div class="flex justify-end">
            <button id="closeModal" class="mt-4 text-red-500">Close</button>
        </div>
        
        <h3 id="modalModel" class="text-xl font-semibold text-gray-800"></h3>
        <p id="modalTransmission" class="text-sm text-gray-500"></p>
        <p id="modalFuel" class="mt-2 text-gray-600"></p>
        <p id="modalPrice" class="mt-2 text-gray-600"></p>

        <form id="reservationForm" method="POST" action="" class="mt-4">
            <input type="hidden" id="vehicle_id" name="vehicle_id" value=""> 
            <div class="mb-4">
                <label for="pickupLocation" class="block text-gray-600">Pick-up Location</label>
                <input type="text" id="pickupLocation" name="pickupLocation" class="w-full p-2 rounded-md border border-gray-300">
            </div>
            <div class="mb-4">
                <label for="dropoffLocation" class="block text-gray-600">Drop-off Location</label>
                <input type="text" id="dropoffLocation" name="dropoffLocation" class="w-full p-2 rounded-md border border-gray-300">
            </div>
            <div class="mb-4">
                <label for="startDate" class="block text-gray-600">Start Date</label>
                <input type="date" id="startDate" name="startDate" class="w-full p-2 rounded-md border border-gray-300">
            </div>
            <div class="mb-4">
                <label for="endDate" class="block text-gray-600">End Date</label>
                <input type="date" id="endDate" name="endDate" class="w-full p-2 rounded-md border border-gray-300">
            </div>
            <button type="submit" name="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md w-full">Reserve Now</button>
        </form>
    </div>
</div>



<script>
 document.querySelectorAll('.vehicle-card').forEach(card => {
    card.addEventListener('click', function () {
        const vehicleId = card.getAttribute('data-vehicle-id');
        document.getElementById('reservationModal').classList.remove('hidden');

        console.log(`Clicked Vehicle ID: ${vehicleId}`);
        handleCardClick(vehicleId);
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



    // function filterVehicles() {
    //     const searchInput = document.getElementById("searchInput").value.toLowerCase();
    //     const vehicleCards = document.querySelectorAll(".vehicle-card");
    //     vehicleCards.forEach((card) => {
    //         const model = card.getAttribute("data-model").toLowerCase();
    //         const categoryId = card.closest("[data-category-id]").getAttribute("data-category-id");

    //         const matchCategory = categoryFilter ? categoryFilter === categoryId : true;
    //         const matchSearch = model.includes(searchInput);

    //         if (matchCategory && matchSearch) {
    //             card.style.display = "block";
    //         } else {
    //             card.style.display = "none";
    //         }
    //     });
    // }
</script>



<div id="reservationsPage" class="page max-w-7xl mx-auto p-6 bg-gray-50">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">My Reservations</h2>
    
    <!-- No Reservations Placeholder -->
    <div class="flex flex-col items-center justify-center p-8 text-center" id="noReservationsMessage">
        <div class="animate-bounce">
            <i data-feather="car" class="w-16 h-16 text-red-500"></i>
        </div>
        <h2 class="mt-4 text-2xl font-bold text-gray-800">
            No Cars Reserved
        </h2>
        <p class="mt-2 text-lg text-gray-600">
            Choose Cars to reserve from our collection.
        </p>
    </div>

    <div id="reservationsList" class="mt-12 space-y-8">
        <div class="reservation-card bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-105">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <!-- <img src="../assets/image/vehicle1.jpg" alt="Car Model" class="w-40 h-40 object-cover rounded-md"> -->
                
                <div class="flex-1">
                    <h3 class="text-2xl font-semibold text-gray-800">Car Model</h3>
                    <p class="text-sm text-gray-500 mt-2">Reservation Date: <span class="font-semibold">Jan 5, 2025</span></p>
                    <p class="text-sm text-gray-500 mt-2">Duration: <span class="font-semibold">3 days</span></p>
                    <p class="mt-4 text-lg text-gray-600">Price: $<span class="font-semibold">120.00</span> per day</p>
                    <p class="mt-2 text-gray-600">Total: $<span class="font-semibold">360.00</span></p>
                    
                    <div class="flex gap-4 mt-6">
                        <button class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition duration-200 transform hover:scale-105">
                            Modify Reservation
                        </button>
                        <button class="bg-red-600 text-white py-2 px-6 rounded-md hover:bg-red-700 transition duration-200 transform hover:scale-105">
                            Cancel Reservation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function filterByCategory() {
    const categoryId = document.getElementById('categoryFilter').value;

    const formData = new FormData();
    formData.append('category', categoryId);

    fetch('filter_vehicles_by_category.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            const vehicleList = document.getElementById('vehicleList');
            vehicleList.innerHTML = ''; // Clear previous results

            if (data.length > 0) {
                data.forEach(vehicle => {
                    vehicleList.innerHTML += `
                        <div class="vehicle-card bg-white p-4 rounded-lg shadow-lg">
                            <img src="../assets/image/${vehicle.imageVeh}" alt="${vehicle.model}" class="w-full h-48 object-cover rounded-md mb-4">
                            <h3 class="text-xl font-semibold">${vehicle.model}</h3>
                            <p>Transmission: ${vehicle.transmissionType}</p>
                            <p>Fuel: ${vehicle.fuelType}</p>
                            <p>Price: $${vehicle.price_per_day}/day</p>
                        </div>`;
                });
            } else {
                vehicleList.innerHTML = '<p>No vehicles available in this category.</p>';
            }
        })
        .catch(error => console.error('Error fetching vehicles:', error));
}

// Attach the filter event listener
document.getElementById('categoryFilter').addEventListener('change', filterByCategory);

// Fetch all vehicles initially
filterByCategory();

</script>
    <script>
        //pour reserponsive 
    const hamburger = document.getElementById("hamburger");
    const mobileMenu = document.getElementById("mobileMenu");
    const closeMenu = document.getElementById("closeMenu");

    hamburger.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    closeMenu.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });



        document.addEventListener('DOMContentLoaded', function() {
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

        // Prevent back navigation
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.pushState(null, null, location.href);
        };
    </script>

<!--     
<script>
    function filterVehicles() {
        const searchInput = document.getElementById("searchInput").value.toLowerCase();
        const categoryFilter = document.getElementById("categoryFilter").value;
        const transmissionFilter = document.getElementById("transmissionFilter").value;
        const fuelFilter = document.getElementById("fuelFilter").value;
        const minPrice = document.getElementById("minPrice").value;
        const maxPrice = document.getElementById("maxPrice").value;

        const vehicleCards = document.querySelectorAll(".vehicle-card");
        vehicleCards.forEach((card) => {
            const model = card.getAttribute("data-model").toLowerCase();
            const categoryId = card.closest("[data-category-id]").getAttribute("data-category-id");
            const transmission = card.getAttribute("data-transmission");
            const fuel = card.getAttribute("data-fuel");
            const price = parseFloat(card.getAttribute("data-price"));

            const matchCategory = categoryFilter ? categoryFilter === categoryId : true;
            const matchTransmission = transmissionFilter ? transmission === transmissionFilter : true;
            const matchFuel = fuelFilter ? fuel === fuelFilter : true;
            const matchPrice = (minPrice ? price >= parseFloat(minPrice) : true) && (maxPrice ? price <= parseFloat(maxPrice) : true);
            const matchSearch = model.includes(searchInput);

            if (matchCategory && matchTransmission && matchFuel && matchPrice && matchSearch) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
</script> -->





</body>
</html>

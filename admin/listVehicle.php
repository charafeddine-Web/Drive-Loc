<?php
require_once '../autoload.php';
use Classes\Category;
use Classes\Vehicle;
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $model = trim(htmlspecialchars($_POST['model']));
        $price_day = trim(htmlspecialchars($_POST['price_day']));
        $disponibilite = trim(htmlspecialchars($_POST['disponibilite']));
        $transmissionType = trim(htmlspecialchars($_POST['transmissionType']));
        $fuelType = trim(htmlspecialchars($_POST['fuelType']));
        $category = trim(htmlspecialchars($_POST['category']));
        $mileage = trim(htmlspecialchars($_POST['mileage']));
        $imageVeh=$_FILES['imageVeh'];
       

        if (empty($model) || empty($price_day) || empty($disponibilite) || empty($transmissionType) || empty($fuelType) || empty($mileage)) {
            throw new Exception("All fields are required!");
        }
        $vehicle = new Vehicle(null, $model, $price_day, $disponibilite, $transmissionType, $fuelType, $mileage, $imageVeh,$category);
        $vehicle->addVeh();
    }
} catch (\Exception $e) {
    echo "Error Adding Vehicle: " . $e->getMessage();
}


//statistic

$result= Vehicle::showStatistic();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href=".././assets/style.css">
    <script src=".././assets/tailwind.js"></script>
</head>

<body class="">
    <div class=" fixed top-0 left-0  w-[230px] h-[100%] z-50 overflow-hidden sidebar ">
        <a href="" class="logo text-xl font-bold h-[56px] flex items-center text-[#1976D2] z-30 pb-[20px] box-content">
            <i class=" mt-4 text-xxl max-w-[60px] flex justify-center "><i class="fa-solid fa-car-side"></i></i>
            <div class="logoname ml-2"><span>Drive
                </span>Loc</div>
        </a>
        <ul class="side-menu w-full mt-12">
            <li class=" h-12 bg-transparent ml-2.5 rounded-l-full p-1"><a href="index.php"> <i class="fa-solid fa-file-contract"></i>Statistic</a></li>
            <li class=" h-12 bg-transparent ml-2.5 rounded-l-full p-1"><a href="listClients.php">
            <i class="fa-solid fa-user-group"></i>Clients</a></li>
            <li class=" active h-12 bg-transparent ml-1.5 rounded-l-full p-1"><a href="listVehicle.php"><i
            class="fa-solid fa-car"></i></i>Vehicles</a></li>
            <li class=" h-12 bg-transparent ml-1.5 rounded-l-full p-1"><a href="listCategory.php"><i
                        class="fa-solid fa-chart-simple"></i>Category</a></li>
        </ul>
        <ul class="side-menu w-full mt-12">
            <li class="h-12 bg-transparent ml-2.5 rounded-l-full p-1">
                <a href="../Visiteur/logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i> Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->

    <!-- Content -->
    <div class="content ">
        <!-- Navbar -->
        <nav class="flex items-center gap-6 h-14 bg-[#f6f6f9] sticky top-0 left-0 z-50 px-6">
            <i class='bx bx-menu'></i>
            <form action="#" class="max-w-[400px] w-full mr-auto">
                <div class="form-input flex items-center h-[36px]">
                    <input
                        class="flex-grow px-[16px] h-full border-0 bg-[#eee] rounded-l-[36px] outline-none w-full text-[#363949]"
                        type="search" placeholder="Search...">
                    <button
                        class="w-[80px] h-full flex justify-center items-center bg-[#1976D2] text-[#f6f6f9] text-[18px] border-0 outline-none rounded-r-[36px] cursor-pointer"
                        type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle"
                class="theme-toggle block min-w-[50px] h-[25px] bg-grey cursor-pointer relative rounded-full"></label>
            <a href="#" class="notif text-[20px] relative">
                <i class='bx bx-bell'></i>
                <span
                    class="count absolute top-[-6px] right-[-6px] w-[20px] h-[20px] bg-[#D32F2F] text-[#f6f6f6] border-2 border-[#f6f6f9] font-semibold text-[12px] flex items-center justify-center rounded-full ">12</span>
            </a>
            <a href="#" class="profile">
                <img class="w-[36px] h-[36px] object-cover rounded-full" width="36" height="36"
                    src=".././assets/image/charaf.png.jfif">
            </a>
        </nav>

        <main class=" mainn w-full p-[36px_24px] max-h-[calc(100vh_-_56px)]">
            <div class="header flex items-center justify-between gap-[16px] flex-wrap">
                <div class="left">
                    <ul class="breadcrumb flex items-center space-x-[16px]">
                        <li class="text-[#363949]"><a href="listClients.php">
                                index &npr;
                            </a></li>
                        /
                        <li class="text-[#363949]"><a href="listCars.php">Clients &npr;</a></li> /
                        <li class="text-[#363949]"><a href="listContrat.php" class="active">Vehicles &npr;</a></li> /
                        <li class="text-[#363949]"><a href="statistic.php">Categorys &npr;</a></li>

                    </ul>

                </div>
                <a id="buttonadd" href="#"
                    class="report h-[36px] px-[16px] rounded-[36px] bg-[#1976D2] text-[#f6f6f6] flex items-center justify-center gap-[10px] font-medium">
                    <i class="fa-solid fa-car"></i>
                    <span>Add Vehicle</span>
                </a>
            </div>
            <!-- insights-->
            <ul class="insights grid grid-cols-[repeat(auto-fit,_minmax(240px,_1fr))] gap-[24px] mt-[36px]">
                <!-- <li>
                    <i class="fa-solid fa-user-group"></i>
                    <span class="info">
                        <h3>
                            <?php
                            // echo $result['total_clients'];
                            ?>
                        </h3>
                        <p>All Vehicles </p>
                    </span>
                </li> -->
                <li><i class="fa-solid fa-file-signature"></i>
                    <span class="info">
                        <h3>
                            <?php
                             if ($result && isset($result['total_vec_Unavailable'])) {
                                echo $result['total_vec_Unavailable'];
                            } else {
                                echo "No data available.";
                            }
                            ?>
                        </h3>
                        <p>Vehicles Unavailable</p>
                    </span>
                </li>
                <li><i class="fa-solid fa-car-side"></i>
                    <span class="info">
                        <h3>
                            <?php
                            if ($result && isset($result['total_veh_Available'])) {
                                echo $result['total_veh_Available'];
                            } else {
                                echo "No data available.";
                            }
                            ?>
                        </h3>
                        <p>Vehicles Available</p>
                    </span>
                </li>
               
            </ul>
            <!---- data content ---->
            <div class="bottom-data flex flex-wrap gap-[24px] mt-[24px] w-full ">
                <div class="orders  flex-grow flex-[1_0_500px]">
                    <div class="header  flex items-center gap-[16px] mb-[24px]">
                        <i class='bx bx-list-check'></i>
                        <h3 class="mr-auto text-[24px] font-semibold">List Vehicles</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                    </div>
                    <!--- tables---->
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="">
                                <th class="pb-3 px-3 text-sm text-left border-b border-grey">Registration number</th>
                                <th class="pb-3 px-3 text-sm text-left border-b border-grey">Image</th>
                                <th class="pb-3 px-3 text-sm text-left border-b border-grey">Model </th>
                                <th class="pb-3 px-3 text-sm text-left border-b border-grey">Price/day</th>
                                <th class="pb-3 px-3 text-sm text-left border-b border-grey">transmission Type</th>
                                <th class="pb-3 px-5 text-sm text-left border-b border-grey">Fuel Type</th>
                                <th class="pb-3 px-5 text-sm text-left border-b border-grey">Mileage</th>
                                <th class="pb-3 px-5 text-sm text-left border-b border-grey">Disponibilite</th>
                                <th class="pb-3 px-5 text-sm text-left border-b border-grey">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                            try {
                                $vehicle = Vehicle::ShowVeh();
                    
                                if ($vehicle) {
                                    foreach ($vehicle as $vh) {
                                        $availabilityColor = $vh['availability'] === 'Available' ? 'text-green-500' : 'text-red-500';
                                        $availabilityText = ucfirst($vh['availability']); 
                                        echo "<tr>";
                                        echo '<td class="border p-2">' . htmlspecialchars($vh['id_vehicle']) . '</td>';
                                        echo '<td class="border p-2"><img src="../assets/image/' . htmlspecialchars($vh['imageVeh']) . '" alt="Vehicle Image" class="w-20 h-20 rounded shadow-md" /></td>';
                                        echo '<td class="border p-2">' . htmlspecialchars($vh['model']) . '</td>';
                                        echo '<td class="border p-2">' . htmlspecialchars($vh['price_per_day']) . '</td>';
                                        echo '<td class="border p-2">' . htmlspecialchars($vh['transmissionType']) . '</td>';
                                        echo '<td class="border p-2">' . htmlspecialchars($vh['fuelType']) . '</td>';
                                        echo '<td class="border p-2">' . htmlspecialchars($vh['mileage']) . '</td>';
                                        echo '<td class="border p-2"><span class="' . $availabilityColor . ' text-center">' . $availabilityText . '</span></td>';
                                        echo '<td class="border p-2 flex items-center justify-between">';
                                        echo '<a href="edit_vehicle.php?id=' . $vh['id_vehicle'] . '" class="text-blue-500 hover:text-blue-700">Edit</a> | ';
                                        echo '<a href="delete_vehicle.php?id=' . $vh['id_vehicle'] . '" class="text-red-500 hover:text-red-700" onclick="return confirm(\'Are you sure you want to delete this vehicle?\')">Delete</a> | ';
                                        echo '<a href="view_vehicle.php?id=' . $vh['id_vehicle'] . '" class="text-green-500 hover:text-green-700">View</a>';
                                        echo '</td>';
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center p-2'>No vehicles available.</td></tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='8' class='text-center p-2 text-red-500'>Error: " . $e->getMessage() . "</td></tr>";
                            }
                            
                        
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="addClientForm"
        class="add-client-form fixed right-[-100%] rounded-xl w-full max-w-[400px] h-[580px] shadow-[2px_0_10px_rgba(0,0,0,0.1)] flex flex-col gap-5 transition-all duration-700 ease-in-out z-50 top-[166px] bg-white">
        <form action="" method="post" enctype="multipart/form-data"
            class="flex flex-col gap-4 overflow-y-auto h-full p-6 pb-20">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold ">Add Car</h2>
                <button type="button" id="closeForm"
                    class="close-btn bg-red-500 text-white font-extrabold px-4 py-2 rounded-lg cursor-pointer transition-all duration-500 ease-in-out">
                    X</button>
            </div>

                <div class="form-group flex flex-col">
                    <label for="category" class="text-sm text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" class="p-2 border border-gray-300 rounded-lg outline-none text-sm">
                        <?php
                        try {
                            $category = new Category();
                            $resultCat = $category->ShowCategory();
                            
                            if ($resultCat) {
                                foreach ($resultCat as $cat) {
                                    echo '<option value="' . htmlspecialchars($cat['id']) . '">' . htmlspecialchars($cat['name']) . '</option>';
                                }
                            } else {
                                echo '<option value="">No categories found</option>';
                            }
                        } catch (\PDOException $e) {
                            echo "Error showing Category: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>


            <div class="form-group flex flex-col">
                <label for="model" class="text-sm text-gray-700 mb-1">Model</label>
                <input name="model" type="text" id="model" placeholder="Enter the vehicle model"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm" required>
            </div>

            <div class="form-group flex flex-col">
                <label for="price_day" class="text-sm text-gray-700 mb-1">Price/day</label>
                <input type="number" id="price_day" name="price_day" placeholder="Enter the vehicle price/day"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm" required>
            </div>

            <div class="form-group flex flex-col">
                <label for="disponibilite" class="text-sm text-gray-700 mb-1">Availability</label>
                <select name="disponibilite" id="disponibilite"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm">
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <div class="form-group flex flex-col">
                <label for="transmissionType" class="text-sm text-gray-700 mb-1">Transmission Type</label>
                <select name="transmissionType" id="transmissionType"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm">
                    <option value="automatic">Automatic</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div class="form-group flex flex-col">
                <label for="fuelType" class="text-sm text-gray-700 mb-1">Fuel Type</label>
                <select name="fuelType" id="fuelType"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm">
                    <option value="petrol">Petrol</option>
                    <option value="diesel">Diesel</option>
                    <option value="electric">Electric</option>
                </select>
            </div>

            <div class="form-group flex flex-col">
                <label for="mileage" class="text-sm text-gray-700 mb-1">Mileage</label>
                <input type="number" name="mileage" id="mileage" placeholder="Enter the vehicle mileage"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm" required>
            </div>

            <div class="form-group flex flex-col">
                <label for="imageVeh" class="text-sm text-gray-700 mb-1">Vehicle Image</label>
                <input type="file" name="imageVeh" id="imageVeh" accept="image/*"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm">
            </div>

            <button type="submit"
                class="submit-btn bg-blue-500 text-white px-4 py-2 rounded-lg cursor-pointer transition-all duration-500 ease-in-out"
                name="submit">Add Vehicle</button>
        </form>
    </div>



    <div id="editform"
        class="add-client-form fixed  right-[-100%] w-full max-w-[400px] h-[580px] shadow-[2px_0_10px_rgba(0,0,0,0.1)] p-6 flex flex-col gap-5 transition-all duration-700 ease-in-out z-50 top-[166px]">
        <form action=".././controllers/controlCar.php?Numedit=<?php echo $val[0]['NumImmatriculation'] ?>" method="post"
            class="flex flex-col gap-4">
            <h2 class="text-2xl font-semibold  mb-5">Update Car</h2>
            <div class="form-group flex flex-col">
                <label for="nummatrucle" class="text-sm text-gray-700  mb-1">New Registration number</label>
                <input name="NumMatricle" type="text" id="nummatrucle" placeholder="Enter the vehicle Sirie"
                    class="p-2 border border-gray-300 rounded-lg outline-none text-sm" value="<?php if (isset($val[0]['NumImmatriculation']))
                        echo $val[0]['NumImmatriculation'] ?>">
            </div>
                <div class="form-group flex flex-col">
                    <label for="marque" class="text-sm text-gray-700 mb-1">New Mark</label>
                    <input name="Mark" type="text" id="marque" placeholder="Enter the vehicle Mark"
                        class="p-2 border border-gray-300 rounded-lg outline-none text-sm" value="<?php if (isset($val[0]['Marque']))
                        echo $val[0]['Marque'] ?>">
                </div>
                <div class="form-group flex flex-col">
                    <label for="Model" class="text-sm text-gray-700 mb-1">New Model</label>
                    <input name="Model" type="text" id="Model" placeholder="Enter the vehicle Model"
                        class="p-2 border border-gray-300 rounded-lg outline-none text-sm" value="<?php if (isset($val[0]['Modele']))
                        echo $val[0]['Modele'] ?>">
                </div>
                <div class="form-group flex flex-col">
                    <label for="year" class="text-sm text-gray-700 mb-1">New Year</label>
                    <input type="number" id="vehicleYear" name="vehYear" min="2008" max="2024" required
                        placeholder="Enter the vehicle year"
                        class="p-2 border border-gray-300 rounded-lg outline-none text-sm" value="<?php if (isset($val[0]['Annee']))
                        echo $val[0]['Annee'] ?>">
                </div>
                <div class="form-group flex flex-col">
                    <label for="carImage" class="text-sm text-gray-700 mb-1">Car Image</label>
                    <input type="text" name="carImage" id="carImage" accept="image/*"
                        class="p-2 border border-gray-300 rounded-lg outline-none text-sm" value="<?php if (isset($val[0]['Image']))
                        echo $val[0]['Image'] ?>">
                </div>
                <button type="submit"
                    class="submit-btn border-none px-4 py-2 rounded-lg cursor-pointer transition-all duration-500 ease-in-out"
                    name="editveh">Edit</button>
                <button type="button" id="colseedit"
                    class="close-btn border-none px-4 py-2 rounded-lg cursor-pointer transition-all duration-500 ease-in-out">Close</button>
            </form>
        </div>


        <script src=".././assets/main.js"></script>
    </body>

    </html>
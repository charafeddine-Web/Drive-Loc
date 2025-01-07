<?php
// require_once '../autoload.php';
require_once '../classes/theme.php';
session_start();

if (!isset($_SESSION['id_user']) || (isset($_SESSION['id_role']) && $_SESSION['id_role'] !== 1)) {
    header("Location: ../index.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addTheme'])) {
    $themeName = $_POST['themeName'];
    $themeDescription = $_POST['themeDescription'];

    if (!empty($themeName) && !empty($themeDescription)) {
        try {
            $category = new theme(null,null, null);
            $category->AddTheme($themeName, $themeDescription);  
            header('Location: listTheme.php');
            exit();  
        } catch (Exception $e) {
            echo 'Error adding Theme: ' . $e->getMessage();
        }
    } else {
        echo 'Please fill in both fields.';
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="refresh" content="5"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../assets/style.css">
    <script src=".././assets/tailwind.js"></script>
</head>

<body class="">
    <!-- Side Bar -->
    <div class="fixed top-0 left-0 w-[230px] h-[100%] z-50 overflow-hidden sidebar">
    <a href="" class="logo text-xl font-bold h-[56px] flex items-center text-[#1976D2] z-30 pb-[20px] box-content">
        <i class="mt-4 text-xxl max-w-[60px] flex justify-center">
            <i class="fa-solid fa-car-side"></i>
        </i>
        <div class="logoname ml-2">
            <span>Drive</span>Loc
        </div>
    </a>
    
    <ul class="side-menu w-full mt-12">
        <li class=" h-12 bg-transparent ml-2.5 rounded-l-full p-1"><a href="../../admin/index.php"><i class="fa-solid fa-file-contract"></i>Statistic</a></li>
        <li class="h-12 bg-transparent ml-2.5 rounded-l-full p-1"><a href="../../admin/listClients.php"><i class="fa-solid fa-user-group"></i>Clients</a></li>
        <li class="h-12 bg-transparent ml-1.5 rounded-l-full p-1"><a href="../../admin/listVehicle.php"><i class="fa-solid fa-car"></i>Vehicles</a></li>
        <li class="h-12 bg-transparent ml-1.5 rounded-l-full p-1"><a href="../../admin/listCategory.php"><i class="fa-solid fa-chart-simple"></i>Category</a></li>
        
        <li class="h-12 bg-transparent ml-1.5 rounded-l-full p-1">
            <a href="" class="blog-management">
                <i class="fa-solid fa-cogs"></i> 
                Blog Management📌
            </a>
        </li>
        
        <li class="active h-12 ml-8 bg-transparent  rounded-l-full p-1">
            <a href="./listTheme.php" class="Themes-management">
                <i class="fa-solid fa-palette"></i> Themes
            </a>
        </li>
        
        <li class=" h-12 bg-transparent ml-8 rounded-l-full p-1">
            <a href="./listArticle.php" class="Articles-management">
                <i class="fa-solid fa-newspaper"></i> Articles
            </a>
        </li>
        
        <li class=" h-12 bg-transparent ml-8 rounded-l-full p-1">
            <a href="./listTags.php" class="Tags-management">
                <i class="fa-solid fa-tags"></i> Tags
            </a>
        </li>
        <li class=" h-12 bg-transparent ml-8 rounded-l-full p-1">
            <a href="./listcomments.php" class="Comments-management">
                <i class="fa-solid fa-comments"></i> Comments
            </a>
        </li>
    </ul>

    <ul class="side-menu w-full mt-20">
        <li class="h-12 bg-transparent ml-2.5 rounded-l-full p-1">
            <a href="../../Visiteur/logout.php" class="logout">
                <i class="bx bx-log-out-circle"></i> Logout
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
            <img class="w-[36px] h-[36px] object-cover rounded-full" width="36" height="36" src="../../assets/image/charaf.png.jfif">
            </a>
        </nav>
        <!-- end nav -->
        <main class=" mainn w-full p-[36px_24px] max-h-[calc(100vh_-_56px)]">
            <div class="header flex items-center justify-between gap-[16px] flex-wrap">
                <div class="left">
                <ul class="breadcrumb flex items-center space-x-[16px]">
                        <li class=" text-[#363949]"><a class="active" href="listClients.php">
                        Themes &npr;
                            </a></li>
                        /
                        <li class=" text-[#363949]"><a href="listCars.php"  >Articles &npr;</a></li> /
                        <li class="text-[#363949]"><a href="listContrat.php">Tags &npr;</a></li> /
                        <li class="text-[#363949]"><a href="statistic.php" >Comments &npr;</a></li>

                    </ul>

                </div>
                <a id="buttonadd" href="#"
                    class="report h-[36px] px-[16px] rounded-[36px] bg-[#1976D2] text-[#f6f6f6] flex items-center justify-center gap-[10px] font-medium">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Theme</span>
                    </a>

            </div>
            <!-- insights-->
            <!-- <ul class="insights grid grid-cols-[repeat(auto-fit,_minmax(240px,_1fr))] gap-[24px] mt-[36px]">
                <li>
                    <i class="fa-solid fa-user-group"></i>
                    <span class="info">
                        <h3>
                            <?php
                            // echo $result['total_clients'];
                            ?>
                        </h3>
                        <p>Clients</p>
                    </span>
                </li>
                <li><i class="fa-solid fa-car-side"></i>
                    <span class="info">
                        <h3>
                            <?php
                            // echo $resultv['total_voitures'];
                            ?>
                        </h3>
                        <p>Cars</p>
                    </span>
                </li>
                <li><i class="fa-solid fa-file-signature"></i>
                    <span class="info">
                        <h3>
                            <?php
                            // echo $resultc['total_contrats'];
                            ?>
                        </h3>
                        <p>Contrats</p>
                    </span>
                </li>
            </ul> -->
            <!---- data content ---->
            <div class="bottom-data flex flex-wrap gap-[24px] mt-[24px] w-full px-4 sm:px-6 md:px-8">
    <div class="orders w-full lg:w-1/2 xl:w-2/3 flex-grow">
        <div class="header flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <i class='bx bx-list-check text-2xl text-blue-500'></i>
                <h3 class="text-2xl font-semibold text-gray-800">List Themes</h3>
            </div>
            <div class="flex items-center gap-4">
                <i class='bx bx-filter text-xl text-gray-600 hover:text-blue-500 cursor-pointer'></i>
                <i class='bx bx-search text-xl text-gray-600 hover:text-blue-500 cursor-pointer'></i>
            </div>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto shadow-md border rounded-lg">
            <table class="w-full table-auto">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="py-3 px-5 text-sm text-left text-gray-700 border-b">Registration ID</th>
                        <th class="py-3 px-5 text-sm text-left text-gray-700 border-b">Name</th>
                        <th class="py-3 px-5 text-sm text-left text-gray-700 border-b">Description</th>
                        <th class="py-3 px-5 text-sm text-left text-gray-700 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $theme = new Theme(null, null, null);
                        $result = $theme->ShowThemes();
                        if ($result) {
                            foreach ($result as $rs) {
                                echo "<tr class='hover:bg-gray-50'>";
                                echo '<td class="border-t py-3 px-5 text-sm text-gray-700">' . htmlspecialchars($rs['idTheme']) . '</td>';
                                echo '<td class="border-t py-3 px-5 text-sm text-gray-700">' . htmlspecialchars($rs['name']) . '</td>';
                                echo '<td class="border-t py-3 px-5 text-sm text-gray-700">' . htmlspecialchars($rs['description']) . '</td>';
                                echo '<td class="border-t py-3 px-5 text-sm text-gray-700 flex items-center justify-start gap-3">';
                                echo '<a href="javascript:void(0);" class="buttonedit text-blue-500 hover:text-blue-700" 
                                    data-id="' . htmlspecialchars($rs['idTheme']) . '" 
                                    data-name="' . htmlspecialchars($rs['name']) . '" 
                                    data-description="' . htmlspecialchars($rs['description']) . '">Edit</a>';
                                echo '<a href="delete_theme.php?idTheme=' . $rs['idTheme'] . '" class="text-red-500 hover:text-red-700" onclick="return confirm(\'Are you sure you want to delete this theme?\')">Delete</a>';
                                echo '<a href="javascript:void(0);" 
                                class="text-green-500 hover:text-green-700"
                                onclick="showCategoryDetails(' . htmlspecialchars($rs['idTheme']) . ')">
                                View
                              </a>';
                                            
                                echo '</td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center p-4 text-gray-500'>No themes available.</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='4' class='text-center p-4 text-red-500'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        </main>
    </div>
    <div id="addClientForm" class="add-client-form fixed right-[-100%] w-full max-w-[400px] h-[650px] shadow-lg p-8 flex flex-col gap-6 transition-all duration-700 ease-in-out z-50 top-[166px] bg-white rounded-lg">
    <form action="" method="post" class="flex flex-col gap-6">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Add Theme</h2>
                <div class="form-group flex flex-col">
            <label for="themeName" class="text-sm font-medium text-gray-700 mb-2">Theme Name</label>
            <input name="themeName" type="text" id="themeName" placeholder="Enter theme name"
                class="p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out text-sm">
        </div>
        <div class="form-group flex flex-col">
            <label for="themeDescription" class="text-sm font-medium text-gray-700 mb-2">Theme Description</label>
            <textarea name="themeDescription" id="themeDescription" rows="4" placeholder="Enter theme description"
                class="p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out text-sm"></textarea>
        </div>
        <button type="submit" class="submit-btn bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300 ease-in-out hover:bg-blue-700"
            name="addTheme">Add Theme</button>
                <button type="button" id="closeForm" class="close-btn bg-gray-500 text-white px-5 py-2 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300 ease-in-out hover:bg-gray-600">
            Close
        </button>
    </form>
</div>

<div id="editThemeForm" class="hidden fixed right-0 w-full max-w-[400px] h-[650px] shadow-lg p-8 flex flex-col gap-6 transition-all duration-700 ease-in-out z-50 top-[166px] bg-white rounded-lg">
    <form action="edit_Theme.php" method="post" class="flex flex-col gap-6">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Theme</h2>
        <input type="hidden" name="editThemeId" id="editThemeId">
        <div class="form-group flex flex-col">
            <label for="editThemeName" class="text-sm font-medium text-gray-700 mb-2">Theme Name</label>
            <input name="editThemeName" type="text" id="editThemeName" placeholder="Enter theme name"
                class="p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out text-sm">
        </div>
        <div class="form-group flex flex-col">
            <label for="editThemeDescription" class="text-sm font-medium text-gray-700 mb-2">Theme Description</label>
            <textarea name="editThemeDescription" id="editThemeDescription" rows="4" placeholder="Enter theme description"
                class="p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out text-sm"></textarea>
        </div>

        <button type="submit" class="submit-btn bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300 ease-in-out hover:bg-green-700"
            name="editTheme">Save Changes</button>

        <button type="button" id="closeForme" class="close-btn bg-gray-500 text-white px-5 py-2 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300 ease-in-out hover:bg-gray-600">
            Close
        </button>
    </form>
</div>
            <script>
                const editButtons = document.querySelectorAll('.buttonedit');
                const editForm = document.getElementById('editThemeForm');
                const closeForm = document.getElementById('closeForme');
                closeForm.addEventListener('click', function () {
                    editForm.classList.add('hidden');
                });
                editButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const themeId = this.getAttribute('data-id');
                        const themeName = this.getAttribute('data-name');
                        const themeDescription = this.getAttribute('data-description');
                        document.getElementById('editThemeId').value = themeId;
                        document.getElementById('editThemeName').value = themeName || '';
                        document.getElementById('editThemeDescription').value = themeDescription || '';
                        editForm.classList.remove('hidden');
                    });
                });
            </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        function showCategoryDetails(id) {
            fetch('view_theme_details.php?idTheme=' + id)
                .then(response => response.text())
                .then(data => {
                    Swal.fire({
                        title: 'Theme Details',
                        html: data, // The HTML content returned from PHP
                        icon: 'info',
                        showCloseButton: true,
                        confirmButtonText: 'Close'
                    });
                })
                .catch(error => {
                    console.error('Error fetching theme details:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Unable to fetch theme details.',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                });
        }

</script>
        <script src="../../assets/main.js"></script>
    </body>

    </html>
<?php
require_once '../classes/Article.php';
require_once '../classes/Theme.php';
session_start();
if ((!isset($_SESSION['id_user']) && $_SESSION['id_role'] !== 2)) {
    header("Location: ../../Visiteur/login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitarticle'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $theme_id = $_POST['theme_id'];
    $tags = explode(',', $_POST['tags']);
    $auteur_id = isset($_POST['auteur_id']) ? (int) $_POST['auteur_id'] : null;
    $imageArt = $_FILES['imageArt']['name'] ?? null;
    $video = $_FILES['video']['name'] ?? null;

    if (isset($_FILES['imageArt']) && $_FILES['imageArt']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['imageArt']['tmp_name'];
        $imageName = basename($_FILES['imageArt']['name']);
        $imageDir = '../../assets/image/';
        $imagePath = $imageDir . $imageName;
        if (!move_uploaded_file($imageTmpPath, $imagePath)) {
            echo "Error uploading image.";
            return;
        }
    } else {
        $imagePath = null;
    }
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $videoTmpPath = $_FILES['video']['tmp_name'];
        $videoName = basename($_FILES['video']['name']);
        $videoDir = '../../assets/video/';
        $videoPath = $videoDir . $videoName;
        if (!move_uploaded_file($videoTmpPath, $videoPath)) {
            echo "Error uploading video.";
            return;
        }
    } else {
        $videoPath = null;
    }
    try {
        $auteur_id = (int) $auteur_id;
        $article = new Article(null, $title, $content, $imagePath, $videoPath, null, $theme_id, $auteur_id, 'pending', $tags);
        $article->addArticle();
    } catch (\PDOException $e) {
        echo "Error Adding Article: " . $e->getMessage();
    }
}


//recupere tout les themes
$theme = new Theme(null, null, null);
$themes = $theme->ShowThemes();
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


        /**just pour les tag */
        .tag {
            background-color: #e5f4ff;
            color: #007bff;
            border-radius: 5px;
            padding: 5px 10px;
            margin: 5px;
            display: flex;
            align-items: center;
        }

        .tag span {
            cursor: pointer;
            margin-left: 5px;
            font-weight: bold;
        }

        .liked {
            color: red;
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
                            <i class="fa-solid fa-car-rear mr-2"></i> Cars
                        </a>
                        <a href="../../client/index.php" id="showReservations"
                            class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-clock-rotate-left mr-2"></i> Reservations
                        </a>
                        <a href="./blogs.php" id="showBlog"
                            class="nav-link  text-lg active font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-book-open mr-2"></i>All Blogs
                        </a>
                        <a href="./index.php" id="showBlog"
                            class="nav-link  text-lg  font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-book-open mr-2"></i>Blogs
                        </a>
                        <a href="./index.php" id="showBlog"
                            class="nav-link  text-lg  font-semibold hover:text-blue-800 transition-colors flex items-center">
                            <i class="fa-solid fa-book-open mr-2"></i>Favoraite
                        </a>
                        <a href="./comments.php" id="showBlogMobile"
                            class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                            <i class="fa-solid fa-comments mr-2"></i> Comment
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
                    class="nav-link active text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-car-rear mr-2"></i> Available Cars
                </a>
                <a href="../../client/index.php" id="showReservationsMobile"
                    class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> My Reservations
                </a>
                <a href="./index.php" id="showBlogMobile"
                    class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
                    <i class="fa-solid fa-book-open mr-2"></i> Blogs
                </a>
                <a href="./index.php" id="showBlogMobile"
                    class="nav-link text-lg font-semibold hover:text-blue-800 transition-colors py-2 px-4 w-full text-center">
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

    <div id="addArticleModal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex justify-center items-center">
    <div class="bg-white shadow-xl rounded-lg p-8 w-11/12 md:w-2/3 lg:w-1/3 relative mt-10 mb-20">
        <!-- Close Button -->
        <button id="closeModal" 
            class="absolute top-1 right-4 text-gray-500 hover:text-red-600 transition text-xl">
            &times;
        </button>
        <!-- Modal Header -->
        <h3 class="text-2xl font-semibold text-gray-700 text-center mb-2">Add New Article</h3>
        <!-- Modal Form -->
        <form id="addArticleForm" method="POST" action="" enctype="multipart/form-data">
            
            <div class="flex items-center justify-between">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-600">Title</label>
                <input type="text" id="title" name="title" required
                    class="w-full mt-1 p-3 rounded-md border border-gray-300 focus:ring-blue-400 focus:border-blue-400">
            </div>
            <div class="mb-4">
                <label for="theme_id" class="block text-sm font-medium text-gray-600">Theme</label>
                <select id="theme_id" name="theme_id" required
                    class="w-full mt-1 p-3 rounded-md border border-gray-300 focus:ring-blue-400 focus:border-blue-400">
                    <option value="">Select Theme</option>
                    <?php foreach ($themes as $theme): ?>
                        <option value="<?php echo htmlspecialchars($theme['idTheme']); ?>">
                            <?php echo htmlspecialchars($theme['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-600">Content</label>
                <textarea id="content" name="content" rows="5" required
                    class="w-full mt-1 p-3 rounded-md border border-gray-300 focus:ring-blue-400 focus:border-blue-400"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <div class="mb-4">
                    <label for="imageArt" class="block text-sm font-medium text-gray-600">Image</label>
                    <input type="file" id="imageArt" name="imageArt" accept="image/*"
                        class="w-full mt-1 p-2 rounded-md border border-gray-300 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div class="mb-4">
                    <label for="video" class="block text-sm font-medium text-gray-600">Video</label>
                    <input type="file" id="video" name="video" accept="video/*"
                        class="w-full mt-1 p-2 rounded-md border border-gray-300 focus:ring-blue-400 focus:border-blue-400">
                </div>
            </div>
            
           
            <div class="mb-6">
                <label for="tags" class="block text-sm font-medium text-gray-600">Tags</label>
                <div id="tags-container" class="flex flex-wrap items-center p-2 border border-gray-300 rounded-md">
                    <input type="text" id="tag-input" placeholder="Add a tag" 
                        class="flex-grow p-2 outline-none text-sm text-gray-700">
                </div>
                <input type="hidden" name="tags" id="tags-hidden">
                <p class="text-xs text-gray-500 mt-2">Press Enter or type a comma to add a tag.</p>
            </div>
            <input type="hidden" id="auteur_id" name="auteur_id" value="<?php echo $_SESSION['id_user']; ?>">
            <button type="submit" name="submitarticle"
                class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 px-6 rounded-lg w-full hover:from-blue-600 hover:to-blue-800 transition">Add
                Article</button>
        </form>
    </div>
</div>

       <div id="ArticlesPage" class="max-full fixed mx-auto p-6 bg-gray-900" style="left:0px;right:0px">
            <div class="flex flex-col md:flex-row items-center justify-between mt-14">
                <h3 class="text-3xl font-bold text-gray-50">My Articles</h3>
                <div class="mt-6 flex flex-col md:flex-row justify-between gap-8">
                    <div class="flex items-center space-x-4">
                        <label for="themeFilter" class="text-gray-50">Filter by Theme:</label>
                        <select id="theme_id" name="theme_id" required
                            class="w-full mt-1 p-3 rounded-md border border-gray-300 focus:ring-blue-400 focus:border-blue-400">
                            <option value="">Select Theme</option>
                            <?php foreach ($themes as $theme): ?>
                                <option value="<?php echo htmlspecialchars($theme['idTheme']); ?>">
                                    <?php echo htmlspecialchars($theme['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex items-center space-x-4">
                        <label for="tagSearch" class="text-gray-50">Search by Tags:</label>
                        <input type="text" id="tagSearch" name="tags" class="p-2 border border-gray-300 rounded-lg" placeholder="Search by tags...">
                    </div>
                    

                <button id="addarticle" class="bg-blue-600 ml-20 text-white py-2 px-4 rounded-lg hover:bg-blue-500 transition">
                    Add Article
                </button>
            </div>
        </div>
        </div>
     
        <div id="filteredResults" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 px-4">
    <!-- Results will be dynamically loaded here -->
</div>
<script>
    // Function to apply the filter
    async function applyFilter() {
        const themeId = document.getElementById('theme_id').value;
        const params = new URLSearchParams();
        if (themeId) {
            params.append('theme_id', themeId);
        }

        try {
    const response = await fetch('filter_articles.php?' + params.toString(), {
        method: 'GET',
    });
    console.log('Request URL:', 'filter_articles.php?' + params.toString()); // Log the URL for debugging
    if (response.ok) {
        const resultHTML = await response.text();
        console.log('Response:', resultHTML); // Log the response for debugging
        document.getElementById('filteredResults').innerHTML = resultHTML;
    } else {
        console.error('Error fetching data:', response.status);
    }
} catch (error) {
    console.error('Error fetching data:', error);
}
    }
</script>
        <?php if (isset($_SESSION['id_user'])): ?>
            <?php
            $id = $_SESSION['id_user'];
            $articles = new Article(null, null, null, null, null, null, null, $id, null, null);
            $rs = $articles->ShowArticles_Client();
            ?>
        <?php endif; ?>

        <?php if ($rs): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 px-4">
        <?php 
        $hasAcceptedArticles = false;
        foreach ($rs as $r): 
            if ($r['status'] == "accepted"): 
                $hasAcceptedArticles = true; // Mark that we have at least one accepted article
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
            <div class="bg-white rounded-lg shadow-md overflow-hidden md:mt-40 mt-40">
                <!-- Post Header -->
                <div class="flex items-center p-4 justify-between">
                    <div class="flex items-center">
                        <img src="../../assets/user.png" alt="User Profile" class="w-10 h-10 rounded-full">
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-800"><?php echo $_SESSION['fullname']?></p>
                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($r['created_at']); ?></p>
                        </div>
                    </div>
                    <button class="text-gray-600 hover:text-gray-800 optionsMenu">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                </div>

                <!-- Post Content -->
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($r['title']); ?></h3>
                    <p class="text-sm text-gray-600 truncate"><?php echo htmlspecialchars($r['content']); ?></p>

                    <?php if (!empty($r['video'])): ?>
                        <video controls autoplay class="w-full h-80 mt-4 rounded">
                            <source src="../../assets/video/<?php echo htmlspecialchars($r['video']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php elseif (!empty($r['imageArt'])): ?>
                        <img src="../../assets/image/<?php echo htmlspecialchars($r['imageArt']); ?>" alt="Article Image" class="w-full h-64 object-cover rounded-t-lg">
                    <?php endif; ?>
                    <p class="mt-4">
                        <span class="inline-block px-3 py-1 rounded-full <?php echo $statusClass; ?>">
                            Status: <?php echo ucfirst($status); ?>
                        </span>
                    </p>
                    <?php if (!empty($r['tags'])): ?>
                        <div class="mt-4">
                            <span class="font-semibold text-gray-800">Tags:</span>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($r['tags']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Actions (Like, Comment, Share) -->
                <div class="border-t flex justify-around p-4 text-gray-600 bg-gray-50">
                    <button class="like-btn flex items-center hover:text-blue-600">
                        <i class="fa-solid fa-thumbs-up mr-2"></i> Like
                    </button>

                    <button onclick="toggleCommentInput(<?php echo $r['idArticle']; ?>)" class="btncomment flex items-center hover:text-blue-600">
                        <i class="fa-solid fa-comment mr-2"></i> Comment
                    </button>
                    <button class="flex items-center hover:text-blue-600">
                        <i class="fa-solid fa-share mr-2"></i> Share
                    </button>
                </div>
            </div>
        <?php 
            endif; 
        endforeach; 
        ?>

        <!-- If no accepted articles -->
        <?php if (!$hasAcceptedArticles): ?>
            <p class="text-gray-600 text-lg mt-8 text-center">No accepted blogs available at the moment.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <p class="text-gray-600 text-lg mt-8 text-center">No blogs available at the moment.</p>
<?php endif; ?>


<script>
    //for comments
    function toggleCommentInput(articleId) {
        var commentSection = document.getElementById('commentSection' + articleId);
        commentSection.classList.toggle('hidden');
    }
    function submitComment(event, articleId) {
        event.preventDefault(); 
        var commentInput = document.getElementById('commentInput' + articleId);
        var commentContent = commentInput.value.trim();
        if (commentContent !== '') {
            console.log('Comment submitted: ' + commentContent);
            document.getElementById('commentSection' + articleId).submit();
            commentInput.value = ''; 
            toggleCommentInput(articleId);
        } else {
            alert('Comment cannot be empty.');
        }
    }
</script>


    <!-- pour 3Point pou delete and edit -->
    <script>
    document.querySelectorAll('.optionsMenu').forEach((button, index) => {
        button.addEventListener('click', (event) => {
            document.querySelectorAll('.dropdownMenu').forEach((menu) => {
                menu.classList.add('hidden');
            });
            const dropdown = button.nextElementSibling;
            dropdown.classList.toggle('hidden');
            event.stopPropagation();
        });
    });
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdownMenu').forEach((menu) => {
            menu.classList.add('hidden');
        });
    });

</script>
    <script>
        //pour like
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function () {
                this.classList.toggle('liked');
            });
        });
 
        // pour les tag
        const tagInput = document.getElementById('tag-input');
        const tagsContainer = document.getElementById('tags-container');
        const tagsHidden = document.getElementById('tags-hidden');
        let tags = [];

        tagInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ',') {
                event.preventDefault();
                const tag = tagInput.value.trim();
                if (tag && !tags.includes(tag)) {
                    tags.push(tag);
                    updateTags();
                }
                tagInput.value = '';
            }
        });

        function updateTags() {
            tagsContainer.innerHTML = '';
            tags.forEach(tag => {
                const tagElement = document.createElement('div');
                tagElement.className = 'tag';
                tagElement.innerHTML = `${tag} <span onclick="removeTag('${tag}')">&times;</span>`;
                tagsContainer.appendChild(tagElement);
            });
            tagsContainer.appendChild(tagInput);
            tagsHidden.value = tags.join(',');
        }

        function removeTag(tag) {
            tags = tags.filter(t => t !== tag);
            updateTags();
        }
        // end tag


        //pour model edit
        // document.querySelectorAll('.edit-button').forEach(button => {
        //     button.addEventListener('click', () => {
        //         const reservationId = button.getAttribute('data-reservation-id');
        //         document.getElementById(`editReservationForm-${reservationId}`).classList.remove('hidden');
        //     });
        // });

        // document.querySelectorAll('.close-button').forEach(button => {
        //     button.addEventListener('click', () => {
        //         const reservationId = button.getAttribute('data-reservation-id');
        //         document.getElementById(`editReservationForm-${reservationId}`).classList.add('hidden');
        //     });
        // });

        

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
            const reservationsPage = document.getElementById('ArticlesPage');

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
    </script>
    <script>
        //pour model de add article
        const buttonAddArticle = document.getElementById('addarticle');
        const formAddArticle = document.getElementById('addArticleModal');
        const closeModalButton = document.getElementById('closeModal');
        buttonAddArticle.addEventListener('click', function () {
            formAddArticle.classList.remove('hidden');
        });
        closeModalButton.addEventListener('click', function () {
            formAddArticle.classList.add('hidden');
        });
    </script>
</body>

</html>
<?php
require_once '../../autoload.php';
require_once '../classes/Comment.php';
require_once '../classes/Favorites.php';
require './Add_favoris.php';

session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['id_role'] !== 2) {
    header("Location: ../../Visiteur/login.php");
    exit;
}

try {
    $comments = Comment::getAllComments();
    if (!$comments || count($comments) === 0) {
        echo "<p class='text-red-600'>Aucun commentaire trouvé.</p>";
        exit();
    }
} catch (\PDOException $e) {
    echo "<p class='text-red-600'>Erreur lors de la récupération des commentaires : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-4 px-4">
        <div class="flex items-center justify-between mb-8">
            <a href="./index.php" class="text-blue-500 hover:underline flex items-center">
                <i class="fas fa-home text-blue-500 text-lg mr-2"></i> Accueil
            </a>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Commentaires de <?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <?php foreach ($comments as $comment): ?>
                <div class="mb-4 border-b pb-4">
                    <h3 class="text-xl font-semibold text-gray-700"><?php echo htmlspecialchars($comment['article_title']); ?></h3>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($comment['comment_content']); ?></p>
                    <p class="text-sm text-gray-500">Par <?php echo htmlspecialchars($comment['user_name']); ?> le <?php echo htmlspecialchars($comment['comment_date']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    
<script>
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

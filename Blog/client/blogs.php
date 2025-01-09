<?php
 if (isset($_SESSION['id_user'])): ?>
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
        $hasAcceptedArticles = true; 
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
<?php if (!$hasAcceptedArticles): ?>
    <p class="text-gray-600 text-lg mt-8 text-center">No accepted blogs available at the moment.</p>
<?php endif; ?>
</div>
<?php else: ?>
<p class="text-gray-600 text-lg mt-8 text-center">No blogs available at the moment.</p>
<?php endif; ?>


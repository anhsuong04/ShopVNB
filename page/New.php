<?php
$apiKey = 'YOUR_REAL_API_KEY'; // Thay bằng API key thật
$apiUrl = "https://newsapi.org/v2/top-headlines?country=us&apiKey=$apiKey";

$response = file_get_contents($apiUrl);
if ($response === FALSE) {
    echo "Không thể kết nối API!";
    exit;
}

$data = json_decode($response, true);


if (!empty($data['articles'])) {
    foreach ($data['articles'] as $article) {
        echo '<div class="news-item">';
        echo '<h5><a href="'.$article['url'].'" target="_blank">'.$article['title'].'</a></h5>';
        echo '<p>'.$article['description'].'</p>';
        if (!empty($article['urlToImage'])) {
            echo '<img src="'.$article['urlToImage'].'" width="200">';
        }
        echo '<hr>';
        echo '</div>';
    }
} else {
    echo 'Không có tin tức.';
}
?>

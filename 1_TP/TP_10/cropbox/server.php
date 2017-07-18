<?php

if (isset($_GET['rq']) && $_GET['rq'] === 'saveimage') {
    $img = $_POST['img'];
    $strippedImageContent = str_replace('data:image/png;base64,', '', $img);
    $strippedImageContent = str_replace(' ', '+', $strippedImageContent);

    $data = base64_decode($strippedImageContent);
    $imgName = 'img/logo.jpg';
    file_put_contents($imgName, $data);
}
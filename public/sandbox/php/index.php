<?php
declare(strict_types=1);

$twig = require_once __DIR__ . '/../../../config/bootstrap.php';

function getHeadline(string $headlineText): string 
{
    return $headlineText;
}

$carouselBlurbs = [
    'First ipsum dolor sit amet, consectetur adipisicing elit',
    'Second ipsum dolor sit amet, consectetur adipisicing',
    'Third ipsum dolor sit amet, consectetur'
];

echo $twig->render('sandbox/php/index.twig', [
    'headline' => getHeadline("This is only a test"),
    'carousel_blurbs' => $carouselBlurbs
]);
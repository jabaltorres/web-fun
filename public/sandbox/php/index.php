<?php
declare(strict_types=1);

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../../config/bootstrap.php');

const HEADLINE_TEXT = "This Not a test";

function getHeadline(): string 
{
    return HEADLINE_TEXT;
}

$carouselBlurbs = [
    'First ipsum dolor sit amet, consectetur adipisicing elit',
    'Second ipsum dolor sit amet, consectetur adipisicing',
    'Third ipsum dolor sit amet, consectetur'
];

// Get Twig instance from app container
$twig = $app['twig'];

echo $twig->render('sandbox/php/index.twig', [
    'headline' => getHeadline(),
    'carousel_blurbs' => $carouselBlurbs
]);
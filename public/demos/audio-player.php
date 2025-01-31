<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\AudioElement;
use Fivetwofive\KrateCMS\LoremElement;

$title = "Demo Index";
// this is for <title>

$page_heading = 'Demo Page Heading';
$page_subheading = "List of WIP demos";

$custom_class = "demo-page";
//custom CSS for this page only

include('../../templates/layout/header.php');
?>

<?php

// Page Header
$page_audio_header = new LoremElement("h1");
$page_audio_header->setAttribute("id", "page-heading");
$page_audio_header->setAttribute("class", "h4 mb-2");
$page_audio_header->setContent("Audio Page");

// Page Sub Header
$page_audio_subheader = new LoremElement("h3");
$page_audio_subheader->setAttribute("id", "page-subheading");
$page_audio_subheader->setAttribute("class", "h5 mb-0");
$page_audio_subheader->setContent("Testing out building and using an audio player");

?>

    <div class="container py-5 <?php echo $custom_class; ?>">

        <section class="lorem-header mb-4">
            <?php
            echo $page_audio_header->render();
            echo $page_audio_subheader->render();
            ?>
        </section>

        <section class="lorem-audio-player">
            <?php
            try {
                $audio_element = new AudioElement(
                    "Eh Mambo by Jabal Torres", 
                    "https://jabaltorres.com/wp-content/uploads/2024/06/EH-MAMBO.mp3", 
                    "audio/mpeg"
                );
                $audio_element->setAutoplay(false)
                             ->setLoop(false);

                echo $audio_element->render();
            } catch (\InvalidArgumentException $e) {
                echo '<div class="alert alert-danger">Error loading audio: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
            ?>
        </section>

    </div><!-- end .container -->

<?php include('../../templates/layout/footer.php'); ?>
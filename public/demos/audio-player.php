<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

$title = "Demo Index";
// this is for <title>

$page_heading = 'Demo Page Heading';
$page_subheading = "List of WIP demos";

$custom_class = "demo-page";
//custom CSS for this page only

include_once(SHARED_PATH . '/site-header.php');
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

    <div class="container <?php echo $custom_class; ?>">

        <?php
        include_once(SHARED_PATH . '/navigation.php');
        ?>


        <section class="lorem-header">
            <?php
            echo $page_audio_header->render();
            echo $page_audio_subheader->render();
            ?>
        </section>

        <section class="lorem-audio-player">
            <?php
            $audio_element = new AudioElement("There's Only One Life", "https://jabaltorres.com/wp-content/uploads/2023/06/THERES-ONLY-ONE-LIFE.mp3", "audio/mp3");
            $audio_element->setAutoplay(false);
            $audio_element->setLoop(false);

            echo $audio_element->render();
            ?>
        </section>

    </div><!-- end .container -->

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>
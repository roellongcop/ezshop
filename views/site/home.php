<?php

$this->title = 'Home';
?>
<!-- Carousel Start -->
<?= $this->render('home/carousel') ?>
<!-- Carousel End -->


<!-- Featured Start -->
<?= $this->render('home/shop-features') ?>

<!-- Featured End -->


<!-- Categories Start -->
<?= $this->render('home/categories') ?>

<!-- Categories End -->


<!-- Products Start -->
<?= $this->render('home/featured-products') ?>
<!-- Products End -->


<!-- Offer Start -->
<?= $this->render('home/offers') ?>
<!-- Offer End -->


<!-- Products Start -->
<?= $this->render('home/recent-products') ?>
<!-- Products End -->


<!-- Vendor Start -->
<?php # $this->render('home/vendor') ?>
<!-- Vendor End -->

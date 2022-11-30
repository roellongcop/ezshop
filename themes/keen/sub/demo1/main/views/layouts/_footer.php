<?php

use app\helpers\App;
use app\helpers\Url;
?>
<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2"><?= date('Y') ?>©</span>
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary">
                <?= App::appName() ?>
            </a>
        </div>
        <!--end::Copyright-->
        <!--begin::Nav-->
        <div class="nav nav-dark">
            <a href="<?= Url::toRoute(['site/about']) ?>" target="_blank" class="nav-link pl-0 pr-2">
                About
            </a>
            <a href="<?= Url::toRoute(['site/contact']) ?>" target="_blank" class="nav-link pr-0">Contact</a>
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
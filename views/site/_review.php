<div class="media mb-4">
    <img src="<?= $review->userImageUrl ?>" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
    <div class="media-body">
        <h6><?= $review->publisherName ?><small> - <i><?= date('j M, Y', strtotime($review->created_at)) ?></i></small></h6>
        <div class="text-primary mb-2">
            <?= $review->generateStar() ?>
        </div>
        <p>
            <?= $review->review ?>
        </p>
    </div>
</div>
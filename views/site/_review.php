<div class="media mb-4">
    <img src="<?= $review->userImageUrl ?>" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
    <div class="media-body">
        <h6><?= $review->email ?><small> - <i><?= date('j M, Y', strtotime($review->created_at)) ?></i></small></h6>
        <div class="text-primary mb-2">
            <?php for ($i = $review->score; $i > 0; $i--): ?>
                <i class="fas fa-star"></i>
            <?php endfor ?>
            <?php for ($i = 5 - $review->score; $i > 0; $i--): ?>
                <i class="far fa-star"></i>
            <?php endfor ?>
        </div>
        <p>
            <?= $review->review ?>
        </p>
    </div>
</div>
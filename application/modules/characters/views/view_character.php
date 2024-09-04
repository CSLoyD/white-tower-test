<div class="container text-center">
    
    <h1 class="mb-4">View Character Page</h1>

    <a href="<?= base_url('characters') ?>" class="back-link"><img src="<?= base_url('assets/build/images/left-arrow.png') ?>" class="arrow-left" alt="<"> Back to Listing Page</a>

    <div class="text-start mb-4">
        <h2><?= ucwords($character['name']) ?></h2>
        <p><strong>Height: <?= $character['height'] ?></strong></p>
        <p><strong>Hair Colour: <?= $character['hair_color'] ?></strong></p>
        <p><strong>Gender: <?= ucwords($character['gender']) ?></strong></p>
    </div>

    <div class="btn-group d-block">
        <?php if($is_saved): ?>
            <button type="button" data-saveid="<?= $is_saved->id; ?>" class="btn btn-danger btn-delete-character">Delete Character</button>
        <?php else: ?>
            <button type="button" data-charid="<?= $character_id; ?>" class="btn btn-primary btn-save-character">Save Character</button>
        <?php endif; ?>
    </div>
</div>
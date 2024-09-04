<!-- Saved Characters Section -->
<div class="saved-characters mt-5">
    <h2 class="text-center">Character Listing Page</h2>
    <h4 class="text-left mt-4 mb-4">Characters</h4>
    <?php if (isset($_SESSION['update_flash'])): ?>
        <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['update_flash']; ?></div>
    <?php endif; ?>
    <div class="row mt-4 character-cards"></div>
    <div id="loader" class="loader">
        <p>Fetching Data...</p>
        <img src="<?= base_url() ?>assets/build/images/loading.png" class="loader-img">
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center"></ul>
    </nav>
</div>
</div>        
        <input type="hidden" name="base_url" value="<?php echo base_url()?>">
        <input type="hidden" name="basemethod" value="<?php echo $this->router->fetch_method(); ?>">
        <script src="<?= base_url()?>assets/build/js/jquery.min.js"></script>
        <script src="<?= base_url()?>assets/build/js/jquery-ui.min.js"></script>
        <script src="<?= base_url();?>assets/build/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url();?>assets/build/js/sweetalert2.min.js"></script>
        <script src="<?= base_url();?>assets/build/js/sweetalert2.all.min.js"></script>
        <?php
            __load_assets__($__assets__,'js');
        ?>
        
    </body>
</html>

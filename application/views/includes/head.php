<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title." | Technical Test"; ?></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/build/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/build/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/build/jqueryui/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/build/css/custom.min.css?"<?= ASSETVERSION ?>>
        <link rel="icon" type="image/x-png" href="<?= base_url() ?>assets/build/images/browser.png">
        <?php
            __load_assets__($__assets__,'css');
            $method = $this->router->fetch_method();
        ?>
    </head>

<body>
<div class="container mt-5">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0);">
                <img src="https://via.placeholder.com/250x80" alt="Logo" class="logo">
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(!isset($_SESSION['is_logged'])): ?>
                        <?php if($method == 'registration'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('login')  ?>">Login</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('sign-up')  ?>">Sign Up</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('characters')  ?>">List Characters</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('user/characters')  ?>">Saved Characters</a>
                    </li>
                    <?php if(isset($_SESSION['is_logged'])): ?>
                    <li>
                        <a class="nav-link" href="<?= base_url('logout')  ?>">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
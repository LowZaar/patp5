<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="index.html">
                    <img src="images/icon/logo.png" alt="CoolAdmin" />
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li class="active has-sub">
                    <a href="<?= HOME_URI ?>">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-users"></i>Contas
                        </a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list" style="display: block;">
                            <li>
                                <a href="<?= HOME_URI ?>/contas/">Visualizar</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= HOME_URI ?>/financeiro/">
                            <i class="fas fa-usd"></i>Financeiro
                        </a>
                    </li>
                    <li>
                        <a href="<?= HOME_URI ?>/usuarios/">
                            <i class="fas fa-users"></i>Usuários
                        </a>
                    </li>
            </ul>
        </div>
    </nav>
</header>

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="<?= HOME_URI ?>">
            
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="active has-sub">
                    <a href="<?= HOME_URI ?>">
                        <i class="fa fa-home"></i>Dashboard
                    </a>
                </li>
            
                    <li class="has-sub">
                        <a class="js-arrow open" href="#">
                            <i class="fa fa-users"></i>Contas
                        </a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="<?= HOME_URI ?>/contas/">Contas</a>
                            </li>
                            <li>
                                <a href="<?= HOME_URI ?>/implantacao/">Contas implantadas</a>
                            </li>
                            <li>
                                <a href="<?= HOME_URI ?>/implantacao/envia-email">Envia e-mail</a>
                            </li>
                        </ul>
                    </li>
               
                    <li>
                        <a href="<?= HOME_URI ?>/financeiro/">
                            <i class="fa fa-usd"></i>Financeiro
                        </a>
                    </li>

                    <li>
                        <a href="<?= HOME_URI ?>/usuarios/">
                            <i class="fa fa-users"></i>Usuários
                        </a>
                    </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <?php if (isset($this->modal_notification) && !empty($this->modal_notification)) { ?>
                        <div class="sufee-alert alert with-close alert-<?= $this->modal_notification[1] ?> alert-dismissible fade show">
                            <?= $this->modal_notification[0] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    <?php } ?>
                    <form class="form-header" action="" method="POST">
                        <!-- <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button> -->
                    </form>
                    <div class="header-button">
                        <div class="account-wrap">
                            <div class="account-item clearfix js-item-menu">
                                <div class="image">
                                    <img src="<?= HOME_URI ?>/views/_images/logo.png" alt="" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#"> Roberto o +++ brabo <i class="fa fa-angle-down"></i></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="<?= HOME_URI ?>/views/_images/logo.png" alt="" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#"><?= $this->userdata['nome'] ?></a>
                                            </h5>
                                            <span class="email"><?= $this->userdata['email'] ?></span>
                                        </div>
                                    </div>
                                    <!-- <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-settings"></i>Setting</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-money-box"></i>Billing</a>
                                        </div>
                                    </div> -->
                                    <div class="account-dropdown__footer">
                                        <a href="<?= HOME_URI.'/login/sair' ?>">
                                            <i class="zmdi zmdi-power"></i>Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER DESKTOP-->
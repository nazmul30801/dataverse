<nav id="main_menu" class="navbar navbar-expand-lg bg-light border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/img/text-logo.png" alt="Bootstrap" height="24" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/identity/insert.php">Profile +</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/identity/">Identity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/caller_id/">Caller ID</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/shekor/">Shekor</a>
                </li>
            </ul>
            <?php echo search_engine(); ?>
        </div>
    </div>
</nav>
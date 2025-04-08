<?php include dirname(__DIR__) . '/Base/header.php'; ?>
<?php include dirname(__DIR__) . '/Base/nav.php'; ?>
    <main>
        <section>
            <header>
                <h2>Page not found</h2>
            </header>
            <p>Unfortunately, the page was not found</p>
            <?=$errorInfo ?? '' ?>
        </section>
    </main>
<?php include dirname(__DIR__) . '/Base/footer.php'; ?>
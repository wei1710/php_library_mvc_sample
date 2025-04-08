<?php include dirname(__DIR__) . '/Base/header.php'; ?>
<?php include dirname(__DIR__) . '/Base/nav.php'; ?>
    <main>
        <section>
            <header>
                <h2>An error occurred</h2>
            </header>
            <p>Unfortunately, an error occurred in the application</p>
            <?=$errorInfo ?? '' ?>
        </section>
    </main>
<?php include dirname(__DIR__) . '/Base/footer.php'; ?>
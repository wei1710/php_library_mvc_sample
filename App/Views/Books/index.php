<?php include dirname(__DIR__) . '/Base/header.php'; ?>
<?php include dirname(__DIR__) . '/Base/nav.php'; ?>
    <main>
        <section>
            <header>
                <h2>Book list</h2>
            </header>
        </section>
        <?php foreach ($books as $book): ?>
            <article class="card">
                <header>
                    <h3><?=htmlspecialchars($book['title']); ?></h3>
                    <h4><?=htmlspecialchars($book['author_first_name'] . 
                        ' ' . $book['author_last_name']); ?></h4>
                </header>
                <p><?=htmlspecialchars($book['publisher'] . 
                    ', ' . $book['publishing_year']) ?></p>
            </article>
        <?php endforeach; ?>
    </main>
<?php include dirname(__DIR__) . '/Base/footer.php'; ?>
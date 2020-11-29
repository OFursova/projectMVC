<h1 class="text-center my-3"><?= $title ?></h1>

<?php foreach ($articles as $article): ?>
<h2><?= $article['name'] ?></h2>
<p><?= $article['content'] ?></p>
<?php endforeach ?>
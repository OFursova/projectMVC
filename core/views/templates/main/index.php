<h1 class="text-center my-3"><?= $title ?></h1>

<?php foreach ($articles as $article): ?>
<h2><a href="/acticle/<?= $article->id ?>"><?= $article->name ?></a></h2>
<p><?= $article->text ?></p>
<?php endforeach ?>
<section class="container">
<h1 class="text-center my-3"><?= $title ?></h1>

<a href="/pdf-article" class="btn btn-primary my-2">Save articles in pdf</a>

<a href="/excel-article" class="btn btn-primary my-2">Save articles in xls</a>

<?php foreach ($articles as $article): ?>
<h2><a href="/article/<?= $article->id ?>"><?= $article->name ?></a></h2>
<p><?= $article->text ?></p>
<a href="/edit" class="btn btn-warning my-1">Edit</a>
<?php endforeach ?>
</section>
<section class="container">
<h1 class="text-center my-3"><?= $title ?></h1>
<div class="row">
<a href="/article/add-form" class="btn btn-success m-2">Add article</a>
</div>
<div class="row">
<a href="/pdf-article" class="btn btn-primary m-2">Save articles in pdf</a>
<a href="/excel-article" class="btn btn-primary m-2">Save articles in xls</a>
</div>
<?php foreach ($articles as $article): ?>
<h2><a href="/article/<?= $article->id ?>"><?= $article->name ?></a></h2>
<p><?= $article->text ?></p>
<a href="/article/<?= $article->id ?>/edit-form" class="btn btn-warning my-1">Edit</a>
<a href="/article/<?= $article->id ?>/delete" class="btn btn-danger my-1">Delete</a>
<?php endforeach ?>
</section>
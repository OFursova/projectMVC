<div class="container">
<h1>Adding Article</h1>
<div class="row justify-content-center">
<div class="col-6">
<form action="/article/add" method="post">
<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" class="form-control">
</div>
<div class="form-group">
        <label for="text">Text:</label>
        <textarea type="text" id="text" name="text" class="form-control"></textarea>
</div>
<div class="form-group">
    <label for="user_id">Author id:</label>
    <input type="number" id="user_id" name="user_id" class="form-control">
</div>
<button class="btn btn-primary">Save</button>
</form>
</div>
</div>
</div>
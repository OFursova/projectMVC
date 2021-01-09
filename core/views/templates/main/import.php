<div class="container">
<h1>Import products data</h1>
<div class="row justify-content-center">
<div class="col-6">
<?= $message ?>
<form action="/import-data" method="post" enctype="multipart/form-data" id="import_excel_form">
<div class="form-group">
    <input type="file" name="import_excel" id="import_excel">
</div>
<button class="btn btn-primary" id="import">Save</button>
</form>
</div>
</div>
</div>
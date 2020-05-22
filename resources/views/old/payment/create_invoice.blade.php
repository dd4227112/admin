@extends('layouts.app')
@section('content')
<div class="white-box">
    <div class="row">
        <div class="col-lg-8">
            <form method="post">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Schema Name:</label>
                    <select class="form-control" name="schema">
                        <?php foreach ($schemas as $schema) { ?>
                            <option value="<?= $schema->table_schema ?>"><?= $schema->table_schema ?></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Number of Invoices:</label>
                    <input type="number" name="limit" class="form-control" id="recipient-name1"> </div>
                <div class="form-group">
                    <label for="message-text" class="control-label"></label>
                    <input type="submit" name="submit" class="btn btn-info"/>
                </div>
                <?= csrf_field() ?>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
@endsection

<h2><?php echo $title; ?></h2>

<?php
    if (validation_errors()) {
?>
<div class="notification is-danger">
    <?php echo validation_errors(); ?>
</div>
<?php
    }
?>

<?php echo form_open('news/create'); ?>

<div class="field">
    <label for="title">Title</label>
    <div class="control">
        <input type="input" name="title" /><br />
    </div>
</div>

<div class="field">
    <label for="text">Text</label>
    <div class="control">
        <textarea name="text"></textarea><br />
    </div>
</div>

<div class="control">
    <div class="control">
        <button class="button is-link">Create news item</button>
    </div>
</div>

</form>
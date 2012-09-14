<h2>Create a news item</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('news/create') ?>

	<label for="title">Title</label> 
	<input type="input" name="title" value="<?php echo set_value('title'); ?>"  /><br />

	<label for="text">Text</label>
	<textarea name="text"><?php echo set_value('text'); ?></textarea><br />

	<label for="email">Email</label>
	<input type="text" name="email" value="<?php echo set_value('email'); ?>">
	
	<input type="submit" name="submit" value="Create news item" /> 

</form>
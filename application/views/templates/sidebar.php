<aside id="datesSidebar">
	<section>
        <?php $attributes = array('id' => 'dateForm'); ?>
	    <?php echo form_open('processDateForm',$attributes) ?>
	    	<fieldset>
	        	<legend>Search For a Date</legend>
	    		<input type="text" name="date" id="date">
	    		<input type="submit" name="dateSubmit" value="Find Date">
	    	</fieldset>
	    </form>
    </section>
    <section>
    	<h4><a href="<?php echo site_url('all'); ?>">View Entire Archive</a></h4>
    </section>
	<section>
	   <h4>Archived Dates</h4>
		<ul>
	    	<?php foreach ($dates as $date): ?>
				<li><a href="<?php echo site_url() . date('Y-m-d', strtotime($date['dateAdded'])); ?>"><?php echo date('M d, Y', strtotime($date['dateAdded'])); ?></a></li>
	        <?php endforeach ?>
		</ul>
    </section>
</aside>
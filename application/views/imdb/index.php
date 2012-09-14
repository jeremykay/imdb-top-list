<div id="mainContent">	

	<?php foreach ($imdb as $date): ?>

		<h2><a href="<?php echo site_url() . date('Y-m-d', strtotime($date[0]['dateAdded'])); ?>"><?php echo date('M d, Y', strtotime($date[0]['dateAdded'])); ?></a></h2>
        
		<table class="dates">
		<tr>
			<th>Rank</th>
			<th></th>
			<th></th>
			<th>Rating/<br>Votes</th>
		</tr>

		<?php foreach ($date as $imdb_item): ?>

		  <tr>
		  	<td><?php echo $imdb_item['rank'] ?>.</td>
		  	<td><a href="<?php echo $imdb_item['link'] ?>"><img src="<?php echo base_url() . 'img_uploads/' . $imdb_item['image'] ?>" alt="<?php echo $imdb_item['title'] ?>" height="100" width="80"></a></td>
		  	<td>
		  		<h3 class="title"><a href="<?php echo $imdb_item['link'] ?>"><?php echo $imdb_item['title'] ?></a></h3>
		  		<p class="outline"><?php echo $imdb_item['outline'] ?></p>
		  	</td>
		  	<td>
		  		<div class="rating"><?php echo $imdb_item['rating'] ?></div>
		  		<div class="number_of_votes"><?php echo number_format($imdb_item['number_of_votes']) ?></div>
		  	</td>
		  </tr>

	  	<?php endforeach ?>

	  	</table>

	<?php endforeach ?>
    
</div>

      
        <!-- <a href="/index.php/date/<?php echo date('Y-m-d', strtotime($imdb_item['dateAdded'])); ?>"><?php echo date('Y-m-d', strtotime($imdb_item['dateAdded'])); ?></a> -->

    <!-- <h2>IMDB Top 10 For <?php echo date('M d, Y', strtotime($imdb_item['dateAdded'])); ?></h2> -->

  	<?php //echo print_r($imdb); ?>

<?php foreach ($imdb as $date): ?>

	<h2><a href="/index.php/date/<?php echo date('Y-m-d', strtotime($date[0]['dateAdded'])); ?>"><?php echo date('M d, Y', strtotime($date[0]['dateAdded'])); ?></a></h2>
	<table>
	<tr>
		<td>Rank</td>
		<td></td>
		<td></td>
		<td>Rating</td>
	</tr>


	<?php foreach ($date as $imdb_item): ?>

	  <tr>
	  	<td><?php echo $imdb_item['rank'] ?></td>
	  	<td><img src="<?php echo $imdb_item['image'] ?>" alt="<?php echo $imdb_item['title'] ?>" height="100" width="80"></td>
	  	<td>
	  		<h3 class="title"><?php echo $imdb_item['title'] ?></h3>
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

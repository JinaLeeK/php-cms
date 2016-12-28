<div id="head-photo-slides" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php get_carousel_in_front_page(); ?>
	</ol>

	<div class="carousel-inner" role="listbox">
		<?php get_slides_in_front_page(); ?>
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#head-photo-slides" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#head-photo-slides" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>

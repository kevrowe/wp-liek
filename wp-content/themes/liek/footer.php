		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		<!-- Foundation 3 for IE 8 and earlier -->
		<!--[if lt IE 9]>
	    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/foundation/foundation3/foundation.min.js"></script>
	    <![endif]-->
	    <!-- Foundation 4 for IE 9 and later -->
	    <!--[if gt IE 8]><!-->
	    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/foundation/foundation.min.js"></script>
	    <script>
	    $(document).foundation();
	    </script>
	    <!--<![endif]-->

	    <?php wp_footer(); ?>
	</div>
</body>
</html>
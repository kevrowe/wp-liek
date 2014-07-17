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
	    <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-39834381-2', 'aqua-proof.me');
		  ga('send', 'pageview');
		</script>


	    <?php wp_footer(); ?>
	</div>
</body>
</html>
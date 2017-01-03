<!-- bootstrap JavaScript -->
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<div class="copy_site" style="top:220px;background-color:#FFF;">&copy; <?php echo date('Y');?></div>
<script>
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});

$(document).ready( function() {
    $('#myCarousel').carousel({
        interval:   4000
	});
	
	var clickEvent = false;
	$('#myCarousel').on('click', '.nav a', function() {
			clickEvent = true;
			$('.nav li').removeClass('active');
			$(this).parent().addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.nav').children().length -1;
			var current = $('.nav li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.nav li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});
});
$(document).ready(function() {
    $('#list').click(function(){event.preventDefault();$('#products .item').addClass('list-group-item');});
    $('#grid').click(function(){event.preventDefault();$('#products .item').removeClass('list-group-item');});
});
</script>
</body>
</html>
@if (session('error') || count($errors))
  
	@if (session('error'))

	  <script>

			$(document).ready(function() {
			  //show message if any
  
			  $.toast().reset('all');
				  $("body").removeAttr('class');
				  $.toast({
					  heading: 'An Error Occured',
					  text: "{!! session('error') !!}",
					  position: 'bottom-right',
					  loaderBg:'#fec107',
					  icon: 'error',
					  hideAfter: 15500, 
					  stack: 6
				  });
				  return false;
  
		  });
  
	  </script>

	@else
	  
		<?php
		
			$error_msg = "";
			foreach ($errors->all() as $error) {
				$error_msg .= "<li>{!! $error !!}</li>";
			}		

		?>
	       

	  	<script>

			$(document).ready(function() {
			  //show message if any
  
			  $.toast().reset('all');
				  $("body").removeAttr('class');
				  $.toast({
					  heading: 'An Error Occured',
					  text: "<?=$error_msg?>",
					  position: 'bottom-right',
					  loaderBg:'#fec107',
					  icon: 'error',
					  hideAfter: 15500, 
					  stack: 6
				  });
				  return false;
  
		  	});
  
	  	</script>

	@endif

@endif


@if (session('success'))

	<script>

	  	$(document).ready(function() {
			//show message if any

			$.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
					heading: 'Success',
					text: "{!! session('success') !!}",
					position: 'bottom-right',
					loaderBg:'#fec107',
					icon: 'error',
					hideAfter: 15500, 
					stack: 6
				});
				return false;

		});

	</script>

@endif
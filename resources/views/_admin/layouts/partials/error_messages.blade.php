
@if (session('success'))

	<script>

		$(document).ready(function() {
		    //show message if any

		    $.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
		            heading: 'Success',
		            text: {!! json_encode(session('success')) !!},
		            position: 'bottom-right',
		            loaderBg:'#fec107',
		            icon: 'success',
		            hideAfter: 15500,
		            stack: 6
		        });
                return false;

		});

	</script>

@endif


@if (session('error'))

	<script>

		$(document).ready(function() {
		    //show message if any

			$.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
		            heading: 'An Error Occured',
		            text: {!! json_encode(session('error')) !!},
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

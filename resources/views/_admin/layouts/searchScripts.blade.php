<script type="text/javascript">

      if ($('#start_date_group').length) {

	      /* Start Datetimepicker Init*/
	      $('#start_date_group').datetimepicker({
	          useCurrent: false,
	          format: 'DD-MM-YYYY',
	          icons: {
	                        time: "fa fa-clock-o",
	                        date: "fa fa-calendar",
	                        up: "fa fa-arrow-up",
	                        down: "fa fa-arrow-down"
	                    },
	        }).on('dp.show', function() {
	        if($(this).data("DateTimePicker").date() === null)
	          $(this).data("DateTimePicker").date(moment());
	      });

	  }

      if ($('#end_date_group').length) {

	      /* End Datetimepicker Init*/
	      $('#end_date_group').datetimepicker({
	          useCurrent: false,
	          format: 'DD-MM-YYYY',
	          icons: {
	                        time: "fa fa-clock-o",
	                        date: "fa fa-calendar",
	                        up: "fa fa-arrow-up",
	                        down: "fa fa-arrow-down"
	                    },
	        }).on('dp.show', function() {
	        if($(this).data("DateTimePicker").date() === null)
	          $(this).data("DateTimePicker").date(moment());
	      });

	  }

      if ($('#dob_date_group').length) {

	      /* End Datetimepicker Init*/
	      $('#dob_date_group').datetimepicker({
	          useCurrent: false,
	          format: 'DD-MM-YYYY',
	          icons: {
	                        time: "fa fa-clock-o",
	                        date: "fa fa-calendar",
	                        up: "fa fa-arrow-up",
	                        down: "fa fa-arrow-down"
	                    },
	        }).on('dp.show', function() {
	        if($(this).data("DateTimePicker").date() === null)
	          $(this).data("DateTimePicker").date(moment());
	      });

	  }

      if ($('#clear_date').length) {

	      //clear date
	      $("#clear_date").click(function(e){
	          e.preventDefault();
	          $('#start_date').val("");
	          $('#end_date').val("");
	      });

	  }


</script>

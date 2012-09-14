$(document).ready(function(e) {

    $('#dateForm #date').datepicker({
		onClose: function() {$(this).valid();}	
	});

   	$('#dateForm').validate({
	  rules: {
	    date: {
	      required: true,
	      date: true,
	    }
	  },
	  messages: {
	  	date: '* Please enter a date'
	  }
	});

});
$(function() {
	var $el = $('#main-container');
	var mobilePhone = /^0[67]\d{8}$/;
	var templateSMS = _.template($('#template-sms').html());
	var $form = $('#form-sms');
	var timeOut;
	
	// refresh pending sms every 5sec
	function refreshPendingSMS() {
		clearTimeout(timeOut);
		
		var $pendingTable = $('#pending-table');
		
		$pendingTable.html('');
		
		$.ajax({
			type: 'GET',
			url: '/sms/pendingsms.php',
			dataType: 'json',
			success: function(data) {
				$(data).each(function(i, l) {
					$pendingTable.append($(templateSMS(l)));
				});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// fail silently...
			}
		});
		
		timeOut = setTimeout(refreshPendingSMS, 5000);
	}
	
	// handle form request
	$form.find('button').click(function(e) {
		var $phoneNo = $('#phone-number'),
			$sms = $('#phone-body');
			
		if(mobilePhone.test($phoneNo.val())) {
			if($sms.val().length > 0) {
			$.ajax({
				type: 'POST',
				url: '/sms/sendsms.php',
				data: {
					phoneNo: $phoneNo.val(),
					sms: $sms.val(),
				},
				success: function(data) {
					alert('sms succesfully sent! This may take few sec...');
					refreshPendingSMS();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('There is something wrong... try later...');
				}
			});
			} else {
				alert('Please enter a text message!');
				$sms.focus();		
			}
		} else {
			alert('Please enter a correct phone number strating with 06 or 07!');
			$phoneNo.val('').focus();
		}
		
		e.preventDefault();
	})
	
	// refresh pending sms the first time
	refreshPendingSMS();
});
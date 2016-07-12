<!DOCTYPE html>
<html>
<head>
	<title>Testing of adding table to row with JQUERY</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<form>
		<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
		<table border="1" id="itemsTable">
			<thead>
				<tr>
					<th>
						Payment Type
					</th>
					<th>
						Amount
					</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td>Somerset</td>
					<td>100</td>
				</tr>
				<tr>
					<td>Association Dues</td>
					<td>500</td>
				</tr>
			</tbody>
		</table>
	</form>

	<button id="addRow" > Add Row </button>
	

	<script type="text/javascript">
		$(document).ready(function(){
		//     $("#addRow").click(function(){
		    	
		//         $('#itemsTable tr:last').after( '<tr>' +
		//         	'<td><input type="text" name="paymentName" value="Swimming Pool Fee" readonly></td>' +
		//         	'<td><input type="number" name="paymentCost" value="200" readonly></td>' +
		//         	'</tr>');
		//     });
			$("#addRow").click(function(e){	
				e.preventDefault();
				var data='';
				var tData = '';
				var table = $('#itemsTable tbody');
				table.find('tr').each(function(rowIndex, r){
					tData = '';
					//var cols = [];
					//console.log('Enter 1st loop');
					$(this).find('td').each(function (colIndex, c) {
						//console.log('Enter 2nd loop' + c.textContent);
						tData+=(c.textContent+',');
						//alert();
			            //cols.push(c.textContent);
			        });
			        data+= (tData.substring(0,tData.length - 1) + '/');
			        //data.push(cols);
				});
				data = data.substring(0,data.length - 1);

				$.ajax({
					headers: {
					    'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
					},
	                url: 'invoice',
	                type: 'POST',
	                data: { 'data':data },
	                success: function(response)
	                {
	                    alert(response);
	                    //location.href="/users";
	                }, error: function(xhr, ajaxOptions, thrownError){
	                	alert(xhr.status);
        				alert(thrownError);
	                }
	            });
	        });
		});

	</script>
</body>
</html>
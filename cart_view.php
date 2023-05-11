<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<h1 class="page-header">YOUR CART</h1>
	        		<div class="box box-solid">
	        			<div class="box-body">
		        		<table class="table table-bordered">
		        			<thead>
		        				<th></th>
		        				<th>Photo</th>
		        				<th>Name</th>
		        				<th>Price</th>
		        				<th width="20%">Quantity</th>
		        				<th>Subtotal</th>
		        			</thead>
		        			<tbody id="tbody">
		        			</tbody>
		        		</table>
	        			</div>
	        			<form action="https://uat.esewa.com.np/epay/main" method="POST">
						    <input value="100"id="tAmt" name="tAmt" type="hidden">
						    <input value="90" name="amt" type="hidden">
						    <input value="5" name="txAmt" type="hidden">
						    <input value="2" name="psc" type="hidden">
						    <input value="3" name="pdc" type="hidden">
						    <input value="EPAYTEST" name="scd" type="hidden">
						    <input value="ee2c3ca1-696b-4cc5-a6be-2c40d929d453" name="pid" type="hidden">
						    <input value="http://merchant.com.np/page/esewa_payment_success?q=su" type="hidden" name="su">
						    <input value="http://merchant.com.np/page/esewa_payment_failed?q=fu" type="hidden" name="fu">
						    <input value="Submit" id="esewa-button" type="submit">
						 
    					</form>
	        		</div>
	        		<?php
	        			if(isset($_SESSION['user'])){
	        				echo "
	        					<div id='esewa-button'></div>
	        				";
	        			}
	        			else{
	        				echo "
	        					<h4>You need to <a href='login.php'>Login</a> to checkout.</h4>
	        				";
	        			}
	        		?>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	    <div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
var total = 0;
$(function(){
	$(document).on('click', '.cart_delete', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'cart_delete.php',
			data: {id:id},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.minus', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		if(qty>1){
			qty--;
		}
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.add', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		qty++;
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	getDetails();
	getTotal();

});

	function getDetails(){
		$.ajax({
			type: 'POST',
			url: 'cart_details.php',
			dataType: 'json',
			success: function(response){
				$('#tbody').html(response);
				getCart();
			}
		});
	}

	function getTotal(){
		$.ajax({
			type: 'POST',
			url: 'cart_total.php',
			dataType: 'json',
			success:function(response){
				total = response;
			}
		});
	}
</script>
<script type="text/javascript">
	var path="https://uat.esewa.com.np/epay/main";
	var params= {
	    amt: 100,
	    psc: 0,
	    pdc: 0,
	    txAmt: 0,
	    tAmt: 100,
	    pid: "ee2c3ca1-696b-4cc5-a6be-2c40d929d453",
	    scd: "EPAYTEST",
	    su: "http://merchant.com.np/page/esewa_payment_success",
	    fu: "http://merchant.com.np/page/esewa_payment_failed"
	}

	function post(path, params) {
	    var form = document.createElement("form");
	    form.setAttribute("method", "POST");
	    form.setAttribute("action", path);

	    for(var key in params) {
	        var hiddenField = document.createElement("input");
	        hiddenField.setAttribute("type", "hidden");
	        hiddenField.setAttribute("name", key);
	        hiddenField.setAttribute("value", params[key]);
	        form.appendChild(hiddenField);
	    }

	    document.body.appendChild(form);
	    form.submit();

	}
</script>
</body>
</html>
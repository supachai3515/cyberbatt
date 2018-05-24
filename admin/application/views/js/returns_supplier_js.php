<script type="text/javascript">

	app.controller("returns_supplier", function($scope, $http, $uibModal, $log) {

	  $scope.product_returns_supplier = [];
	  <?php if (isset($returns_supplier_data['id'])): ?>
		$scope.select_supplier = 0;
	  	 $scope.intireturns_supplier = function() {

		           $http({
		            method: 'POST',
		            url: '<?php echo base_url('returns_supplier/get_returns_supplier_detail');?>',
		             headers: {
		           'Content-Type': 'application/x-www-form-urlencoded'
		         },

		         data: { id : "<?php echo $returns_supplier_data['id']; ?>"}

		        }).success(function(data) {
		             var product_returns_supplier_re = data;
		             angular.forEach(product_returns_supplier_re,function(value,key){

									 $scope.select_supplier = value.supplier_id;

		             		var product_returns_supplier = {
											 			id: value.id,
														product_id:  value.product_id,
	                          sku:  value.sku,
	                          name:  value.name,
														serial_number :  value.serial_number,
														comment :  value.issues_comment,
	                          qty: value.qty,
	                          price: value.price,
	                          total: value.total
	                      };

	                 	$scope.product_returns_supplier.push(product_returns_supplier);

			        });

		       });

	       }

			$scope.intireturns_supplier();
	  <?php endif ?>


	  $scope.addreturns_supplier = function() {
	  	 try {

	      if ($scope.serial_number.length > 0 && $scope.select_supplier.length > 0) {
	          $scope.msgError = "";

	          $http({
	              method: 'POST',
	              url: '<?php echo base_url('returns_supplier/get_product');?>',
	              headers: {
	                  'Content-Type': 'application/x-www-form-urlencoded'
	              },

	              data: {
									serial_number: $scope.serial_number,
									supplier_id : $scope.select_supplier
	              }

	          }).success(function(data) {

	              var product_returns_supplier_re = data;

	              try {

	                  if (product_returns_supplier_re["sku"].length > 0) {
	                      var vat_p = 0;
	                      if ($scope.is_vat_rececive) {
	                          vat_p = parseInt((product_returns_supplier_re["price"] * 1) * 7 /107);
	                      }

	                      var product_returns_supplier = {
	                      	  id: product_returns_supplier_re["id"],
														product_id: product_returns_supplier_re["product_id"],
	                          sku: product_returns_supplier_re["sku"],
	                          name: product_returns_supplier_re["name"],
														serial_number : product_returns_supplier_re["serial"],
														comment : product_returns_supplier_re["issues_comment"],
	                          qty: 1,
	                          price: product_returns_supplier_re["price"],
	                          vat: vat_p,
	                          total: 1 *  product_returns_supplier_re["price"],
	                      };

	                      if($scope.product_returns_supplier.length > 0)
	                      {
	                      	var isdup = 0;
	                      	 angular.forEach($scope.product_returns_supplier, function(value,index) {
		                      	if(value.serial_number == product_returns_supplier_re["serial"] ){
		                      		isdup = 1;
		                      		$scope.msgError = "ข้อมูลสินค้า "+product_returns_supplier_re["serial"] +" : "+product_returns_supplier_re["name"]+" ***ซ้ำ***  กรุณาลบแล้วเพิ่มใหม่";
		                      	}

							 				 });

	                      	 if(isdup == 0){
	                      	 		$scope.product_returns_supplier.push(product_returns_supplier);
	                      	 }
	                      }
	                      else{
	                      	$scope.product_returns_supplier.push(product_returns_supplier);
	                      }

	                  }

	              } catch (err) {
	                  $scope.msgError = "ไม่มีข้อมูลสินค้า";
	              }
	          });

	      }
				else{
					$scope.msgError = "กรุณากรอกข้อมูลให้ครบ";
				}

	    } catch (err) {
	          $scope.msgError = "กรุณากรอกข้อมูลให้ครบ";
	    }


	  };

	   $scope.removeProduct = function(index){
	    $scope.product_returns_supplier.splice(index, 1);
	   };


		$scope.getTotalreturns_supplier = function(){
		    var total = 0;
		    for(var i = 0; i < $scope.product_returns_supplier.length; i++){
		        var product = $scope.product_returns_supplier[i];
		        total += (parseFloat(product.price) * parseFloat(product.qty));
		    }
		    return total;
		}

		$scope.getVatreturns_supplier = function(){
		    var total = 0;
		    for(var i = 0; i < $scope.product_returns_supplier.length; i++){
		        var product = $scope.product_returns_supplier[i];
		        total += (parseFloat(product.vat));
		    }
		    return total;
		}

		$scope.getQtyreturns_supplier = function(){
		    var total = 0;
		    for(var i = 0; i < $scope.product_returns_supplier.length; i++){
		        var product = $scope.product_returns_supplier[i];
		        total += (parseFloat(product.qty));
		    }
		    return total;
		}


	});


var minD = $("#startDate").html();
        var maxD = $("#endDate").html();
		var startDateTextBox = $('#dateStart');
		var endDateTextBox = $('#dateEnd');

		startDateTextBox.datepicker({
			format: "yyyy-mm-dd",
			language: "th",
			autoclose: true,
			todayHighlight: true,
			todayBtn: true,
			enableOnReadonly : true,
			changeMonth : true ,
			changeYear : true,
			yearRange : "c-2:c+80",
			onClose: function(dateText, inst) {
				if (endDateTextBox.val() != '') {
					var testStartDate = startDateTextBox.datetimepicker('getDate');
					var testEndDate = endDateTextBox.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						endDateTextBox.datetimepicker('setDate', testStartDate);
				}
				else {
					endDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
			}
		});
</script>

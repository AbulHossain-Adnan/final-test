@extends('layouts.frontend_layout')
@section('frontendContent')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/styles/cart_responsive.css">
 
	<!-- Cart -->

	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Shopping Cart</div>
						<div class="cart_items">
							<ul class="cart_list">

								<table class="table">
							  <thead>
							    <tr>
							      <th scope="col">id</th>
							      <th scope="col">image</th>
							      <th scope="col">name</th>
							      <th scope="col">quantity</th>
							      <th scope="col">price</th>
							      <th scope="col">action</th>


							    </tr>
							  </thead>
							  <tbody>

							   
							  </tbody>
							</table>
						</div>
						
						<!-- Order Total -->
						<div class="order_total">
						
						</div><br><br>

						<div class="row">

						  <div class="col-sm-6"> 
						  	@if(session()->get('coupon'))
								    @else
						  	
						  	<div id="applycouponfield">
								  <div class="form-group">
								    <label for="exampleInputEmail1"><h2>Coupon</h2></label>

								    <input type="text" class="form-control" id="coupon_name" name="coupon_name" aria-describedby="emailHelp" placeholder="Enter Coupon">
								    
								  
								  </div>
								
								  <button type="submit" class="btn btn-primary" onclick="applycoupon()">Apply coupon</button>
							</div>
							@endif

						  	
						      	


						   </div>
			
						 
						
						
						  <div class="col-sm-6">


						  	
						    	<div class="order_total_content text-md-right" >
						    		
								<div class="order_total_title" id="cartcalculationfield">
								


								

								</div>
							

						
							

								</div>
								<form action="{{ route('checkout') }}" method="post">
									@csrf

						      <div class="cart_buttons">
						      	@if(session()->has('coupon'))

						      	<input type="hidden" value="{{session()->get('coupon')['name']}}" name="name">
						      	<input type="hidden" value="{{session()->get('coupon')['discount']}}" name="discount">

						      	<input type="hidden" value="{{session()->get('coupon')['discount_amount']}}" name="discount_amount">

						      	<input type="hidden" value="{{session()->get('coupon')['subtotal']}}" name="subtotal">
						      	<input type="hidden" value="{{session()->get('coupon')['grand_total']}}" name="grand_total">
						      	<input type="hidden" value="{{session()->get('coupon')['discount_amount']}}" name="discount_amount">


						     

						      	@else
						      		<input type="hidden" value="NULL" name="name">
						      	<input type="hidden" value="Null" name="discount">

						      	<input type="hidden" value="Null" name="discount_amount">

						      	<input type="hidden" value="{{Cart::subtotal()}}" name="subtotal">

						      		<input type="hidden" value="{{Cart::subtotal()}}" name="grand_total">
						      	<input type="hidden" value="Null" name="discount_amount">

						      	@endif
						     



						      	
									<button type="button" class="button cart_button_clear">All Clear</button>
								
									<button class="btn btn-primary btn-lg">Checkout</button>

									
								</div>

								</form>
						      </div>
						   
						 
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


 function alldata(){
	$.ajax({
		type:"GET",
		datatype:"json",
		url:"/cartdata/",
		success:function(response){

			$('tbody').html("");

			$.each(response, function(key,value){

				$('tbody').append('<tr>\
					<td>'+value.id+'</td>\
					<td><img src="product_images/'+value.options.image+'" width="100"></td>\
					<td>'+value.name+'</td>\
					<td><button class="btn btn-success btn-sm" min="1" max="100" id='+value.rowId+'   onclick="decrement(this.id)">-</button>\
					<input type="text" id="quantity_name" name="quantity_name" value='+value.qty+' style="width:25px;">\
					<button class="btn btn-danger btn-sm" id='+value.rowId+' onclick="increment(this.id)">+</button></td>\
					<td>'+value.price+'</td>\
					<td><button class="btn btn-warning btn-sm" id='+value.rowId+' onclick="cart_remove(this.id)">x</button></td>\
					</tr>');
				




			})
			


		}

	});
}
alldata();






function increment(rowId){


	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


	// var rowId = $("#rowId").val();


	$.ajax({
		type:"GET",
		datatype:"json",
		url:"/increment/"+rowId,
		success:function(response){
		
		cartcalculation();
		alldata();
		minicart(); 


		}
	})
}



function decrement(rowId){


	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


	// var rowId = $("#rowId").val();


	$.ajax({
		type:"GET",
		datatype:"json",
		url:"/decrement/"+rowId,
		success:function(response){
		
		cartcalculation();
		alldata();
		minicart(); 

		}
	})
}


alldata();


function cart_remove(id){



	$.ajax({
		type:"GET",
		datatype:"json",
		url:"/cartremove/"+id,
		success:function(data){

			cartcalculation();
			alldata();
			minicart(); 
			$('#applycouponfield').show();


const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'success',
  title: 'cart remove succesfully'
})

		}
	})
}



function applycoupon(){

var coupon_name = $('#coupon_name').val();
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

	$.ajax({
		type:"POST",
		datatype:"json",
		data:{coupon_name:coupon_name},
		url:"/applycouponn/",
		success:function(data){

		
			 
			cartcalculation();
			 window.location.reload()

			$('#coupon_name').val('');
			

			const Toast = Swal.mixin({
			  toast: true,
			  position: 'top-end',
			  showConfirmButton: false,
			  timer: 3000,
			  timerProgressBar: true,
			  didOpen: (toast) => {
			    toast.addEventListener('mouseenter', Swal.stopTimer)
			    toast.addEventListener('mouseleave', Swal.resumeTimer)
			  }
			})


			 if ($.isEmptyObject(data.error)){
                      Toast.fire({
                      icon: 'success',
                      title: data.success
                    })
                      $('#applycouponfield').hide();

                    }
                    else{
                        Toast.fire({
                          icon: 'error',
                          title: data.error
                        })
                    }

               


		}
		
		
	});


}
 








// function cartcalculation(){ 
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

// 		$.ajax({
// 			type:"GET",
// 			datatype:"json",
// 			url:"/cartcalculation/",
// 			success:function(data){

// 				if(data.total){
// 				$("#cartcalculationfield").html(`
// 					<tr>
// 					<th>
// 					<div class="order_total_title">Order Total:</div>

// 					<div class="order_total_amount">{{Cart::subtotal()}}</div>
// 					</th>
// 					</tr>

// 					`);
// 			}
// 			else{
// 				$('#cartcalculationfield').html(`

// 					<tr>
// 					<th>

// 					<div>
// 								<div class="order_total_title">subtotal:</div>
// 								<div class="order_total_amount">${data.subtotal}$</div>

// 							</div>
// 							<div>
// 							<div class="order_total_title">Coupon name:</div>

// 							<div class="order_total_amount">${data.name}</div>
// 							<div>
// 							<button type="submit" class="btn btn-danger" onclick="couponremove()"><h3>x</h3></button>
// 						</div>
							
// 							<div>
// 								<div class="order_total_title">discount:</div>
// 								<div class="order_total_amount">${data.discount}% = ${data.discount_amount}$</div>
// 							</div>
							
// 							<div>
// 								<div class="order_total_title">Grand Total:</div>
// 								<div class="order_total_amount">${data.grand_total}$</div>
// 							</div>

// 					</th>
// 					</tr>



// 					`)
// 			}

// 			}
// 		});

// 	}



function cartcalculation(){

	$.ajax({

		type:"GET",
		datatype:"json",
		url:"/cartcal/",
		success:function(data){
	
			if(data.total){
				$("#cartcalculationfield").html(`
					<tr>
					<th>
					<div class="order_total_title">Order Total:</div>

					<div class="order_total_amount">${data.total}</div>
					</th>
					</tr>

					`);
			}
			else{
				$('#cartcalculationfield').html(`

					<tr>
					<th>

					<div>
								<div class="order_total_title">subtotal:</div>
								<div class="order_total_amount">${data.subtotal}$</div>

							</div>
							<div>
							<div class="order_total_title">Coupon name:</div>

							<div class="order_total_amount">${data.name}</div>
							<div>
							<button type="submit" class="btn btn-danger" onclick="couponremove()"><h3>x</h3></button>
						</div>
							
							<div>
								<div class="order_total_title">discount:</div>
								<div class="order_total_amount">${data.discount}% = ${data.discount_amount}$</div>
							</div>
							
							<div>
								<div class="order_total_title">Grand Total:</div>
								<div class="order_total_amount">${data.grand_total}$</div>
							</div>

					</th>
					</tr>



					`)
			}

		}
	})
}
cartcalculation();
	
































function couponremove(){

	$.ajax({
		type:"GET",
		datatype:"json",
		url:"/couponremove/",
		success:function(data){
			location.reload();
			cartcalculation();
			minicart(); 
			$('#applycouponfield').show();
			
				const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'success',
  title: 'coupon remove succesfully'
})



		}
	})
}



		
	</script>



@endsection
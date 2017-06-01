@foreach ($list as $product)
<div class="{{$classN}}">
	 <div class="product">
	 @if($product->km!=0)`
	 <div id="img_gift"><img src="{{ asset('upload/logo/khuyenmai.gif') }}" alt=""></div>
	 @endif
	 	<a href="{{ route('product',[$product->id]) }}">
			<div class="img_product"><img src="{{ asset('images/').'/'.$product->anh}}" alt="">
			</div>
			<div class="info_product">
				<p class="name_product">{{$product->ten}}</p>
				<div class="cost_product"> 
					@if($product->discount>0)
					<span class="cost_old">{{number_format($product->giaban)}}<span style="position: absolute;font-size: 14px">đ</span></span>
					<span class="cost_new">{{number_format($product->giaban-$product->discount)}}<span style="position: absolute;font-size: 14px">đ</span></span>
					@else
						<span class="cost_new">{{number_format($product->giaban)}}<span style="position: absolute;font-size: 14px;">đ</span></span>
					@endif
				</div>
			</div>
		</a>
		@if(isset($show_cart))
		<div class="product_hover">
			<a onclick="dathang2({{$product->id}})" class="btn btn-warning" ><img src="{{ asset('upload/logo/small-cart.png') }}" alt="" >Thêm vào giỏ hàng</a>
		</div>
		@endif
	</div>
</div>
@endforeach
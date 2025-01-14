@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Barcode List <span class="badge rounded-pill alert-success"> {{ count($products) }} </span></h2>
        <div class="">
            <a href="{{ route('custom.print') }}" class="btn btn-primary"><i class="fa-solid fa-arrow-right"></i>Barcode/Tag Print</a>
        </div>
    </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
               <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th class="text-center"> Barcode</th>
                            <th class="text-center">Variant</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Price</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    @if($products->count() > 0)
	                    <tbody>
	                        @foreach ($products as $key => $product)
	                        	@if($product->is_varient)
	                        		@foreach ($product->stocks as $key => $stock)
    	                        		@php
        	                                $discount = 0;
                                            $amount = $stock->price;
                                            if ($product->discount_price > 0) {
                                                if ($product->discount_type == 1) {
                                                    $discount = $product->discount_price;
                                                    $amount = $stock->price - $discount;
                                                } elseif ($product->discount_type == 2) {
                                                    $discount = ($stock->price * $product->discount_price) / 100;
                                                    $amount = $stock->price - $discount;
                                                } else {
                                                    $amount = $stock->price;
                                                }
                                            }
        	                            @endphp
                        				<tr>
			                                <td>{{ $product->name_en }}</td>
			                                <td class="text-center"> <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($stock->stock_code, 'C128',2,23) }}" alt="barcode"/></td>
			                                <td class="text-center">{{ $stock->varient }}</td>
			                                <td class="text-center">{{ $stock->qty }}</td>
			                                <td class="text-center">{{ $amount }}</td>
			                                <td class="text-center">
			                                   <a class="btn bg-success btn-icon btn-circle btn-sm btn-xs" href="{{ route('barcode.print', $product->id) }}?variant={{$stock->id}}">
			                                        <i class="fa-solid fa-download"></i>
			                                    </a>
			                                </td>
			                                <input type="hidden" id="pv_{{ $product->id }}" value="{{ $stock->id }}">
                                            <input type="hidden" id="pv_type_{{ $product->id }}" value="1">
			                            </tr>
	                        		@endforeach
	                        	@else
    	                        	@php
    	                                $discount = 0;
                                        $amount = $product->regular_price;
                                        if ($product->discount_price > 0) {
                                            if ($product->discount_type == 1) {
                                                $discount = $product->discount_price;
                                                $amount = $product->regular_price - $discount;
                                            } elseif ($product->discount_type == 2) {
                                                $discount = ($product->regular_price * $product->discount_price) / 100;
                                                $amount = $product->regular_price - $discount;
                                            } else {
                                                $amount = $product->regular_price;
                                            }
                                        }
    	                            @endphp
		                            <tr>
		                                <td>{{ $product->name_en }}</td>
		                                <td class="text-center"><img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->product_code, 'C128',2,23) }}" alt="barcode"/></td>
		                                <td class="text-center">-</td>
		                                <td class="text-center">{{ $product->stock_qty }}</td>
		                                <td class="text-center">{{ $amount }}</td>
		                                <td class="text-center">
		                                    <a class="btn bg-success btn-icon btn-circle btn-sm btn-xs" href="{{ route('barcode.print', $product->id) }}">
		                                        <i class="fa-solid fa-download"></i>
		                                    </a>
		                                </td>
		                                <input type="hidden" id="pv_type_{{ $product->id }}" value="0">
		                            </tr>
	                            @endif
	                        @endforeach
	                    </tbody>
                    @else
	                    <tbody>
	                        <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center">There Are No Products.</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
	                    </tbody>
                    @endif
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
</section>
@endsection
@push('footer-script')

@endpush

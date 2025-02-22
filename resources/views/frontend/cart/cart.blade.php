@php
	$setting = DB::table('settings')->get()->first();
@endphp
@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/styles/cart_responsive.css">
@include('layouts.front_partial.collaps_nav')

<div class="cart_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="cart_container">
                    @if(count($content) == 0)
                        <div class="text-danger">
                            <h1 class="text-center cart_title p-5">Sjoping Cart is empty</h1>
                        </div>
                    @else
                        <div class="cart_title">Shopping Cart</div>
                        <div class="cart_items">
                            <ul class="cart_list">

                                @foreach($content as $row)
                                @php
                                    $product=DB::table('products')->where('id',$row->id)->first();
                                    $colors=explode(',',$product->color);
                                    $sizes=explode(',',$product->size);
                                @endphp
                                <li class="cart_item clearfix">
                                    
                                    <div class="cart_item_image">
                                        <img src="{{ asset('files/product/'.$row->options->thumbnail) }}" alt="">
                                    </div>
                                    <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                        <div class="cart_item_name cart_info_col">
                                            <div class="cart_item_text">{{ substr($row->name,0,15) }}..</div>
                                        </div>
                                        @if($row->options->size !=NULL)
                                        <div class="cart_item_color cart_info_col">                                        
                                            <div class="cart_item_text">
                                                <select class="custom-select form-control-sm size" name="size" style="min-width: 100px;" data-id="{{ $row->rowId }}">
                                                        @foreach($sizes as $size)
                                                            <option value="{{ $size }}" @if($size == $row->options->size) selected="" @endif >{{ $size }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif


                                        @if($row->options->color !=NULL)
                                        <div class="cart_item_color cart_info_col">
                                            <div class="cart_item_text">
                                                <select class="custom-select form-control-sm color" data-id="{{ $row->rowId }}" name="color" style="min-width: 100px;">
                                                    @foreach($colors as $color)
                                                        <option value="{{ $color }}" @if($color==$row->options->color) selected="" @endif >{{ $color }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="cart_item_quantity cart_info_col">
                                            <div class="cart_item_text">
                                                <input type="number" class="form-control-sm qty" name="qty" style="min-width: 70px;" data-id="{{ $row->rowId }}" min="1"  value="{{ $row->qty }}" required="">                                            
                                            </div>
                                        </div>

                                        <div class="cart_item_price cart_info_col">                                        
                                            <div class="cart_item_text">{{ $setting->currency }}{{ $row->price }} x {{$row->qty }}</div>
                                        </div>
                                        <div class="cart_item_total cart_info_col">
                                            <div class="cart_item_text">{{ $setting->currency }} {{ $row->qty*$row->price }}</div>                                        
                                        </div>
                                        <div class="cart_item_total cart_info_col">
                                            
                                            <div class="cart_item_text text-danger">
                                                <a href="#" data-id="{{ $row->rowId }}" id="removeProduct" onclick="return confirm('Are you Sure?');" > X</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach                            
                            </ul>
                        </div>
                        

                        <!-- Order Total -->
                        <div class="order_total">
                            <div class="order_total_content text-md-right">
                                <div class="order_total_title">Order Total:</div>
                                <div class="order_total_amount">{{ $setting->currency }}{{ Cart::total() }}</div>
                            </div>
                        </div>

                        <div class="cart_buttons">
                            <a href="{{route('empty.cart')}}" class="button cart_button_clear btn-danger">Empty Cart</a>
                            <a href="{{route('checkout')}}" class="button cart_button_checkout">Checkout</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter -->

<div class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                    <div class="newsletter_title_container">
                        <div class="newsletter_icon"><img src="{{asset('frontend')}}/images/send.png" alt=""></div>
                        <div class="newsletter_title">Sign up for Newsletter</div>
                        <div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
                    </div>
                    <div class="newsletter_content clearfix">
                        <form action="{{route('newsletter')}}" class="newsletter_form" method="POST">
                            @csrf
                            <input type="email" name="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                            <button class="newsletter_button" type="submit">Subscribe</button>
                        </form>
                        <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('backend')}}/dist/js/ajax.js"></script>
<script>
    $('body').on('click','#removeProduct', function(){
        let id=$(this).data('id');
        $.ajax({
            url:'{{ url('cartproduct/remove/') }}/'+id,
            type:'get',
            async:false,
            success:function(data){
                toastr.success(data);
                location.reload();
            }
        });
    });
    // quantity change with ajax
    $('body').on('change','.qty', function(){
        let qty=$(this).val();
        let rowId=$(this).data('id');
            $.ajax({
            url:'{{ url('cartproduct/updateqty/') }}/'+rowId+'/'+qty,
            type:'get',
            async:false,
            success:function(data){
                toastr.success(data);
                location.reload();
            }
        });
    });
    // color change with ajax
    $('body').on('click','.color', function(){
        let color=$(this).val();
        let rowId=$(this).data('id');
        $.ajax({
            url:'{{ url('cartproduct/colorUpdate/') }}/'+rowId+'/'+color,
            type:'get',
            async:false,
            success:function(data){
                toastr.success(data);
            }
        });
    });
    $('body').on('change','.size', function(){
        let size=$(this).val();
        let rowId=$(this).data('id');
        alert(rowId);
        $.ajax({
            url:'{{ url('cartproduct/sizeUpdate/') }}/'+rowId+'/'+size,
            type:'get',
            async:false,
            success:function(data){
                toastr.success(data);
            }
        });
    });
</script>
@endsection
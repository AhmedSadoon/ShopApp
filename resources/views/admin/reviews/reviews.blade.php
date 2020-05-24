

@extends('layouts.app')

@section( 'content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">Reviews</div>

                <div class="card-body">

                   <div class="row">
                    @foreach($reviews as $review)

                        <div class="col-md-3">
                           <div class="alert alert-primary" role="alert">

                            <p>Customer: {{ $review->customer->formattedName() }}</p>
                            <p>Product: {{ $review->product->title}}</p>

                            {{--  <p>Stars:
                                @for($i = 0; $i < $review->stars; $i++)
                                <i class="fas fa-star"></i>
                                @endfor
                            </p>طريقة الاولى--}}



                            <p>Stars:
                                @php
                                    $total=5;
                                    $cureentStars=$review->stars;
                                    $remainingStars=$total-$cureentStars;

                                @endphp
                                @for($i = 0; $i < $review->stars; $i++)
                                <i class="fas fa-star"></i>
                                @endfor

                                @for($i = 0; $i < $remainingStars; $i++)
                                <i class="far fa-star"></i>
                                @endfor
                            </p>

                            <p>Review: {{ $review->review}}</p>
                            <p>Date: {{ $review->humanFormattedDate() }}</p>

                           </div>
                        </div>

                    @endforeach
                   </div>

                   {{ $reviews->links() }}

                </div>
            </div>
        </div>
    </div>
</div>



@endsection

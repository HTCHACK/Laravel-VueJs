@extends('layouts.app')

@section('head')
<script src="https://js.stripe.com/v3/"></script>
<style>
    .StripeElement {
        box-sizing: border-box;

        height: 40px;

        padding: 10px 12px;

        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subscribe for Starting Course Series</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <select name="plan" class="form-control" id="subscription-plan">
                        @foreach($plans as $key=>$plan)
                            <option value="{{$key}}">{{$plan}}</option>
                        @endforeach
                    </select>

                    <input id="card-holder-name" type="text" class="form-control">


                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <button id="card-button" class="mt-2 btn btn-sm btn-primary"  data-secret="{{ $intent->client_secret }}" style="font-size:20px;font-weight:bolder;font-family:sans-serif">
                        <img src="{{ asset('mas.png') }}" style="width:60px"> Pay
                    </button>
                </div>
            </div>
        </div>
    </div>

    <hr>
        <section>
            <pricing></pricing>
        </section>
</div>
@endsection

@section('js')
<!-- Scripts -->
<script>
    window.addEventListener('load', function() {

        const stripe = Stripe('{{env('STRIPE_KEY')}}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        const plan = document.getElementById('subscription-plan').value;

        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
            if (error) {
                // Display "error.message" to the user...
            } else {
                // The card has been verified successfully...
                console.log('handling success', setupIntent.payment_method);

                axios.post('/subscribe',{
                    payment_method: setupIntent.payment_method,
                    plan : plan
                }).then((data)=>{
                    location.replace(data.data.success_url)
                });
            }
        });
    });
</script>
@endsection

<div class="row" id="shipping_detail_form"> 
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            <label>First Name<span>*</span></label>
            <input type="text" name="shipping_fname" value="{{optional(Auth::user())->first_name}}" placeholder="" required="required">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            <label>Last Name<span>*</span></label>
            <input type="text" name="shipping_lname" value="{{optional(Auth::user())->last_name}}" placeholder="" required="required">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            <label>Email Address<span>*</span></label>
            <input type="email" name="shipping_email" placeholder="" value="{{optional(Auth::user())->email}}" required="required">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            <label>Phone Number<span>*</span></label>
            <input type="number" name="shipping_phone" placeholder="" value="{{optional(Auth::user())->mobile}}" required="required">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-12">
        <div class="form-group">
            <label>Street Address<span>*</span></label>
            <input type="text" name="shipping_street_address" placeholder="" value="@auth {{optional(Auth::user()->userAddress)->street_address}} @endauth" required="required">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            <label>City<span>*</span></label>
            <input type="text" name="shipping_city" placeholder="" required="required" value="@auth {{optional(Auth::user()->userAddress)->city}} @endauth">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            {!! Form::label('shipping_state', 'State/Provience *')!!}
            {!! Form::select('shipping_state', $proviences, (Auth::user()) ? optional(Auth::user()->userAddress)->provience : NULL, ['class' => ($errors->has('shipping_state') ? ' is-invalid' : ''), 'placeholder' => 'Select State/Provience', 'required' => 'required']) !!}
            <div class="invalid-feedback">
                {{ $errors->first('shipping_state') }}
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            <label>Zip / Postal Code<span>*</span></label>
            <input type="text" name="shipping_postal_code" placeholder="" value="@auth {{optional(Auth::user()->userAddress)->postal_code}} @endauth" required="required">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
            {!! Form::label('shipping_country', 'Country *')!!}
            {!! Form::select('shipping_country', $countries, (Auth::user()) ? optional(Auth::user()->userAddress)->country : NULL, ['class' => ($errors->has('shipping_country') ? ' is-invalid' : ''), 'id' => 'shipping_country', 'placeholder' => 'Select Country', 'required' => 'required']) !!}
            <div class="invalid-feedback">
                {{ $errors->first('shipping_country') }}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group create-account">
            <input id="same_billing_shipping" name="same_billing_shipping" value="1" type="checkbox" checked="checked">
            <label for="same_address">My shipping and billing address are same</label>
        </div>
    </div>
</div>
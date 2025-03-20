<div class="tab-pane fade active show" id="paypal-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.paypal-setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Paypal Status</label>
                    <select name="paypal_status" id="" class="select2 form-control">
                        <option @selected(config('gatewaySettings.paypal_status') == 1) value="1">Active</option>
                        <option @selected(config('gatewaySettings.paypal_status') == 0) value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Paypal Acount Mode</label>
                    <select name="paypal_account_mode" id="" class="select2 form-control">
                        <option @selected(config('gatewaySettings.paypal_account_mode') === 'sandbox') value="sandbox">Sandbox</option>
                        <option @selected(config('gatewaySettings.paypal_account_mode') === 'live') value="live">Live</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Paypal Country Name</label>
                    <select name="paypal_country" id="" class="select2 form-control">
                        <option value="">Select country</option>
                        @foreach (config('country_list') as $key => $country)
                            <option @selected(config('gatewaySettings.paypal_country') === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Paypal Currency Name</label>
                    <select name="paypal_currency" class="form-control select2">
                        <option value="">Select</option>
                        @foreach (config('currencys.currency_list') as $currency)
                            <option @selected(config('gatewaySettings.paypal_currency') === $currency) value="{{ $currency }}">
                                {{ $currency }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Currency Rate (Per {{ config('settings.site_default_currency') }})</label>
                    <input name="paypal_rate" type="text" class="form-control"
                        value="{{ config('gatewaySettings.paypal_rate') }}">
                </div>

                <div class="form-group">
                    <label>Paypal Client Id</label>
                    <input name="paypal_api_key" type="text" class="form-control"
                        value="{{ config('gatewaySettings.paypal_api_key') }}">
                </div>

                <div class="form-group">
                    <label>Paypal Serect Key</label>
                    <input name="paypal_secret_key" type="text" class="form-control"
                        value="{{ config('gatewaySettings.paypal_secret_key') }}">
                </div>

                <div class="form-group">
                    <label>Paypal App Id</label>
                    <input name="paypal_app_id" type="text" class="form-control"
                        value="{{ config('gatewaySettings.paypal_app_id') }}">
                </div>

                <div class="form-group">
                    <label>Paypal Logo</label>
                    <div id="image-preview" class="image-preview paypal_preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="paypal_logo" id="image-upload">
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('document').ready(function() {
            $('.paypal_preview').css({
                'background-image': 'url({{ asset(config('gatewaySettings.paypal_logo')) }})',
                'background-size': 'cover',
                'background-position': 'center',
            });
        });
    </script>
@endpush

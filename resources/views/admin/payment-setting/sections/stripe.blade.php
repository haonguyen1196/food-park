<div class="tab-pane fade show" id="stripe-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.stripe-setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Stripe Status</label>
                    <select name="stripe_status" id="" class="select2 form-control">
                        <option @selected(config('gatewaySettings.stripe_status') == 1) value="1">Active</option>
                        <option @selected(config('gatewaySettings.stripe_status') == 0) value="0">Inactive</option>
                    </select>
                </div>

                {{-- <div class="form-group">
                    <label>Stripe Acount Mode</label>
                    <select name="paypal_account_mode" id="" class="select2 form-control">
                        <option @selected(config('gatewaySettings.paypal_account_mode') === 'sandbox') value="sandbox">Sandbox</option>
                        <option @selected(config('gatewaySettings.paypal_account_mode') === 'live') value="live">Live</option>
                    </select>
                </div> --}}

                <div class="form-group">
                    <label>Stripe Country Name</label>
                    <select name="stripe_country" id="" class="select2 form-control">
                        <option value="">Select country</option>
                        @foreach (config('country_list') as $key => $country)
                            <option @selected(config('gatewaySettings.stripe_country') === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Stripe Currency Name</label>
                    <select name="stripe_currency" class="form-control select2">
                        <option value="">Select</option>
                        @foreach (config('currencys.currency_list') as $currency)
                            <option @selected(config('gatewaySettings.stripe_currency') === $currency) value="{{ $currency }}">
                                {{ $currency }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Stripe Rate (Per {{ config('settings.site_default_currency') }})</label>
                    <input name="stripe_rate" type="text" class="form-control"
                        value="{{ config('gatewaySettings.stripe_rate') }}">
                </div>

                <div class="form-group">
                    <label>Stripe Client Id</label>
                    <input name="stripe_api_key" type="text" class="form-control"
                        value="{{ config('gatewaySettings.stripe_api_key') }}">
                </div>

                <div class="form-group">
                    <label>Stripe Serect Key</label>
                    <input name="stripe_secret_key" type="text" class="form-control"
                        value="{{ config('gatewaySettings.stripe_secret_key') }}">
                </div>

                <div class="form-group">
                    <label>Stripe Logo</label>
                    <div id="image-preview-2" class="image-preview stripe_preview">
                        <label for="image-upload-2" id="image-label-2">Choose File</label>
                        <input type="file" name="stripe_logo" id="image-upload-2">
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
            $('.stripe_preview').css({
                'background-image': 'url({{ asset(config('gatewaySettings.stripe_logo')) }})',
                'background-size': 'cover',
                'background-position': 'center',
            });

            $.uploadPreview({
                input_field: "#image-upload-2", // Default: .image-upload
                preview_box: "#image-preview-2", // Default: .image-preview
                label_field: "#image-label-2", // Default: .image-label
                label_default: "Choose File", // Default: Choose File
                label_selected: "Change File", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
        });
    </script>
@endpush

<div class="tab-pane fade show" id="razorpay-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.razorpay-setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Razorpay Status</label>
                    <select name="razorpay_status" id="" class="select2 form-control">
                        <option @selected(config('gatewaySettings.razorpay_status') == 1) value="1">Active</option>
                        <option @selected(config('gatewaySettings.razorpay_status') == 0) value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Razorpay Country Name</label>
                    <select name="razorpay_country" id="" class="select2 form-control">
                        <option value="">Select country</option>
                        @foreach (config('country_list') as $key => $country)
                            <option @selected(config('gatewaySettings.razorpay_country') === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Razorpay Currency Name</label>
                    <select name="razorpay_currency" class="form-control select2">
                        <option value="">Select</option>
                        @foreach (config('currencys.currency_list') as $currency)
                            <option @selected(config('gatewaySettings.razorpay_currency') === $currency) value="{{ $currency }}">
                                {{ $currency }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Razorpay Rate (Per {{ config('settings.site_default_currency') }})</label>
                    <input name="razorpay_rate" type="text" class="form-control"
                        value="{{ config('gatewaySettings.razorpay_rate') }}">
                </div>

                <div class="form-group">
                    <label>Razorpay Client Id</label>
                    <input name="razorpay_api_key" type="text" class="form-control"
                        value="{{ config('gatewaySettings.razorpay_api_key') }}">
                </div>

                <div class="form-group">
                    <label>Razorpay Serect Key</label>
                    <input name="razorpay_secret_key" type="text" class="form-control"
                        value="{{ config('gatewaySettings.razorpay_secret_key') }}">
                </div>

                <div class="form-group">
                    <label>Razorpay Logo</label>
                    <div id="image-preview-3" class="image-preview razorpay_preview">
                        <label for="image-upload-3" id="image-label-3">Choose File</label>
                        <input type="file" name="razorpay_logo" id="image-upload-3">
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
            $('.razorpay_preview').css({
                'background-image': 'url({{ asset(config('gatewaySettings.razorpay_logo')) }})',
                'background-size': 'cover',
                'background-position': 'center',
            });

            $.uploadPreview({
                input_field: "#image-upload-3", // Default: .image-upload
                preview_box: "#image-preview-3", // Default: .image-preview
                label_field: "#image-label-3", // Default: .image-label
                label_default: "Choose File", // Default: Choose File
                label_selected: "Change File", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
        });
    </script>
@endpush

<div class="tab-pane fade active show" id="generate-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.general-setting.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Site Name</label>
                    <input name="site_name" type="text" class="form-control"
                        value="{{ config('settings.site_name') }}">
                </div>

                <div class="form-group">
                    <label>Default Currency</label>
                    <select name="site_default_currency" class="form-control select2">
                        <option value="">Select</option>
                        @foreach (config('currencys.currency_list') as $currency)
                            <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">
                                {{ $currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Currency Icon</label>
                            <input name="site_currency_icon" type="text" class="form-control"
                                value="{{ config('settings.site_currency_icon') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Currency Icon Position</label>
                            <select name="site_currency_icon_position" id="" class="select2 form-control">
                                <option @selected(config('settings.site_currency_icon_position') === 'right') value="right">Right
                                </option>
                                <option @selected(config('settings.site_currency_icon_position') === 'left') value="left">Left
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

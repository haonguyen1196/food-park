<div class="tab-pane fade show" id="pusher-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.pusher-setting.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Pusher App Id</label>
                    <input name="pusher_app_id" type="text" class="form-control"
                        value="{{ config('settings.pusher_app_id') }}">
                </div>

                <div class="form-group">
                    <label>Pusher Key</label>
                    <input name="pusher_key" type="text" class="form-control"
                        value="{{ config('settings.pusher_key') }}">
                </div>

                <div class="form-group">
                    <label>Pusher Secret</label>
                    <input name="pusher_secret" type="text" class="form-control"
                        value="{{ config('settings.pusher_secret') }}">
                </div>

                <div class="form-group">
                    <label>Pusher Cluster</label>
                    <input name="pusher_cluster" type="text" class="form-control"
                        value="{{ config('settings.pusher_cluster') }}">
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

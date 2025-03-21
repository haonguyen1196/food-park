<div class="tab-pane fade" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">
    <div class="fp_dashboard_body fp__change_password">
        <div class="fp__review_input">
            <h3>Đổi mật khẩu</h3>
            <div class="comment_input pt-0">
                <form action="{{ route('profile.password.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="fp__comment_imput_single">
                                <label>mật khẩu hiện tại</label>
                                <input name="current_password" type="password" placeholder="Mật khẩu hiện tại">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="fp__comment_imput_single">
                                <label>Mật khẩu mới</label>
                                <input name="password" type="password" placeholder="Mật khẩu mới">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="fp__comment_imput_single">
                                <label>xác nhận mật khẩu mới</label>
                                <input name="password_confirmation" type="password" placeholder="Xác nhận mật khẩu mới">
                            </div>
                            <button type="submit" class="common_btn mt_20">gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

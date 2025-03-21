<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <div class="fp_dashboard_body">
        <h3>Chào mừng đến hồ sơ của bạn</h3>

        <div class="fp__dsahboard_overview">
            <div class="row">
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="fp__dsahboard_overview_item">
                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                        <h4>tổng đơn hàng <span>(76)</span></h4>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="fp__dsahboard_overview_item green">
                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                        <h4>hoàn thành <span>(71)</span></h4>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="fp__dsahboard_overview_item red">
                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                        <h4>hủy <span>(05)</span></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="fp_dash_personal_info">
            <h4>Thông tin người dùng
                <a class="dash_info_btn">
                    <span class="edit">chỉnh sửa</span>
                    <span class="cancel">hủy</span>
                </a>
            </h4>

            <div class="personal_info_text">
                <p><span>Tên:</span> {{ auth()->user()->name }}</p>
                <p><span>Email:</span> {{ auth()->user()->email }}</p>
            </div>

            <div class="fp_dash_personal_info_edit comment_input p-0">
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="fp__comment_imput_single">
                                <label>tên</label>
                                <input name="name" type="text" placeholder="Tên"
                                    value="{{ auth()->user()->name }}">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <div class="fp__comment_imput_single">
                                <label>email</label>
                                <input name="email" type="email" placeholder="Email"
                                    value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <button type="submit" class="common_btn">gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

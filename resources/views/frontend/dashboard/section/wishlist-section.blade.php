<div class="tab-pane fade" id="v-pills-wishlist" role="tabpanel" aria-labelledby="v-pills-wishlist-tab">
    <div class="fp_dashboard_body">
        <h3>danh sách yêu thích</h3>
        <div class="fp_dashboard_order">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr class="t_header">
                            <th>No</th>
                            <th style="width: 40%">sản phẩm</th>
                            <th>Tồn kho</th>
                            <th>Hành động</th>
                        </tr>
                        @foreach ($wishlists as $wishlist)
                            <tr>
                                <td>
                                    <h5>{{ ++$loop->index }}</h5>
                                </td>
                                <td style="width: 40%">
                                    {{ $wishlist->product->name }}
                                </td>
                                <td>
                                    @if ($wishlist->product->quantity > 0)
                                        <h5 class="text-success">Còn hàng</h5>
                                    @else
                                        <h5 class="text-danger">Hết hàng</h5>
                                    @endif
                                </td>
                                <td>
                                    <a class="view_invoice"
                                        href="{{ route('product.show', $wishlist->product->slug) }}">Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

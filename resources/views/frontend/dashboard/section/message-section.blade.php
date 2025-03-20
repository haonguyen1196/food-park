<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    <div class="fp_dashboard_body fp__change_password">
        <div class="fp__message">
            <h3>Message</h3>
            <div class="fp__chat_area">
                <div class="fp__chat_body">

                    {{-- <div class="fp__chating">
                        <div class="fp__chating_img">
                            <img src="images/service_provider.png" alt="person" class="img-fluid w-100">
                        </div>
                        <div class="fp__chating_text">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                            <span>15 Jun, 2023, 05:26 AM</span>
                        </div>
                    </div> --}}
                    {{-- <div class="fp__chating tf_chat_right">
                        <div class="fp__chating_img">
                            <img src="images/client_img_1.jpg" alt="person" class="img-fluid w-100">
                        </div>
                        <div class="fp__chating_text">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                            <span>15 Jun, 2023, 05:26 AM</span>
                        </div>
                    </div> --}}
                </div>
                <form class="fp__single_chat_bottom chat_input">
                    @csrf
                    <label for="select_file"><i class="far fa-file-medical" aria-hidden="true"></i></label>
                    <input type="hidden" name="msg_temp_id" class="msg_temp_id" value="">
                    <input type="text" placeholder="Type a message..." name="message" class="fp_send_message">
                    <input type="hidden" name="receiver_id" value="1">
                    <button style="submit" class="fp__massage_btn"><i class="fas fa-paper-plane"
                            aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.chat_input').submit(function(e) {
                e.preventDefault();

                var msgId = Math.floor(Math.random() * 1000000000);
                $('.msg_temp_id').val(msgId);

                $formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('sendMessage.store') }}",
                    type: "POST",
                    data: $formData,
                    beforeSend: function() {
                        $message = $('.fp_send_message').val();
                        $html = `<div class="fp__chating tf_chat_right">
                                    <div class="fp__chating_img">
                                        <img src="{{ auth()->user()->avatar }}" alt="person" class="img-fluid w-100" style="border-radius: 50%">
                                    </div>
                                    <div class="fp__chating_text">
                                        <p>${$message}
                                        </p>
                                        <span class="${msgId}">sending...</span>
                                    </div>
                                </div>`;

                        $('.fp__chat_body').append($html);
                        $('.fp_send_message').val('');
                        $('.unseen-message').text(0);
                        $('.unseen-message').css('display', 'none');

                        scrollToBottom();
                    },
                    success: function(response) {
                        if (response.msg_id == msgId) {
                            $('.' + msgId).remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        $errorsAlert = xhr.responseJSON.errors;
                        $.each($errorsAlert, function(key, value) {
                            toastr.error(value);
                        });
                    }
                });
            });

            function scrollToBottom() {
                //đặt vị trí cuộn dọc bằng chiều cao thẻ
                $('.fp__chat_body').scrollTop($('.fp__chat_body')[0].scrollHeight);
            }

            $('.fp_chat_message').on('click', function() {
                $senderId = '{{ auth()->user()->id }}';

                $.ajax({
                    url: "{{ route('chat.get-conversation', ':senderId') }}"
                        .replace(':senderId', $senderId),
                    type: 'GET',
                    success: function(response) {

                        $('.fp__chat_body').empty();

                        $.each(response, function(index, obj) {


                            $baseUrl = "{{ config('app.url') }}";
                            $avatar = $baseUrl + obj.sender.avatar;

                            $html = ` <div class="fp__chating ${obj.sender.id == $senderId ? 'tf_chat_right' : ''} ">
                                    <div class="fp__chating_img">
                                        <img src="${ $avatar  }" alt="person" class="img-fluid w-100" style='border-radius: 50%'>
                                    </div>
                                    <div class="fp__chating_text">
                                        <p>${obj.message}</p>
                                    </div>
                                </div>`;

                            $('.fp__chat_body').append($html);

                            //unnotification new message
                            $('.unseen-message').text(0);
                            $('.unseen-message').css('display', 'none');

                        });

                        scrollToBottom();
                    },
                    error: function(xhr, status, error) {

                    }
                });
            })
        });
    </script>
@endpush

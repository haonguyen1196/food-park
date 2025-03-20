@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chat Box</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Chat Box</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card" style="height: 75vh">
                        <div class="card-header">
                            <h4>Who's Online?</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($senders as $sender)
                                    @php
                                        $chatUser = \App\Models\User::find($sender->sender_id);
                                        $newMessage = \App\Models\Chat::where('receiver_id', auth()->id())
                                            ->where('sender_id', $sender->sender_id)
                                            ->where('seen', 0)
                                            ->count();
                                    @endphp
                                    <li class="media fp_chat_user" data-name="{{ $chatUser->name }}"
                                        data-user="{{ $chatUser->id }}" style="cursor: pointer">
                                        <img alt="image" class="mr-3 rounded-circle object-cover" width="50"
                                            height="50" src="{{ asset($chatUser->avatar) }}">
                                        <div class="media-body">
                                            <div class="mt-0 mb-1 font-weight-bold">{{ $chatUser->name }}</div>
                                            <div class="text-warning text-small font-600-bold got_new_message">
                                                @if ($newMessage > 0)
                                                    <i class="beep"></i>new message
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-9">
                    <div class="card chat-box" id="mychatbox" data-inbox="" style="height: 75vh">
                        <div class="card-header">
                            <h4 class="chat_header"></h4>
                        </div>
                        <div class="card-body chat-content">

                        </div>
                        <div class="card-footer chat-form">
                            <form id="chat-form">
                                @csrf
                                <input type="text" class="form-control fp_send_message" placeholder="Type a message"
                                    name="message">
                                <input type="hidden" name="receiver_id" id="receiver_id" value="">
                                <input type="hidden" name="msg_temp_id" class="msg_temp_id" value="">
                                <button class="btn btn-primary" type="submit">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $userId = {{ auth()->user()->id }};

            function scrollToBottom() {
                //đặt vị trí cuộn dọc bằng chiều cao thẻ
                $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight);
            }

            //get conversation
            $('.fp_chat_user').on('click', function() {
                $senderId = $(this).data('user');
                $senderName = $(this).data('name');
                $('#receiver_id').val($senderId);

                $this = $(this);

                //validate message
                $('#mychatbox').attr('data-inbox', $senderId);

                $.ajax({
                    url: "{{ route('admin.chat.get-conversation', ':senderId') }}"
                        .replace(':senderId', $senderId),
                    type: 'GET',
                    beforeSend: function() {
                        $('.chat-content').empty();
                        $('.chat_header').text('Chat with ' + $senderName);
                    },
                    success: function(response) {

                        $.each(response, function(index, obj) {
                            $baseUrl = "{{ config('app.url') }}";
                            $avatar = $baseUrl + obj.sender.avatar;


                            $html = ` <div class="chat-item ${$userId == obj.sender_id ? "chat-right" : "chat-left"}" style=""><img class="object-cover" width="50"
                                            height="50" src="${$avatar}">
                                    <div class="chat-details">
                                        <div class="chat-text">${ obj.message }</div>
                                    </div>
                                </div>`;

                            $('.chat-content').append($html);

                        });

                        scrollToBottom();
                        $this.find('.got_new_message').empty();

                        //unnotification new message condition seen = 1

                        $('.message_beep').removeClass('beep');

                    },
                    error: function(xhr, status, error) {

                    }
                });
            })

            //send message
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();

                var msgId = Math.floor(Math.random() * 1000000000);
                $('.msg_temp_id').val(msgId);

                $formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.chat.send-message') }}",
                    type: "POST",
                    data: $formData,
                    beforeSend: function() {
                        $message = $('.fp_send_message').val();
                        $html = ` <div class="chat-item chat-right" style=""><img src="{{ auth()->user()->avatar }}">
                                    <div class="chat-details">
                                        <div class="chat-text">${ $message }</div>
                                        <div class="chat-time ${msgId}">seeding...</div>
                                    </div>
                                </div>`;

                        $('.chat-content').append($html);
                        $('.fp_send_message').val('');

                        scrollToBottom();

                        //unnotification new message
                        $('.fp_chat_user').each(function() {
                            $inbox = $('#mychatbox').data('inbox');
                            if ($(this).data('user') == $inbox) {
                                $(this).find('.got_new_message').empty();
                            }
                        });
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
            })
        });
    </script>
@endpush

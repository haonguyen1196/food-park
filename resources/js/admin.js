function scrollToBottom() {
    //đặt vị trí cuộn dọc bằng chiều cao thẻ
    $(".chat-content").scrollTop($(".chat-content")[0].scrollHeight);
}

window.Echo.private("chat." + loggedInUserId).listen("ChatEvent", (e) => {
    if (e.senderId == $("#mychatbox").attr("data-inbox")) {
        $html = ` <div class="chat-item chat-left" style=""><img class="object-cover" width="50"
                            height="50" src="${e.avatar}">
                    <div class="chat-details">
                        <div class="chat-text">${e.message}</div>
                    </div>
                </div>`;

        $(".chat-content").append($html);

        scrollToBottom();
    }

    //new message notification
    $(".fp_chat_user").each(function () {
        //kiểm tra xem thẻ có data-id bằng với senderId của tin nhắn mới gửi không
        if ($(this).attr("data-user") == e.senderId) {
            let html = `<i class="beep"></i>new message`;
            $(this).find(".got_new_message").html(html);
        }
    });

    $(".message_beep").addClass("beep");
});

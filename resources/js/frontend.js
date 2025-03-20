function scrollToBottom() {
    //đặt vị trí cuộn dọc bằng chiều cao thẻ
    $(".fp__chat_body").scrollTop($(".fp__chat_body")[0].scrollHeight);
}

window.Echo.private("chat." + loggedInUserId).listen("ChatEvent", (e) => {
    let html = ` <div class="fp__chating">
                <div class="fp__chating_img">
                    <img src="${e.avatar}" alt="person" class="img-fluid w-100" style='border-radius: 50%'>
                </div>
                <div class="fp__chating_text">
                    <p>${e.message}</p>
                </div>
            </div>`;

    $(".fp__chat_body").append(html);

    scrollToBottom();

    // Kiểm tra sự tồn tại của phần tử và lấy giá trị

    var unseenMessageCount =
        $(".unseen-message").length > 0
            ? parseInt($(".unseen-message").first().text())
            : 0;
    console.log(unseenMessageCount);

    $(".unseen-message").css("display", "block");
    $(".unseen-message").text(unseenMessageCount + 1);
});

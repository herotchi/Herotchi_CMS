<!-- トップへ戻るボタン -->
<a href="#" class="scroll_top">
    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 18 18">
        <title>Page Top</title>
        <path fill-rule="evenodd" d="M9 5.795c-.316 0-.634.1-.9.3l-4 3c-.662.497-.797 1.437-.3 2.1.498.662 1.437.796 2.1.3L9 9.17l3.1 2.325c.665.496 1.603.362 2.1-.3.497-.663.362-1.603-.3-2.1l-4-3c-.266-.2-.584-.3-.9-.3"></path>
    </svg>
</a>
<script>
    $(function () {
        // スクロールしたらトップに戻るボタンを表示
        const toTopButton = $(".scroll_top");
        const scrollHeight = 300;
        toTopButton.hide();
        $(window).scroll(function () {
            if ($(this).scrollTop() > scrollHeight) {
            toTopButton.fadeIn();
            } else {
            toTopButton.fadeOut();
            }
        });

        // リロードされたときの現在位置が設定位置より下の場合もトップに戻るボタンを表示
        $(document).ready(function() {
            // 画面の高さを取得
            if ($(this).scrollTop() > scrollHeight) {
                toTopButton.fadeIn();
            }
        });

        // トップに戻るボタンをクリックしたらスクロールで戻る
        toTopButton.click(function () {
            $("body, html").animate({ scrollTop: 0 }, 500, 'swing');
            return false;
        });
    });
</script>
<style>
    .scroll_top {
        display: none;
        position: fixed;
        right: 5%;
        bottom: 5%;
        color: #fff;
        padding: 1rem;
        border-radius: 50%;
        display: inline-block;
        text-decoration: none;
    }
    .scroll_top::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: inline-block;
        width: 50px;
        height: 50px;
        background-color: #cccccc;
        border-radius: 50%;
        z-index: -1;
    }
</style>
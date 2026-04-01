function checkNav() {
    // nav.html 還沒插入前，DOM 上找不到 #user_area，先回傳 false 讓外層繼續等待
    var $userArea = $('#user_area');
    if ($userArea.length === 0) return false;

    var role = localStorage.getItem('role'); // 'member' / 'admin'
    var name = localStorage.getItem('name'); // 會員顯示名稱

    // 獲取表單數據
    var formData = {
        token: localStorage.getItem('token')
    };

    // 判斷是否有 token 存在，如果有才執行 AJAX 請求
    if (formData.token) {
        // 發送 AJAX 請求到 api/check.php
        $.ajax({
            url: 'api/check.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (!response.success) {
                    alert(response.message);
                    // 清空 localstorage
                    localStorage.clear();
                    // 轉址 login.html
                    window.location.href = 'login.html';
                }
            },
            error: function () {
                alert('發生錯誤，請稍後再試。'); // AJAX 請求失敗，顯示錯誤訊息
            }
        });
    }

    // 依角色決定下拉選單內容
    if (role === 'member') {
        // 一般會員：顯示姓名 + 登出
        $userArea.html(`
            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">${name || '會員'}</a>
            <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="cart.html">購物車</a>
                <a class="dropdown-item" href="logout.html">登出</a>
            </div>
        `);
    } else if (role === 'admin') {
        // 管理員：顯示後台入口 + 登出
        $userArea.html(`
            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">管理員</a>
            <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="cart.html">購物車</a>
                <a class="dropdown-item" href="admin">後台管理</a>
                <a class="dropdown-item" href="logout.html">登出</a>
            </div>
        `);
    } else {
        // 非登入狀態（或 role 不是預期值）就維持 nav.html 預設的「來賓」內容
        // 這裡不強制覆寫，避免把 nav.html 原本的登入/註冊選單蓋掉
    }

    // 只要 #user_area 存在，就代表渲染條件已具備（後續也不需要再觀察 DOM）
    return true;
}

// jQuery DOM ready：此時頁面主 DOM 讀取完成，但 nav.html 可能仍在非同步載入中
$(function () {
    // 先試一次：若 nav.html 在 DOM ready 前就已插入，直接更新並結束
    // if (checkNav()) return;

    /**
     * 使用 MutationObserver 的目的：
     * - 監聽 DOM 是否有新節點插入（nav.html 載入後會把 #user_area 插進來）
     * - 一旦 #user_area 出現就立刻渲染，然後停止監聽，避免不必要的效能成本
     */
    var observer = new MutationObserver(function () {
        // 每次 DOM 變動就再嘗試一次：成功後就停止監聽
        if (checkNav()) observer.disconnect();
    });

    // 從整個文件根節點開始監聽（subtree: true 代表包含所有子節點）
    observer.observe(document.documentElement, { childList: true, subtree: true });

    // 避免某些頁面沒有載入 nav.html 或載入失敗，導致觀察器一直掛著
    // setTimeout(function () { observer.disconnect(); }, 5000);
});

// 分享功能
function shareFacebook() {
    const url = encodeURIComponent(window.location.href);
    const fbUrl = "https://www.facebook.com/sharer/sharer.php?u=" + url;
    window.open(fbUrl, "_blank", "width=600,height=400");
}

function shareLine() {
    const title = document.title;
    const url = window.location.href;
    const text = encodeURIComponent(title + ' ' + url);
    const lineUrl = "https://line.me/R/share?text=" + text;
    window.open(lineUrl, "_blank");
}
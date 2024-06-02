const apiUrl = "http://127.0.0.1:8000/products";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

async function fetchCsrfToken() {
  const response = await axios.get(csrfUrl, { withCredentials: true });
  csrfToken = response.data.csrfToken;
}
fetchCsrfToken();


// register.js
async function submit() {
    // 取得表單資料
    const username = document.querySelector('input[name="username"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const phone = document.querySelector('input[name="phone"]').value;
    const address = document.querySelector('input[name="address"]').value;
    const isCorporate = document.querySelector('input[name="is_corporate"]').checked;

    // 根據 isCorporate 設定 accountType
    const accountType = isCorporate ? 'Corporate' : 'Individual';

    // 準備資料
    const data = {
        Name: username,
        Email: email,
        PhoneNumber: phone,
        Address: address,
        CustomerType: accountType,
        _token: csrfToken
    };

    try {
        // 發送 POST 請求到伺服器
        const response = await axios.post('http://127.0.0.1:8000/customers', data, { withCredentials: true });
        
        // 處理回應
        if (response.status === 200) {
            alert(`您的顧客ID是${response.data.CustomerID}，請牢記這個數字。\n註冊成功！請登入後使用！`);
            localStorage.setItem('UserID', response.data.CustomerID);
            // 你可以在這裡進行頁面跳轉或其他操作
            window.location.href = '/static pages/customer-home.html';
        } else {
            alert('註冊失敗，請重試。');
        }
    } catch (error) {
        console.error('註冊過程中出現錯誤：', error);
        alert('註冊過程中出現錯誤，請稍後再試。');
    }
}

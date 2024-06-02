const apiUrl = "http://127.0.0.1:8000/customers";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

async function fetchCsrfToken() {
  const response = await axios.get(csrfUrl, { withCredentials: true });
  csrfToken = response.data.csrfToken;
}
fetchCsrfToken();

async function login(){
    const userId = document.getElementById('UserID').value;
    
    try {
        // 發送 Get 請求到伺服器
        const response = await axios.get(`${apiUrl}/${userId}`, { withCredentials: true });
        
        // 處理回應
        if (response.status === 200 && !response.data.length) {
            
            alert(`登入成功，歡迎${response.data.Name}使用系統！`);
            localStorage.setItem('UserID', userId);

            // 你可以在這裡進行頁面跳轉或其他操作
            window.location.href = '/db_final/static pages/customer-home.html';
        } else if (response.status === 404) {
            alert('無此帳號');
        } else {
            alert('登入失敗，請重試。');
        }
    } catch (error) {
        console.error('登入過程中出現錯誤：', error);
        alert('登入過程中出現錯誤，請稍後再試。');
    }
    
}
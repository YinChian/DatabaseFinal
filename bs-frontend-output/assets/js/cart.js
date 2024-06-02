const apiUrl = "http://127.0.0.1:8000";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

async function fetchCsrfToken() {
  const response = await axios.get(csrfUrl, { withCredentials: true });
  csrfToken = response.data.csrfToken;
}

document.addEventListener("DOMContentLoaded", function () {
  fetchCsrfToken();

  // 取得sessionStorage中的ProductID
  const productID = sessionStorage.getItem("BuyProductID");

  // 定義後端API的URL
  const productsApiUrl = `${apiUrl}/products/${productID}`;
  const salesOrdersApiUrl = `${apiUrl}/sales-orders`;

  // 取得產品資訊並更新頁面
  axios
    .get(productsApiUrl)
    .then((response) => {
      const product = response.data;
      document.getElementById("product-name").textContent = product.Name;
      document.getElementById("stock").textContent = product.StockQuantity;
      document.getElementById("price").textContent = Math.floor(product.Price);
    })
    .catch((error) => {
      console.error("Error fetching product data:", error);
    });

  // 定義"前往付款"按鈕的點擊事件
  document.querySelector("#checkout").addEventListener("click", function () {
    fetchCsrfToken();
    const userID = localStorage.getItem("UserID");
    const quantity = document.getElementById("quantity").value;

    if (!quantity || isNaN(quantity) || quantity <= 0) {
      alert("請輸入有效的數量");
      return;
    }

    // 準備訂單資料
    const orderData = {
      customer_id: userID,
      order_details: [
        {
          product_id: productID,
          quantity: quantity,
        },
      ],
      _token: csrfToken,
    };

    // 發送POST請求下訂單
    axios
      .post(salesOrdersApiUrl, orderData, { withCredentials: true })
      .then((response) => {
        alert("訂單已成功送出");
        // 此處可以加入跳轉到其他頁面的邏輯
        sessionStorage.removeItem('BuyProductID');
        sessionStorage.setItem('orderID', response.data.OrderID);
        window.location.href = '/db_final/shopping pages/payment.html';
      })
      .catch((error) => {
        console.error("Error placing order:", error);
        alert(`訂單送出失敗，原因：${error.response.data.error}`);
      });
  });
});

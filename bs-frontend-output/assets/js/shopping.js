const apiUrl = 'http://127.0.0.1:8000/products';
const csrfUrl = 'http://127.0.0.1:8000/csrf-token';
const commentUrl = 'http://127.0.0.1:8000/service-requests';

let csrfToken = '';

async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

fetchCsrfToken();
loadTable();

// 初始化讀取表格資料
async function loadTable() {
    const response = await axios.get(apiUrl, { withCredentials: true });
    const data = response.data;
    const tableBody = document.getElementById('dynamicTable').querySelector('tbody');

    while (tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
    }

    data.forEach(row => {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${row.id}</td>
            <td>${row.Name}</td>
            <td>${row.Description}</td>
            <td>${Math.floor(row.Price)}</td>
            <td>${row.StockQuantity}</td>
            <td>${row.CategoryID}</td>
            <td><button class="btn btn-primary" type="button" onclick="buy(${row.id})">購買</button></td>
            <td><button class="btn btn-secondary" type="button" onclick="comment(${row.id})">留言</button></td>
        `;
        tableBody.appendChild(newRow);
    });
}

async function buy(id) {
    localStorage.setItem('BuyProductID', id);
    window.location.href = "/db_final/shopping pages/cart.html";
}

async function comment(productID) {

    fetchCsrfToken();

    const userID = localStorage.getItem('UserID'); // Assumes UserID is stored in LocalStorage
    if (!userID) {
        alert('User not logged in.');
        return;
    }

    const issueDescription = prompt('請輸入您的留言內容：');
    if (!issueDescription) {
        alert('留言內容不可為空。');
        return;
    }

    try {
        const response = await axios.post(
            commentUrl,
            {
                CustomerID: userID,
                ProductID: productID,
                IssueDescription: issueDescription,
                _token: csrfToken
            },
            {
                headers: {
                    'Content-Type': 'application/json',
                    'CSRF-Token': csrfToken
                },
                withCredentials: true
            }
        );

        if (response.status === 200) {
            alert('留言已成功提交。');
        } else {
            alert('留言提交失敗。');
        }
    } catch (error) {
        console.error('留言提交錯誤：', error);
        alert('留言提交錯誤。');
    }
}
const apiUrl = "http://127.0.0.1:8000";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

// 初始化讀取表格資料
async function loadTable() {
    const response = await axios.get(`${apiUrl}/sales-orders`, { withCredentials: true });
    const data = response.data;
    const tableBody = document.getElementById('shipping-table').querySelector('tbody');

    while (tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
    }

    data.forEach(row => {
        const newRow = document.createElement('tr');
        switch (row.DeliveryStatus) {
            case 'Pending':
                newRow.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.CustomerID}</td>
                    <td>${new Date(row.created_at).toLocaleDateString()}</td>
                    <td>${new Date(row.updated_at).toLocaleDateString()}</td>
                    <td>${row.PaymentStatus}</td>
                    <td>等待寄送中</td>
                    <td><button class="btn btn-primary" type="button" onclick="changeState(${row.id}, 'Shipped', '${row.PaymentStatus}')">變更為已送出</button></td>
                `;
                break;
            case 'Shipped':
                newRow.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.CustomerID}</td>
                    <td>${new Date(row.created_at).toLocaleDateString()}</td>
                    <td>${new Date(row.updated_at).toLocaleDateString()}</td>
                    <td>${row.PaymentStatus}</td>
                    <td>寄送中</td>
                    <td><button class="btn btn-primary" type="button" onclick="changeState(${row.id}, 'Delivered', '${row.PaymentStatus}')">變更為已送達</button></td>
                `;
                break;
            case 'Delivered':
                newRow.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.CustomerID}</td>
                    <td>${new Date(row.created_at).toLocaleDateString()}</td>
                    <td>${new Date(row.updated_at).toLocaleDateString()}</td>
                    <td>${row.PaymentStatus}</td>
                    <td>已送達</td>
                    <td></td>
                `;
                break;
            default:
                alert('發生錯誤');
                return;
        }
        tableBody.appendChild(newRow);
    });
}

async function changeState(orderId, newState, paymentStatus) {
    try {
        const response = await axios.put(`${apiUrl}/sales-orders/${orderId}`, {
            delivery_status: newState,
            payment_status: paymentStatus,
            _token: csrfToken
        }, {
            headers: {
                'X-CSRF-Token': csrfToken
            },
            withCredentials: true
        });

        if (response.status === 200) {
            alert(`成功修改訂單${orderId}的運送狀態為${newState}`);
            loadTable(); // 重新載入表格資料
        } else {
            alert('更新失敗');
        }
    } catch (error) {
        console.error('Error updating order status:', error);
        alert('發生錯誤，請稍後再試');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    fetchCsrfToken();
    loadTable();
});

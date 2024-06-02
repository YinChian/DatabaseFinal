const apiUrl = 'http://127.0.0.1:8000';
const csrfUrl = 'http://127.0.0.1:8000/csrf-token';
let csrfToken = '';

async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

// 初始化讀取表格資料
async function loadTable() {
    const UserID = localStorage.getItem('UserID');
    const response = await axios.get(`${apiUrl}/sales-orders/${UserID}`, { withCredentials: true });
    const data = response.data;
    const tableBody = document.getElementById('shipping-table').querySelector('tbody');

    while (tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
    }
    const rows = await Promise.all(data.map(async (row) => {
        const newRow = document.createElement('tr');
        
        // 获取产品名称
        let product_name = '';
        try {
            const res = await axios.get(`${apiUrl}/products/${row.order_details[0].ProductID}`);
            product_name = res.data.Name;
        } catch (error) {
            console.error('Failed to fetch product name', error);
        }

        newRow.innerHTML = `
            <td>${row.sales_order.id}</td>
            <td>${new Date(row.sales_order.created_at).toLocaleString()}</td>
            <td>${product_name}</td>
            <td>${row.order_details[0].Quantity}</td>
            <td>${new Date(row.sales_order.updated_at).toLocaleString()}</td>
            <td>${row.sales_order.PaymentStatus}</td>
            <td>${row.sales_order.DeliveryStatus}</td>
        `;
        return newRow;
    }));

    // 将所有新行添加到表格中
    rows.forEach(newRow => tableBody.appendChild(newRow));
    
}

document.addEventListener('DOMContentLoaded', function () {
    fetchCsrfToken();
    loadTable();
});
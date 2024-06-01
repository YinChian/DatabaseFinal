const apiUrl = 'http://127.0.0.1:8000/products';
const csrfUrl = 'http://127.0.0.1:8000/csrf-token';
let csrfToken = '';

async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

fetchCsrfToken();

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
            <td><button class="btn btn-primary" type="button" onclick="editRow(this, ${row.id})">購買</button></td>
            <td><button class="btn btn-danger" type="button" onclick="deleteRow(${row.id})">留言</button></td>
        `;
        tableBody.appendChild(newRow);
    });
}

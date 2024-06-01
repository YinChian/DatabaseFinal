const apiUrl = 'http://127.0.0.1:8000/products'; // 替換為你的API URL
const csrfUrl = 'http://127.0.0.1:8000/csrf-token';
let csrfToken = '';

async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

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
            <td><button class="btn btn-primary" type="button" onclick="editRow(this, ${row.id})">修改</button></td>
            <td><button class="btn btn-danger" type="button" onclick="deleteRow(${row.id})">刪除</button></td>
        `;
        tableBody.appendChild(newRow);
    });
}

// 編輯行
async function editRow(button, id) {
    const row = button.closest('tr');
    const cells = row.querySelectorAll('td:not(:nth-last-child(1)):not(:nth-last-child(2))');
    
    if (button.textContent === '修改') {
        cells.forEach((cell, index) => {
            if (index > 0) { // 跳過商品ID欄位
                const input = document.createElement('input');
                input.type = 'text';
                input.value = cell.textContent;
                cell.textContent = '';
                cell.appendChild(input);
            }
        });
        button.textContent = '更新';
    } else {
        const updatedData = {
            id: id,
            Name: cells[1].querySelector('input').value,
            Description: cells[2].querySelector('input').value,
            Price: cells[3].querySelector('input').value,
            StockQuantity: cells[4].querySelector('input').value,
            CategoryID: cells[5].querySelector('input').value,
            _token: csrfToken
        };
        
        await axios.put(`${apiUrl}/${id}`, updatedData, { withCredentials: true });

        cells.forEach((cell, index) => {
            if (index > 0) { // 跳過商品ID欄位
                cell.textContent = cell.querySelector('input').value;
            }
        });
        button.textContent = '修改';
    }
}

// 新增行
function addRow() {
    const table = document.getElementById('dynamicTable').querySelector('tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td></td>
        <td><input type="text" placeholder="輸入商品名稱"></td>
        <td><input type="text" placeholder="輸入商品敘述"></td>
        <td><input type="text" placeholder="輸入單價"></td>
        <td><input type="text" placeholder="輸入庫存量"></td>
        <td><input type="text" placeholder="輸入類別ID"></td>
        <td><button class="btn btn-primary" type="button" onclick="saveNewRow(this)">更新</button></td>
        <td><button class="btn btn-danger" type="button" onclick="deleteNewRow(this)">取消</button></td>
    `;
    table.appendChild(newRow);
}

// 保存新增行
async function saveNewRow(button) {
    const row = button.closest('tr');
    const cells = row.querySelectorAll('td:not(:nth-last-child(1)):not(:nth-last-child(2))');
    const newData = {
        Name: cells[1].querySelector('input').value,
        Description: cells[2].querySelector('input').value,
        Price: cells[3].querySelector('input').value,
        StockQuantity: cells[4].querySelector('input').value,
        CategoryID: cells[5].querySelector('input').value,
        _token: csrfToken
    };
    
    const response = await axios.post(apiUrl, newData, { withCredentials: true });

    // const savedData = response.data;

    // cells[0].textContent = savedData.id;
    // cells.forEach((cell, index) => {
    //     if (index > 0) { // 跳過商品ID欄位
    //         cell.textContent = cell.querySelector('input').value;
    //     }
    // });

    // button.textContent = '修改';
    // button.setAttribute('onclick', `editRow(this, ${savedData.id})`);
    // button.classList.remove('btn-primary');
    // button.classList.add('btn-primary');
    loadTable();
}

// 刪除行
async function deleteRow(id) {
    await axios.delete(`${apiUrl}/${id}`,{ 
        withCredentials: true,
        headers: {
            'X-CSRF-Token': csrfToken
        }
     });
    loadTable(); // 重新載入表格資料
}

// 取消新增行
function deleteNewRow(button) {
    const row = button.closest('tr');
    row.remove();
}

// 載入表格資料
loadTable();
fetchCsrfToken();
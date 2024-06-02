const apiUrl = "http://127.0.0.1:8000";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

async function fetchCsrfToken() {
  const response = await axios.get(csrfUrl, { withCredentials: true });
  csrfToken = response.data.csrfToken;
}

document.addEventListener('DOMContentLoaded', function () {
    fetchCsrfToken();

    
    customerID = localStorage.getItem('UserID');

    // Fetch sales order data from backend and fill in the fields
    axios.get(`${apiUrl}/sales-orders/${customerID}`, {withCredentials: true})
        .then(function (response) {
            const data = response.data;
            if (data && data.length > 0) {
                const order = data[0]; // Assuming there's only one order for simplicity
                
                // let ProductName = '';
                axios.get(`${apiUrl}/products/${order.order_details[0].ProductID}`)
                .then ((response) => {
                    document.getElementById('ProductName').innerText = response.data.Name;
                });
                
                // document.getElementById('ProductName').innerText = ProductName ? ProductName : order.order_details[0].ProductID;
                document.getElementById('Price').innerText = Math.floor(order.order_details[0].Price);
                document.getElementById('Quantity').innerText = Math.floor(order.order_details[0].Quantity);
                document.getElementById('PriceTotal').innerText = Math.floor(order.sales_order.TotalAmount);
            }
        })
        .catch(function (error) {
            console.error('Error fetching sales order data:', error);
        });

    // Handle payment submission
    document.getElementById('Pay').addEventListener('click', function (event) {
        event.preventDefault();
        orderID = sessionStorage.getItem('orderID');
        axios.put(`${apiUrl}/sales-orders/${orderID}`, { payment_status: 'Completed', delivery_status: "Pending", _token: csrfToken }, {withCredentials: true})
            .then(function (response) {
                console.log('Payment completed:', response.data);
                // Optionally, you can redirect the user or show a success message
            })
            .catch(function (error) {
                console.error('Error completing payment:', error);
                // Optionally, you can show an error message to the user
            });
    });
});

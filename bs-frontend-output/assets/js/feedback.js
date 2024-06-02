const apiUrl = "http://127.0.0.1:8000";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

async function fetchCsrfToken() {
  const response = await axios.get(csrfUrl, { withCredentials: true });
  csrfToken = response.data.csrfToken;
}

const fetchServiceRequests = async () => {
    const CustomerID = localStorage.getItem('UserID');
    axios.get(`${apiUrl}/service-requests/${CustomerID}`)
    .then(response => {
        const serviceRequests = response.data;
        const serviceRequestsTableBody = document.querySelector('#service-requests-table tbody');
        serviceRequestsTableBody.innerHTML = '';

        serviceRequests.forEach(request => {
            const row = `
                <tr>
                    <td>${request.id}</td>
                    <td>${request.ProductID}</td>
                    <td>${request.IssueDescription}</td>
                    <td>${request.Status}</td>
                    <td>${request.updated_at ? new Date(request.updated_at).toLocaleString() : 'N/A'}</td>
                    <td>${request.created_at ? new Date(request.created_at).toLocaleString() : 'N/A'}</td>
                </tr>
            `;
            serviceRequestsTableBody.insertAdjacentHTML('beforeend', row);
        });
    })
    .catch(error => console.error('Error fetching service requests:', error));
};

const fetchCustomerInteractions = async () => {
    const CustomerID = localStorage.getItem('UserID');
    axios.get(`${apiUrl}/customer-interactions/${CustomerID}`)
        .then(response => {
            const customerInteractions = response.data;
            const customerInteractionsTableBody = document.querySelector('#customer-interactions-table tbody');
            customerInteractionsTableBody.innerHTML = '';

            customerInteractions.forEach(interaction => {
                const row = `
                    <tr>
                        <td>${interaction.id}</td>
                        <td>${new Date(interaction.Date).toLocaleString()}</td>
                        <td>${interaction.Mode}</td>
                        <td>${interaction.Description}</td>
                        <td>${interaction.created_at ? new Date(interaction.created_at).toLocaleString() : 'N/A'}</td>
                    </tr>
                `;
                customerInteractionsTableBody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(error => console.error('Error fetching customer interactions:', error));
};

document.addEventListener("DOMContentLoaded", function () {
    fetchCsrfToken();
    fetchCustomerInteractions();
    fetchServiceRequests();
});


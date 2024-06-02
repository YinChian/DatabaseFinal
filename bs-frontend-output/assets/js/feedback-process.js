const apiUrl = 'http://127.0.0.1:8000';
const csrfUrl = 'http://127.0.0.1:8000/csrf-token';
let csrfToken = '';

async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

function getFormattedDate(timezone) {
    let date = new Date().toLocaleString("en-CA", { timeZone: timezone, year: 'numeric', month: 'numeric', day: 'numeric' });
    let [year, month, day] = date.split('-');
    return `${year}-${month}-${day}`;
}

let timezone = "Asia/Taipei";

document.addEventListener('DOMContentLoaded', () => {

    fetchCsrfToken();

    const fetchServiceRequests = async () => {
        try {
            const response = await axios.get(`${apiUrl}/service-requests`);
            const serviceRequests = response.data;
            populateServiceRequestTable(serviceRequests);
        } catch (error) {
            console.error('Error fetching service requests:', error);
        }
    };

    const updateServiceRequest = async (id) => {
        try {
            await axios.put(`${apiUrl}/service-requests/${id}`, {
                Status: 'Resolved',
                ResolutionDate: getFormattedDate(timezone),
                _token: csrfToken
            }, {withCredentials: true});
            fetchServiceRequests(); // Refresh the table after update
        } catch (error) {
            console.error('Error updating service request:', error);
        }
    };

    const fetchCustomerInteractions = async () => {
        try {
            const response = await axios.get(`${apiUrl}/customer-interactions`);
            const customerInteractions = response.data;
            populateCustomerInteractionTable(customerInteractions);
        } catch (error) {
            console.error('Error fetching customer interactions:', error);
        }
    };

    const populateServiceRequestTable = (data) => {
        const tableBody = document.querySelector('#service-request-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        data.forEach(request => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${request.id}</td>
                <td>${request.CustomerID}</td>
                <td>${request.ProductID}</td>
                <td>${request.IssueDescription}</td>
                <td>${new Date(request.updated_at).toLocaleString()}</td>
                <td>${new Date(request.created_at).toLocaleString()}</td>
                <td>
                    ${request.Status === 'Pending' ? `<button class="btn btn-primary btn-sm update-status-btn" data-id="${request.id}">標記為已處理</button>` : '已處理'}
                </td>
            `;

            tableBody.appendChild(row);
        });

        document.querySelectorAll('.update-status-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                updateServiceRequest(id);
            });
        });
    };

    const populateCustomerInteractionTable = (data) => {
        const tableBody = document.querySelector('#customer-interaction-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        data.forEach(interaction => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${interaction.id}</td>
                <td>${interaction.CustomerID}</td>
                <td>${interaction.Description}</td>
                <td>${interaction.Mode}</td>
                <td>${new Date(interaction.created_at).toLocaleString()}</td>
            `;

            tableBody.appendChild(row);
        });
    };

    fetchServiceRequests();
    fetchCustomerInteractions();
});

const apiUrl = "http://127.0.0.1:8000/customers";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

// Fetch CSRF token
async function fetchCsrfToken() {
    const response = await axios.get(csrfUrl, { withCredentials: true });
    csrfToken = response.data.csrfToken;
}

document.addEventListener('DOMContentLoaded', () => {
    fetchCsrfToken();
    // Get userID from LocalStorage
    const userID = localStorage.getItem('UserID');
    
    // Define the API endpoint
    const apiEndpoint = `${apiUrl}/${userID}`;
    
    // Check if userID is available
    if (!userID) {
        console.error('No userID found in LocalStorage');
        return;
    }

    // Fetch user data from the backend API
    axios.get(apiEndpoint)
        .then(response => {
            const userData = response.data;

            // Fill the form fields with the retrieved data
            document.querySelector('input[name="username"]').value = userData.Name;
            document.querySelector('input[name="phone"]').value = userData.PhoneNumber;
            document.querySelector('input[name="address"]').value = userData.Address;
            document.querySelector('input[name="email"]').value = userData.Email;

            // Set the checkbox based on the user data
            document.querySelector('input[name="is_corporate"]').checked = userData.CustomerType === 'Corporate';
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            alert(`目前的使用者ID為${userID}，取得帳號資料時出現錯誤，原因：${error.response.data.error}。`);
        });

    // Handle the update button click
    document.getElementById('Confirm').addEventListener('click', () => {
        const updatedData = {
            Name: document.querySelector('input[name="username"]').value,
            PhoneNumber: document.querySelector('input[name="phone"]').value,
            Address: document.querySelector('input[name="address"]').value,
            Email: document.querySelector('input[name="email"]').value,
            CustomerType: document.querySelector('input[name="is_corporate"]').checked ? 'Corporate' : 'Individual',
            _token: csrfToken
        };

        axios.put(apiEndpoint, updatedData, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            withCredentials: true
        })
        .then(response => {
            console.log('User data updated successfully:', response.data);
            alert('資料已成功更新');
        })
        .catch(error => {
            console.error('Error updating user data:', error);
            alert('更新資料時出錯');
        });
    });

    // Handle the delete button click
    document.getElementById('Delete').addEventListener('click', () => {
        if (confirm('您確定要刪除帳號嗎？')) {
            axios.delete(apiEndpoint, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                withCredentials: true
            })
            .then(response => {
                console.log('User data deleted successfully:', response.data);
                alert('帳號已成功刪除');
                // Optionally redirect the user after deletion
                window.location.href = "../static%20pages/index.html";
            })
            .catch(error => {
                console.error('Error deleting user data:', error);
                alert('刪除帳號時出錯');
            });
        }
    });
});

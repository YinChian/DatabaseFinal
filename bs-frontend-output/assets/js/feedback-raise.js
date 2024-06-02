const apiUrl = "http://127.0.0.1:8000";
const csrfUrl = "http://127.0.0.1:8000/csrf-token";
let csrfToken = "";

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

    const sendButton = document.getElementById('send');
    // const methodButton = document.getElementById('method');

    sendButton.addEventListener('click', () => {
        // Get form data
        // const username = document.getElementById('username').value;
        // const date = document.getElementById('date').value;
        // const method = methodButton.textContent.trim();
        // if (!['In-Preson', 'Email', 'Phone'].includes(method)) {
        //     alert('請選擇溝通方式！');
        //     return;
        // }
        const message = document.getElementById('message').value;
        const username = localStorage.getItem('UserID');

        // Prepare data for sending
        const feedbackData = {
            CustomerID: username,
            Date: getFormattedDate(timezone),
            Mode: 'Email',
            Description: message,
            _token: csrfToken
        };

        // Send data using axios
        axios.post(`${apiUrl}/customer-interactions`, feedbackData, {withCredentials:true})
            .then(response => {
                console.log('Feedback sent successfully:', response.data);
                alert('紀錄成功！');
                window.location.href = '/db_final/feedback pages/feedback.html';
            })
            .catch(error => {
                console.error('Error sending feedback:', error);
                alert(`紀錄時發生錯誤，原因：${error.response.data.error}`);
            });
    });

    // // Handle dropdown selection
    // document.querySelectorAll('.dropdown-item').forEach(item => {
    //     item.addEventListener('click', (event) => {
    //         event.preventDefault();
    //         const selectedMethod = event.target.getAttribute('data-value');
    //         methodButton.textContent = selectedMethod;
    //     });
    // });
});

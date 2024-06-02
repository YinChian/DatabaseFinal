const welcome = document.getElementById("welcome-text");
// const username = localStorage.getItem("Username");
// welcome.innerHTML = username ? `您好 ${username}！` : "歡迎使用 顧客頁面！";

const userID = localStorage.getItem("UserID");

let config = {
  method: "get",
  url: `http://127.0.0.1:8000/customers/${userID}`,
};
document.addEventListener('DOMContentLoaded', () => {
    axios
    .request(config)
    .then((response) => {
      let username = response.data.Name;
      welcome.innerHTML = username ? `您好 ${username}！` : "歡迎使用 顧客頁面！";
    })
    .catch((error) => {
      console.log(error);
    });
  
})


const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click', function(){
    const userBox = document.querySelector('.profile');
    userBox.classList.toggle('active');
});

const toggle = document.querySelector('#menu-btn');
toggle.addEventListener('click', function(){
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('active');
})

let searchForm = document.querySelector('.search-form');
document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    userBox.classList.remove('active');
}


        document.getElementById("loginForm").addEventListener("submit", function(event) {
            // Prevent the default form submission
            event.preventDefault();
            
            // Delay the redirection after 2 seconds
            setTimeout(function() {
                document.getElementById("loginForm").submit();
            }, 2000); // 2000 milliseconds = 2 seconds
        });



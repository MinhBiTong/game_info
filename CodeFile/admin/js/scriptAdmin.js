// script.js
document.addEventListener('DOMContentLoaded', (event) => {
    const password = document.getElementById('password');
    const showPassword = document.getElementById('showpassword');

    showPassword.addEventListener('change', function (event) {
        const type = this.checked ? 'text' : 'password';
        password.setAttribute('type', type);
    });
});

const navItems = document.querySelectorAll(".nav-item");

// navItems.forEach((navItem, i) => {
//   navItem.addEventListener("click", () => {
//     navItems.forEach((item, j) => {
//       item.className = "nav-item";
//     });
//     navItem.className = "nav-item active";
//   }); 
// });
function updateActiveNavItem() {
  const navItems = document.querySelectorAll('.nav-item a');
  const currentPath = window.location.pathname;
  
  navItems.forEach(navItem => {
      const itemPath = navItem.getAttribute('href').split('/').pop(); 
      if (currentPath.endsWith(itemPath)) {
          navItem.parentElement.classList.add('active');
      } else {
          navItem.parentElement.classList.remove('active');
      }
  });
}

document.addEventListener('DOMContentLoaded', updateActiveNavItem);

setTimeout(function() {
    var alert = document.getElementById('error-alert');
    if (alert) {
        alert.style.display = 'none';
    }
}, 7000); 

function previewImage(input){
    var reader = new FileReader();
    reader.onload = function(e) {
        var imagePreview = document.getElementById('image-preview');
        var currentImage = document.getElementById('current-image');
        imagePreview.innerHTML = '<img src="' + e.target.result + '" class="image" style="width: 150px; height: 150px">';
        currentImage.src.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}

document.getElementById('image').addEventListener('change', function() {
    previewImage(this);
});

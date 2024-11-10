// const menuLi = document.querySelectorAll('.admin-slidebar-content > ul > li > a');

// for(let index = 0; index < menuLi.length; index++){
//     menuLi[index].addEventListener('click', (e) => {
//         e.preventDefault();
//         menuLi[index].parentNode.querySelector('ul').classList.toggle('active');
//     });
// }

mapboxgl.accessToken = 'pk.eyJ1IjoibWluaGQxNTY4IiwiYSI6ImNseTJvY2s5bTE1bm8ybXB6dWF3NXJmOXEifQ.2F2k3yPTHEC_CjAJ5y4Jzw';
navigator.geolocation.getCurrentPosition(thanhCongViTri, loiViTri, {
    enableHighAccuracy: true
});

let map;
let directions;

function thanhCongViTri(position) {
    console.log(position);
    const userLocation = [position.coords.longitude, position.coords.latitude];
    caiDatBanDo(userLocation);

    // Thiết lập điểm A là vị trí hiện tại
    directions.setOrigin(userLocation);
}

function loiViTri() {
    caiDatBanDo([-2.24, 53.48]);
}

function caiDatBanDo(center) {
    map = new mapboxgl.Map({
        container: 'map',
        center: center,
        zoom: 12
    });

    const nav = new mapboxgl.NavigationControl();
    map.addControl(nav);

    directions = new MapboxDirections({
        accessToken: mapboxgl.accessToken,
    });
    map.addControl(directions, 'top-left');

    document.querySelectorAll('.table td[data-lat][data-lng]').forEach(cell => {
        cell.addEventListener('click', () => {
            const lat = parseFloat(cell.getAttribute('data-lat'));
            const lng = parseFloat(cell.getAttribute('data-lng'));
            directions.setDestination([lng, lat]);
        });
    });
}
$(document).ready(function () {
  $("#send").submit(function (event) {
    var name = $("#name").val().trim();
    var email = $("#email").val().trim();
    var address = $("#address").val().trim();
    var phone = $("#phone").val().trim();
    var phoneRegex = /^[0-9]{10,15}$/;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (name === "" || email === "" || address === "" || phone === "") {
      alert(" fields are required.");
      event.preventDefault();
      return false;
    }
    if (!emailRegex.test(email)) {
      alert("Invalid email format.");
      event.preventDefault();
      return false;
    }
    if (!phoneRegex.test(phone)) {
      alert("Invalid phone number format.");
      event.preventDefault();
      return false;
    }
    return true;
  });
});
setTimeout(function() {
  var alert = document.getElementById('error-alert');
  if (alert) {
      alert.style.display = 'none';
  }
}, 7000); 


const slide = document.querySelector('.slide');
const thumbnails = document.querySelectorAll('.thumbnail');
let currentIndex =
thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', () => {
        currentIndex = index;
        updateSlider();
    });

function updateSlider() {
    slide.style.transform = `translateX(-${currentIndex * 1000}px)`;
    thumbnails.forEach(thumbnail => thumbnail.classList.remove('active'));
    thumbnails[currentIndex].classList.add('active');

updateSlider();
}
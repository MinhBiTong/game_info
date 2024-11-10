<?php

?>

<?
// $count_my_page = ("index.php");
// $hits = file($count_my_page);
// $hits[0]++;
// $fp = fopen($count_my_page, "w");
// fputs($fp, "$hits[0]");
// fclose($fp);
// $sno = $hits[0];
// echo $sno;
?>
<?php
require_once('./includes/dataAccess.php');
require_once('./includes/utils.php');
include_once('includes/header.php');
// error_reporting(0);


if (strlen($_SESSION['login'] == 0)) {
    header('location:logout.php');
    // Nut log out
    if (isset($_POST['logout'])) {
        if ($_COOKIE['login']) {
            setcookie('login', true, time(), 3600, '/');
        }
        if ($_SESSION['login']) {
            unset($_SESSION['login']);
            session_destroy();
        }
    }
}
?>

<head>
    <style>
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 1960px;
            height: 760px;
            background: #f5f5f5;
            box-shadow: 0 30px 50px #dbdbdb;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 30px 50px #505050;
        }

        .container .slide {
            display: flex;
            position: relative;
            transition: transform 0.5s ease-in-out;
            width: 300%;
            /* min-width: 1000px; */
            min-height: 100%;
            object-fit: cover;
        }

        .container .slide .item {
            /* width: 100%; */
            flex: 1 0 100%;
            top: 50%;
            position: relative;
            transform: translate(0, -50%);
            border-radius: 20px;
            background-position: 50% 50%;
            background-size: cover;
            display: inline-block;
            transition: 0.5s;
            height: 100%;
            flex-shrink: 0;
            background-position: center;
            /* position: relative; */
            border-radius: 20px;
            overflow: hidden;
            object-fit: cover;
        }

        .container .slide .item img {
            /* min-width: 100%; */
            width: 300%;
            height: 100%;
            object-fit: cover;
        }

        .img-fluid{
            width: 100%;
            height: auto;
        }

        .content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            border-radius: 10px;
            flex: 1;
        }

        .name-game {
            font-size: 36px;
            font-weight: bold;
        }

        .des-game {
            font-size: 22px;
            margin-top: 5px;
        }

        button {
            margin-top: 10px;
            padding: 10px 15px;
            background: #fff;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #e0e0e0;
        }

        .thumbnails {
            position: absolute;
            bottom: 20%;
            left: 85%;
            transform: translateX(-50%);
            display: flex;
        }

        .thumbnail {
            width: 150px;
            height: 250px;
            margin: 0 5px;
            background-position: center;
            background-size: cover;
            border: 2px solid #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .thumbnail:hover {
            transform: scale(1.3);
            border-color: palevioletred;
        }

        .thumbnail.rotate {
            animation: spin 1.2s linear infinite; /* Xoay vòng trong 1 giây */
        }

        .active {
            border-color: palevioletred;
        }

        .thumbnail.active {
            border-color: palevioletred;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="slide ">
            <div class="item d-flex justify-content-between">
                <img class="img-fluid" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYEVKm7nW5NfDNyly9jzzrZsx_KBQF8wrKfg&s" alt="Game Chess">
                <div class="content">
                    <div class="name-game">Game Chess</div>
                    <div class="des-game">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, vel totam asperiores deleniti cumque consequatur non. Perferendis blanditiis repellat iste. Explicabo aut iusto alias debitis enim soluta quia sunt cum.</div>
                    <button>See More</button>
                </div>
            </div>
            <div class="item d-flex justify-content-between">
                <img class="img-fluid" src="https://i.pinimg.com/474x/f9/be/55/f9be55279f05e1923f1246a0d61ac1bb.jpg" alt="Game Tic Tac Toe">
                <div class="content">
                    <div class="name-game">Game Tic Tac Toe</div>
                    <div class="des-game">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, vel totam asperiores deleniti cumque consequatur non. Perferendis blanditiis repellat iste. Explicabo aut iusto alias debitis enim soluta quia sunt cum.</div>
                    <button>See More</button>
                </div>
            </div>
            <div class="item d-flex justify-content-between">
                <img class="img-fluid" src="https://cdn.tgdd.vn/Files/2021/02/24/1330068/tong-hop-15-phim-hoat-hinh-3d-trung-quoc-hay-nhat-moi-thoi-dai-202102241106370379.jpg" alt="Game Tic Tac Toe">
                <div class="content">
                    <div class="name-game">Game Tug of War</div>
                    <div class="des-game">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, vel totam asperiores deleniti cumque consequatur non. Perferendis blanditiis repellat iste. Explicabo aut iusto alias debitis enim soluta quia sunt cum.</div>
                    <button>See More</button>
                </div>
            </div>
        </div>
        <div class="thumbnails">
            <div class="thumbnail" data-index="0" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYEVKm7nW5NfDNyly9jzzrZsx_KBQF8wrKfg&s');"></div>
            <div class="thumbnail" data-index="1" style="background-image: url('https://i.pinimg.com/474x/f9/be/55/f9be55279f05e1923f1246a0d61ac1bb.jpg');"></div>
            <div class="thumbnail" data-index="2" style="background-image: url('https://cdn.tgdd.vn/Files/2021/02/24/1330068/tong-hop-15-phim-hoat-hinh-3d-trung-quoc-hay-nhat-moi-thoi-dai-202102241106370379.jpg');"></div>
        </div>
    </div>
    <script>
        const slide = document.querySelector('.slide');
        const thumbnails = document.querySelectorAll('.thumbnail');
        let currentIndex = 0;

        thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', () => {
                currentIndex = index;
                updateSlider();
                thumbnails.forEach((thumb) => thumb.classList.remove('rotate')); // Xóa lớp `rotate` từ các thumbnails khác
                thumbnail.classList.add('rotate'); // Thêm lớp `rotate` cho thumbnail được click

                // Xóa lớp `rotate` sau 1 giây để hiệu ứng có thể được lặp lại khi click lại
                setTimeout(() => {
                    thumbnail.classList.remove('rotate');
                }, 1000);
            });
        });

        function updateSlider() {
            slide.style.transform = `translateX(-${currentIndex * 100}%)`;
            thumbnails.forEach(thumbnail => thumbnail.classList.remove('active'));
            thumbnails[currentIndex].classList.add('active');
        }

        updateSlider();
    </script>
</body>
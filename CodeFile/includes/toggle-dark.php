<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 25px;
            background-color: white;
            color: black;
            font-size: 25px;
        }
       .dark-mode {
            background-color: #333;
            color: #fff;
        }
        .dark-mode p {
            color: #ccc;
        }
    </style>
</head>
<body>
    <button onclick="myFunction()">Toggle</button>
    <script>
        function myFunction() {
            var element = document.body;
            element.classList.toggle("dark-mode");
            // var x = document.getElementById("myDiv");
            // if (x.style.display === "none") {
            //     x.style.display = "block";
            // } else {
            //     x.style.display = "none";
            // }
        }
    </script>
</body>
</html>
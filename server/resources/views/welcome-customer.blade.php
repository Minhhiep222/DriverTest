<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome To Laithu.com</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Xin chào {{ $data['fullname'] }}!</h3>
        <p>Chào mừng bạn đến với showroom {{ $showroom['fullname'] }} của chúng tôi</p>
        <p>Hiện tại bạn đã trở thành khách hàng thân thiết của chúng tôi</p>
        <p>Liên hệ tổng đài zalo: {{ $showroom['phone'] }} hoặc email {{ $showroom['email'] }} nếu cần được hỗ trợ</p>
    </div>
</body>

</html>

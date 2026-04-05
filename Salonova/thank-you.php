<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You - Salonova</title>
  <link rel="icon" href="images/logo.png" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #f5f5f5, #ffd70050);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #333;
    }

    .thank-you-container {
      text-align: center;
      background-color: #fff;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      animation: fadeIn 1s ease-in-out;
    }

    h1 {
      font-size: 2.5rem;
      color: #28a745;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.2rem;
      color: #555;
      margin-bottom: 30px;
    }

    .home-btn {
      display: inline-block;
      padding: 12px 25px;
      background-color: #ffc107;
      color: #000;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .home-btn:hover {
      background-color: #ffca28;
      transform: scale(1.05);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="thank-you-container">
    <h1> Thank You!</h1>
    <p>Your order has been placed successfully.<br>We appreciate your trust in <strong>Salonova</strong>.</p>
    <a href="index.php" class="home-btn">Back to Home</a>
  </div>

</body>
</html>

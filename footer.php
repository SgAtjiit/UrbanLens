<!DOCTYPE html>
<html lang="en">
<head>
  <title>Footer Design</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      line-height: 1.5;
    }

    .container1 {
      max-width: 1170px;
      margin: auto;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
    }

    ul {
      list-style: none;
    }

    .footer {
    margin-top: 40px;
    background-color: #24262b;
    padding: 70px 0;
    color: #ffffff;
    }

    .footer-col {
      width: 25%;
      padding: 0 15px;
    }

    .footer-col h4 {
      font-size: 18px;
      text-transform: capitalize;
      margin-bottom: 35px;
      font-weight: 500;
      position: relative;
    }

    .footer-col h4::before {
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      width: 50px;
      height: 2px;
      background-color: #e91e63;
    }

    .footer-col ul li {
      margin-bottom: 10px;
    }

    .footer-col ul li a {
      color: #bbbbbb;
      text-decoration: none;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .footer-col ul li a:hover {
      color: #ffffff;
      padding-left: 8px;
    }

    .social-links a {
      display: inline-block;
      width: 40px;
      height: 40px;
      margin: 0 10px 10px 0;
      line-height: 40px;
      text-align: center;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.2);
      color: #ffffff;
      transition: all 0.5s ease;
    }

    .social-links a:hover {
      background-color: #ffffff;
      color: #24262b;
    }
    @media (max-width: 767px) {
      .footer-col {
        width: 50%;
        margin-bottom: 30px;
      }
    }

    @media (max-width: 574px) {
      .footer-col {
        width: 100%;
      }
    }

    .header .logo {
            display: flex;
            align-items: center;
            color: #333;
        }

        .header .logo i {
            font-size: 28px;
            margin-right: 10px;
        }

        .header .logo span {
            font-size: 22px;
            font-weight: bold;
        }
  </style>
</head>
<body>
  <footer class="footer">
    <div class="container1">
      <div class="row">
        <div class="footer-col">
          <div class="logo">
                <h4><i class="fas fa-home"></i>        <label style="padding-top: 1px;">Urban Lens</label></h4>
            </div>
          <ul>
          <li><a href="#">home</a></li>
            <li><a href="#">about us</a></li>
            <li><a href="#">privacy policy</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>get help</h4>
          <ul>
            <li><a href="#">FAQ</a></li>           
            <li><a href="#">payment options</a></li>
            <li><a href="#">our services</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>shop</h4>
          <ul>
            <li><a href="#">graffiti</a></li>
            <li><a href="#">abstract</a></li>
            <li><a href="#">nature</a></li>
            <li><a href="#">street art</a></li>
            <li><a href="#">artitecture</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>follow us</h4>
          <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
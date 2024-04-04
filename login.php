<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style1.css" rel="Stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Login</title>
    <style>
h1{
    text-align: center;
    font-size: 25px;
    color: #333;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: 1px;
}
.body1 {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: linear-gradient(to bottom, #ffffff, #f5f5f5,  #f5f5f5); 
}
    .box {
        background-color: #ffffff;
        padding: 25px; 
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); 
        text-align: center; 
        width: 25%;
        max-width: 400px; 
        height: auto; 
        border-radius: 15px;
        margin:0; 
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-style: groove;
    }

h1 {
    padding-top: 5px;
    padding-bottom: 2px;
    color: black; 
    text-align: center;
}

 .input-label {
    position: relative;
    display: flex;
    align-items: center;
}

.input-label .login__icon {
    position: absolute;
    left: 10px;
    top: 46%;
    font-size: 20px;
    transform: translateY(-50%);
    color: black;
    z-index: 1;
}
.input-label input[type="text"]::placeholder,
.input-label input[type="password"]::placeholder {
    font-size: 21px; 
    line-height: 45px; 
    vertical-align: middle; 
}

.input-label input[type="text"],
.input-label input[type="password"] {
    padding-left: 36px; 
    width: 100%;
    line-height: 1.6;
    color: rgb(0, 0, 0);
    font-size: 18px;
    font-weight: 400;
    height: 45px;
    transition: all .2s ease;
    box-shadow: inset #abacaf 0 0 0 2px;
    border: 0;
    background: rgba(0, 0, 0, 0);
    appearance: none;
    border-radius: 3px;
    margin-top: 0; 
    margin-bottom: 2px;
}

.input-label input[type="text"]:hover,
.input-label input[type="password"]:hover {
    box-shadow: 0 0 0 0 #fff inset, #007bff 0 0 0 3px;
    position: relative;
}

.input-label input[type="text"]:focus,
.input-label input[type="password"]:focus {
    background: #fff;
    outline: 0;
    box-shadow: 0 0 0 0 #fff inset, #007bff 0 0 0 4px;
}

.password-toggle-icon {
    position: absolute;
    right: 10px; 
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 1;
    font-size: 20px; 
}

.forgot-password {
    text-align: left;
    margin-top: 5px; 
}

.forgot-password a {
    color: #008CBA; 
    text-decoration: none; 
    transition: color 0.3s; 
}

.forgot-password a:hover {
    color: red;
}

button {
    border: none; 
    margin-top: 1px;  
    width: 100%;
    height: 50px; 
    background-color:  #2E8B57 ; 
    color: white; 
    font-size: 20px;
    border-radius: 5px;
    cursor: pointer;
    transition-duration: 0.4s;
}

button:hover {
    background-color: #228B22 ;
}
.header-image {
    background-image: url(images/logos.png);
    border-top-left-radius: 9px;
    border-top-right-radius: 9px;
    background-size: 100%;
    border-style: groove;

    background-repeat: no-repeat;
    text-align: center;
    width: 100%; 
    margin: 0; 
    display: flex;
    background-position: center;
    height: 205px;
    box-sizing: border-box;
}
@media only screen and (max-width: 600px) {
    .box {
        width: 90%;
    }
}
  </style>
</head>
<body class="body1">
   <div class="box">
    <div class ="header-image">
</div>
    <h1>Registry of Barangay Inhabitants</h1> <!--dipende pa kung anong ilalagay-->
    <form action="process_login.php" method="post">
  
    <label class="input-label">
    <span class="login__icon fas fa-user"></span>
    <input type="text" name="username" placeholder="Username" required>
</label>
<br>

<label class="input-label">
    <span class="login__icon fas fa-key"></span>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <span class="password-toggle-icon"><i class="fas fa-eye-slash"></i></span>
</label>

<script>
const passwordField = document.getElementById("password");
const togglePassword = document.querySelector(".password-toggle-icon i");

togglePassword.addEventListener("click", function () {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    }
});
 </script>

<div class="forgot-password">
    <a href="forgot-pass.php"  draggable="false">Forgot Password?</a>
</div><br>
            <button type="submit">Login</button>
    </form>
</div>
</body>
</html> 


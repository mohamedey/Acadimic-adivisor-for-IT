<!DOCTYPE html>
<head>
<title>Academic Advisor MU</title>
<link  rel="icon" href="img/mu_logo.jpg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="script.js"></script>

<link rel="stylesheet" href="Style.css">  
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
 body {
  background-color: #fffffe;
  font-family: Arial;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 90vh; 
}

a{
  text-decoration: none;
}
h2 {
  color: #094067;
  font-size: 2em;
  margin-top: 100px;
  text-align: center;
  font-family: 'Gill Sans Ultra Bold';
  text-transform: uppercase;
}

.but {
  background-color: #094067;
  color: #fffffe;
  padding: 20px 30px;
  font-size: 1.4em;
  margin: 40px 0; 
  border-radius: 13px;
  width: 250px;
  display: block;
  margin-left: auto;
  margin-right: auto; 
  box-shadow: 0 5px 9px black;
}
.but:hover{
  background-color: #3d85c6;
  transition: .5s;
  
}

.vi{
  font-size: 1.3em;
}
#button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  color: #fffffe;
  background: #ef4565;
  padding: 20px 30px;
  font-size: 1.4em;
  margin: 40px 0; 
  border-radius: 13px;
  width: 250px;
  display: block;
  margin-left: auto;
  margin-right: auto; 
  box-shadow: 0 5px 9px black;
}
#button1::after{
    content: " ";
    display: block;
    height: 4px;
    width: 100%;
    transform: scale(0);
    transform-origin: left;
  }
  #button1:hover{
    border: #ef4565 1px solid;
    border-radius: 2px;
    color: #ef4565;
    transition: .4s;
    box-shadow: black 3px 4px 7px;
  }
  #button1:hover::after{
    transform: scale(1);
    background-color: #ef4565;
    transition: .5s;
  }



</style>
</head>

<body>


<div class="container">

        <h2 class="animate__animated animate__fadeInDownBig "><b>Academic Adviser Menu</b></h2>
        
          <button  class="but animate__animated animate__backInRight " onclick="location.href='plane tree.php'" >Plan Tree</button>
          <button  class="but vi animate__animated animate__backInLeft" onclick="location.href='remaining courses.php'">Remaining Courses</button>
          <button  class="but vi animate__animated animate__backInRight" onclick="location.href='view courses.php'">View your Courses</button>
          <button  class="but vi animate__animated animate__backInLeft" onclick="location.href='suggestion page.php'">Suggestions page</button>

          <button class="animate__animated animate__backInRight"  id="button" onclick="location.href='login.php'">Logout</button>
</div>



<script>
      
      let mybutton = document.getElementById("myBtn");
      window.onscroll = function () {
          scrollFunction();
      };
      function scrollFunction() {
          if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
      }
      mybutton.onclick = function scroll() {
          window.scroll({
              left: 0,
              top: 0,
              behavior: 'smooth'
          });
      };
      
      
      
      
          </script>
         

</body>
</html>








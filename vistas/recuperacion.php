<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="../cssDiseño/Diseno.css">
  <title>Document</title>
</head> 
<body class="text-center bodyalternativo">
    
<main class="form-signin w-100 m-auto">
  <form action="../ajax/recuperacion.php" method="POST">
    <h1>RECUPERACION</h1>
    <h2 class="h3 mb-3 fw-normal">Por favor, ingrese su cedula</h2>
    <div class="form-floating my-3">
      <input type="number" class="form-control" id="floatingInput" placeholder="name@example.com" name="cedula1">
      <label for="floatingInput">Cedula</label>
    </div>
    <button class="w-100 btn btn-lg btn-primaryR" type="submit">Recuperar contraseña</button>
  </form>
</main>


    
  </body>
</html>
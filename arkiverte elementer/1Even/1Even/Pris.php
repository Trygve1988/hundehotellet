<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet.css">
    <script src="JavaScript.JS" defer></script>
    <title>Home</title>
</head>
<body>

<div class="navbar">
    <a href="Index.html"> <img  class="logo" src="logo.png"> Bø Hundehotell </a>
    <a href="Index.html">Hjem</a>
    <a href="Aktuelt.html">Aktuelt</a>
    <a href="Om Oss.html">Om Oss</a>
    <a href="Pris.php">Pris</a>
    <a href="Kontakt Oss.html">Kontakt Oss</a>
    <a href="Opphold.html">Opphold</a>
    <a href="Admin.html">Anmeldelser</a>
    <a href="Anmelderlser.html">Admin</a>
    <a href="Log Inn.html" class="right">Log inn</a>
    <a href="Min side.html" class="right">Min Side</a>
  </div>
  
  <div>
    <label>Fra dato</label>
    <input type="date" value="<?php echo date('Y-m-d');?>" id="fraDato"/>
    
    <label>Til dato</label>
    <input type="date" id="tilDato" tilDato()>
    
  </div>

</body>
</html>
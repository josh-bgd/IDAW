<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Titre PHP</h1>
    <?php 
        $date =  date('h:i:s');
        echo "il est : $date";
        echo " le type de l'heure est : ";
        echo gettype($date);
        echo " <br>";
        echo " <br>";

        function bonjour($prenom){
            echo 'Bonjour ' .$prenom. '<br>';
        }
        function factorial($n){
            $fact = 1;
            for ($i=1; $i<=$n; $i++){
                $fact*=$i;
            }
            return $fact;
        }
        
        $fact_5= factorial(5);
        echo "le factoriel de 5 est $fact_5 <br>";
        bonjour('Josua');
    ?>
</body>
</html>
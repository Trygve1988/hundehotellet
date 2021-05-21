<?php
include_once "include/funksjoner.php";
session_start();
$dblink = kobleOpp();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bø Hundehotell</title>
    <link href="include/style.css" rel="stylesheet" type="text/css">
    <!--Gratis - Henter opp ikonet fra fontawesome sitt bibliotek-->
    <script src="https://kit.fontawesome.com/f4f0ae0c65.js" crossorigin="anonymous"></script>
    <script src="include/script.js" defer> </script>
</head>


<!-- ************************** fellesTop ************************** -->
<?php visNav(); ?>
<?php visNav3() ?>

<!-- ************************** main **************************-->
<main>


    <!-- erAnsatt sjekk -->
    <?php /*if (!erAnsatt()) {
        header('Location: loggInn.php');
    } */ ?>

    <!-- 2a admin -->
    <div class="hvitBakgrunn">
        <!--Må endre til div siden form dyttet tabellene under den gråbakgrunnen -->
        <form class="skjemaBakgrunn">

            <!-- Droplist hund (samkjørt med CSS koden til Gunn Ingers skjemaer) -->
            <h2 class="hovedOverskrift">Hund</h2>
            <div class="hunder">
                <!-- Kræsjer med form skjemaBakgrunn
                <form action="/action_page.php"> -->
                    <label for="hunder">Velg hund:</label>
                    <select>
                        <option value="hund1">Balder </option>
                        <option value="hund2">Trofast </option>
                        <option value="hund3">Fifi </option>
                        <option value="hund4">Bella </option>
                    </select>
              <!--  </form> -->
            </div>

            <!-- Tabell 1 -->
            <h2 class="hovedOverskrift">Info</h2>
            <table class="opphold ">
                <thead>

                    <tr>
                        <th>Gått Tur ID</th>
                        <th>Start tidspunkt</th>
                        <th>Slutt tidspunkt</th>
                        <th>Opphold ID</th>
                        <th>Bruker ID</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>

                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>

                </tbody>
            </table>


            <!-- Tabell 2 -->
            <h2 class="hovedOverskrift">Opphold info</h2>
            <table class="opphold oppholdInfo">
                <thead>

                    <tr>
                        <th>Gått Tur ID</th>
                        <th>Start tidspunkt</th>
                        <th>Slutt tidspunkt</th>
                        <th>Opphold ID</th>
                        <th>Bruker ID</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>


                    </tr>

                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>

                </tbody>
            </table>


            <!-- Tabell 3 -->
            <h2 class="hovedOverskrift">Aktiviteter</h2>
            <table class="opphold aktiviteter">
                <thead>

                    <tr>
                        <th>Gått Tur ID</th>
                        <th>Start tidspunkt</th>
                        <th>Slutt tidspunkt</th>
                        <th>Opphold ID</th>
                        <th>Bruker ID</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>

                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                    </tr>

                </tbody>
            </table>
</form>

    </div>

</main>

<!-- ************************** fellesBunn **************************-->
<?php visFooter(); ?>
<?php visToppKnapp(); ?>

</body>

</html>
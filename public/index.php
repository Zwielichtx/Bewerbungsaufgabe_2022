<?php
        $messages =[];

        $firstnameErr = $lastnameErr = $emailErr = $messageErr = $dsgvoErr = '';
        $firstname = $lastname = $email = $message = $dsgvo = '';

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // PHP - Validation -----------------------------------------------------------------------------------------
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(empty($_POST['email'])){
                $emailErr = '<div class="errormessage">Bitte tragen Sie eine E-Mail Adresse ein.</div>';
            } else{
                $email = test_input($_POST['email']);
            }

            if(empty($_POST['message'])){
                $messageErr = '<div class="errormessage">Bitte fügen Sie eine Nachricht hinzu.</div>';
            } else{
                $message = test_input($_POST['message']);
            }

            if(empty($_POST['dsgvo'])){
                $dsgvoErr = '<div class="errormessage">Sie haben der Datenschutzverordnung nicht zugestimmt</div>';
            } else{
                $dsgvo = test_input($_POST['dsgvo']);
            }
        }

        // PHP - keeping previous data in messages.txt -----------------------------------------------------------------------
        if(file_exists('messages.txt')){
            $text = file_get_contents('messages.txt', true);
            $messages = json_decode($text);
        }

        // PHP - summarizing data in an array  +  adding new data to messages.txt --------------------------------------------

        // Anmerkung - FILTER_VALIDATE_EMAIL:
        // Aus meinen Recherchen war zu entnehmen, dass dieser Filter Regex direkt integriert hat und es generell sinnvoller ist
        // diesen anstatt einer eigenen Regex-Funktion zu nutzen, da eine eigene in den meisten Fällen nicht tiefgreifend genug ist.
        if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && $_POST['email'] !='' && isset($_POST['message']) && $_POST['message'] !='' && $_POST['dsgvo'] !=''){
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $newMessage = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'message' => $_POST['message']
            ];
            array_push($messages, $newMessage);
            file_put_contents('messages.txt', json_encode($messages, JSON_PRETTY_PRINT));
            }
        }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bewerbungsaufgabe Kontaktformular</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Contact Form-Container =========================================================================================-->
    <section class="container mt-5" id="contactForm">
        <form method="post">
            <!-- Container: Header ---------------------------------------------------------------->
            <div class="container mt-5"><h1 class="heading">Kontaktformular</h1></div>
            <!-- Container: Body ------------------------------------------------------------------>
            <div class="row g-3">
                <!-- last name -->
                <div class="col-md-6">
                    <label class="col-2 col-form-label" for="lastname">Name:</label>
                    <div class="col">
                        <input type="text" name="lastname" id="lastname" placeholder="Name" class="form-control">
                    </div>
                </div>

                <!-- first name -->
                <div class="col-md-6">
                    <label class="col-2 col-form-label" for="firstname">Vorname:</label>
                    <div class="col">
                        <input type="text" name="firstname" id="firstname" placeholder="Vorname" class="form-control">
                    </div>
                </div>

                <!-- email -->
                <div class="col-md-8">
                    <label class="col-2 col-form-label"for="email">E-Mail:</label>
                    <div class="col">
                        <input type="email" name="email" id="email" placeholder="E-Mail" class="form-control">
                        <span class="error"><?php echo $emailErr;?></span>
                    </div>
                </div>

                <!-- message -->
                <div class="col-md-12">
                    <label class="col-2 col-form-label"for="message">Nachricht:</label>
                    <div class="col">
                        <textarea type="textarea" name="message" id="message" placeholder="Ihre Nachricht" class="form-control" rows="3"></textarea>
                        <span class="error"><?php echo $messageErr;?></span>
                    </div>
                </div>

                <!-- DSGVO -->
                <div class="mb-3 form-check" id="dsgvocss">
                    <input type="checkbox" name="dsgvo" id="dsgvo" class="form-check-input">
                    <span class="error"><?php echo $dsgvoErr;?></span>
                    <label class="form-check-label">Hiermit bestätige ich, dass ich die <a href="index.php?page=datenschutz">Datenschutzerklärung</a> (gemäß DSGVO) gelesen habe und mit dieser einverstanden bin.</label>
                </div>
            </div>

            <!-- Container: Footer ---------------------------------------------------------------->
                <!-- submit -->
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary">Absenden</button>
                </div>
        </form>
    </section>

<!-- PHP - DSGVO - details -->
<?php
        if(isset($_GET['page'])) {
            $page = $_GET ['page'] == 'datenschutz';
            echo "
                <section class='container'>
                    <div class='col-md-6'><h2 class='heading'>Datenschutzerklärung</h2></div>
                    <div class='col-md-12'><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae vel dolores veritatis, sed nulla vitae expedita a in. Dolorum, sit consequatur, quisquam animi possimus pariatur ducimus eos soluta voluptates, sequi aperiam odio ex reprehenderit eius? Rerum libero iste eius nisi quasi doloribus mollitia, ratione repellat, minus, odio reprehenderit beatae fugiat?</p></div>
                </section>
            ";
        }
        ?>
</body>
</html>
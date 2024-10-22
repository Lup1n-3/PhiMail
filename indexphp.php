<!DOCTYPE html>
<html>
<head>
    <title>Enviar Correo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="email"],
        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario para Enviar Correo</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger los datos del formulario
            $to = $_POST['to_email'];
            $fakeFrom = $_POST['fake_from_email'];
            $subject = $_POST['subject'];
            $body = $_POST['body'];

            // Si se cargó un archivo HTML, usar ese contenido
            if (!empty($_FILES['htmlFile']['tmp_name'])) {
                $body = file_get_contents($_FILES['htmlFile']['tmp_name']);
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            } else {
                // Use text area content
                $headers = "Content-Type: text/plain; charset=UTF-8\r\n";
            }

            // Cabeceras del correo
            $headers .= "From: " . $fakeFrom . "\r\n";
            $headers .= "Reply-To: " . $fakeFrom . "\r\n";

            // Enviar el correo
            if (mail($to, $subject, $body, $headers)) {
                echo "<p style='color: green;'>Correo enviado exitosamente.</p>";
            } else {
                echo "<p style='color: red;'>Error al enviar el correo.</p>";
            }
        }
        ?>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="to_email">Correo destinatario:</label>
            <input type="email" id="to_email" name="to_email" required>

            <label for="fake_from_email">Correo remitente falso:</label>
            <input type="email" id="fake_from_email" name="fake_from_email" value="ejemplo@ejemplo.com" required>

            <label for="subject">Asunto:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="body">Cuerpo del mensaje (texto plano):</label>
            <textarea id="body" name="body" rows="4" cols="50"></textarea>

            <label for="htmlFile">O cargar HTML:</label>
            <input type="file" id="htmlFile" name="htmlFile" accept=".html">

            <input type="submit" value="Enviar Correo">
        </form>
    </div>
</body>
</html>

<?php
class Contact {
    // Метод для показу форми контакту
    public function PokazKontakt() {
        echo '
        <main class="content">
            <h2>Skontaktuj się z nami</h2>
            <form action="index.php?idp=contact" method="post">
                <label for="name">Imię:</label><br>
                <input type="text" id="name" name="name" required><br><br>
                
                <label for="email">E-mail:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                
                <label for="message">Wiadomość:</label><br>
                <textarea id="message" name="message" rows="4" required></textarea><br><br>
                
                <input type="submit" name="submit" value="Wyślij">
                <input type="reset" value="Resetuj">
            </form>
        </main>';
    }

    // Метод для обробки даних форми та відправки електронної пошти
    public function WyslijMailKontakt() {
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $message = htmlspecialchars($_POST['message']);

        if ($email) {
            $to = "email@gmail.com";
            $subject = "Wiadomość od $name";
            $body = "Imię: $name\nE-mail: $email\n\nWiadomość:\n$message";
            $headers = "From: $email";

            if (mail($to, $subject, $body, $headers)) {
                echo "<p>Dziękujemy! Twoja wiadomość została wysłana.</p>";
            } else {
                echo "<p>Wystąpił problem z wysłaniem wiadomości. Spróbuj ponownie później.</p>";
            }
        } else {
            echo "<p>Podano nieprawidłowy adres e-mail.</p>";
        }
    }
}
?>

<section>
    <h2 id="Kontakt"> Kontakt </h2>

    <p>Für Fragen, Anregungen oder Kommentare nutzen Sie bitte die oben genannte Email-Adresse oder dieses Kontakt-Formular.</p>

    <form method="post" action="send_kontakt.php">

        <label for="Name"><b>Name:</b></label><br>
        <input required type="text" id="Name" size="40" name="Name"><br><br>

        <label for="Email"><b>E-Mail:</b></label><br>
        <input required type="email" id="Email" size="40" name="Email"><br><br>

        <label for="Betreff"><b>Betreff:</b></label><br>
        <input required type="text" id="Betreff" size="40" name="Betreff"><br><br>

        <label for="Nachricht"><b>Nachricht:</b></label><br>
        <textarea required class="KontaktFormular" id="Nachricht" name="Nachricht" rows="8" cols="40"></textarea> <br><br>
        <input style="visibility: hidden; display: none;" type="url" name="url" id="form_url" value="">
        <input type="submit" name="submit" value="Nachricht senden">
    </form>

</section>
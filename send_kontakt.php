<?php
/* Variabeln die du Anpassen musst */

$absender = "kontakt.formular@XYZ.de";   //Absender z.b. noreply@domain.de (nutze hier unbedingt etwas mit @deiner-domain.de -> das hilft das die E-Mail nicht als Spam klassifiziert werden.)

$empfaenger = "kontakt.formular@XYZ.de"; //Empfänger-Adresse
$betreff = "Neue Kontaktanfrage"; //Betreff der Email
$url_ok = "https://www.XYZ.de"; //Zielseite, wenn E-Mail erfolgreich versendet wurde
$url_fehler = "https://www.XYZ.de"; //Zielseite, wenn E-Mail nicht gesendet werden konnte
$url_form = 'https://www.XYZ.de/kontakt.php'; //Seite vom Kontaktformular


/* Ab hier sollten keine Änderungen mehr vorgenommen werden. */
/* ================================================================= */


/* Funktion für Weiterleitungen */
function set_redirect( $url ) {
  /* Browser zum Kontaktformular weiterleiten */
  header( 'Location: ' . $url );
  /* Sicherstellen, dass das Script abgebrochen wird, auch dann falls weiterleitung nicht funktionieren sollte */
  exit();
}


/* Prüfen ob diese Datei, über das Formular aufgerufen wurde, falls nicht Browser zum Formular weiterleiten */
if( !isset( $_POST['submit'] ) ) {
  /* Browser zum Kontaktformular weiterleiten */
  set_redirect( $url_form );
}

/* Datem aus dem Formular in Variablen zwischenspeichern -> sicherstellen, dass kein Schadcode übermittelt wurde, bzw den Schadcode maskieren */
$form_name = htmlspecialchars( $_POST['Name'] );
$form_mail = htmlspecialchars( $_POST['Email'] );
$form_subject = htmlspecialchars( $_POST['Betreff'] );
$form_message = htmlspecialchars( $_POST['Nachricht'] );
$form_url = htmlspecialchars( $_POST['url'] );

/* Prüfen ob das URL Feld leer ist, wenn es nicht leer ist ist die NAchricht Spam, dann zum Formular weiterleiten */
if( !empty( $form_url ) ) {
  /* Browser zum Kontaktformular weiterleiten */
  set_redirect( $url_form );
}

/* Prüfen ob die Felder alle ausgefüllt wurden, falls nicht zur Formularseite weiterleiten */
if( empty( $form_name ) || empty( $form_mail ) || empty( $form_subject ) || empty( $form_message ) ) {
  /* Eines der Felder war leer, zur Formularseite weiterleiten */
  set_redirect( $url_form );
}

/* Datum zusammenstellen */
setlocale(LC_TIME, 'de_DE', 'deu_deu');
$date = new DateTime();
$date = new DateTime( 'NOW', new DateTimeZone( 'Europe/Berlin' ) );

/* Inhalt der Nachricht zusammenstellen */
$msg = ":: Gesendet am  ". $date->format( "l" ) ." den " . $date->format( "d.m.Y" ) . " - " . $date->format( "H:i" ) . " Uhr::\n\n";
$msg .= "::: Name :::\n$form_name\n\n";
$msg .= "::: E-Mail :::\n$form_mail\n\n";
$msg .= "::: Betreff :::\n$form_subject\n\n";
$msg .= "::: Nachricht :::\n$form_message\n\n";

/* E-Mail Header aufbereiten */
$header = "From: $absender";
$header .= "\nReply-To: $form_mail";
$header .= "\nX-Mailer: PHP/" . phpversion();
$header .= "\nContent-type: text/plain; charset=utf-8";

/* E-Mail senden */
$send_mail = mail( $empfaenger, $betreff, $msg, $header );

/* Prüfen ob E-Mail gesendet wurde und entsprechend weiterleiten */
if( $send_mail ) {
  /* E-Mail wurde gesendet */
  set_redirect( $url_ok );
} else {
  /* E-MAil wurde nicht gesendet */
  set_redirect( $url_fehler );
}
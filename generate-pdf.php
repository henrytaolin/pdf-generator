<?php

    require __DIR__ . "/../vendor/autoload.php";

    use Dompdf\Dompdf;
    use Dompdf\Options;

    // Method POST dari form
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];

    // Manual Text
    // $html = '<h1 style="color: goldenrod">INVOICE</h1>';
    // $html .= "Hello <em>$name</em>";
    // $html .= '<img src="star-icon.png" width="40" height="40">';
    // $html .= "Quantity: $quantity";

    // Tampilkan Foto
    $options = new Options;
    $options->setChroot(__DIR__);
    $options->setIsRemoteEnabled(true);

    $dompdf = new Dompdf($options);

    // Set Size Paper
    $dompdf->setPaper("A4", "landscape");

    $html = file_get_contents("template.html");

    $html = str_replace(["{{ name }}", "{{ quantity }}"], [$name, $quantity], $html);

    $dompdf->loadHtml($html);
    // $dompdf->loadHtmlFile("template.html");
    
    $dompdf->render();

    // Set Title
    $dompdf->addInfo("Title", "Invoice");

    // No Auto Download
    $dompdf->stream("invoice.pdf", ["Attachment" => 0]);

    $output = $dompdf->output();
    file_put_contents("file.pdf", $output);
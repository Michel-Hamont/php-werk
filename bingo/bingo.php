<html lang="nl">
<head>
	<meta charset="utf-8">
	<title>Bingo</title>
	<link rel="stylesheet" href="css/bingo.css">
</head>
<body>
	<h2>We gaan Bingo spelen!</h2>
	<p>Alstublieft! Uw bingokaart</p>
	<?php
	function createBingo() {
	// het creëren van de inputrange voor de bingokaart
	$input1 = range(10,19);
	$input2 = range(20,29);
	$input3 = range(30,39);
	$input4 = range(40,49);
	$input5 = range(50,59);
	$input6 = range(60,69);
	
	
	// de input door elkaar husselen om randomness te genereren (getallen zijn automatisch uniek, daarom hiervoor gekozen)
    shuffle($input1); shuffle($input2); shuffle($input3); shuffle($input4); shuffle($input5); shuffle($input6);
	
    // de input dmv slice tot 6 getallen per rij reduceren
    $output1 = array_slice($input1, 0, 6);
	$output2 = array_slice($input2, 0, 6);
	$output3 = array_slice($input3, 0, 6);
	$output4 = array_slice($input4, 0, 6);
	$output5 = array_slice($input5, 0, 6);
	$output6 = array_slice($input6, 0, 6);
	
	// de array per rij sorteren van laag naar hoog
    sort($output1); sort($output2); sort($output3); sort($output4); sort($output5); sort($output6);
	
	// we mergen de arrays tot 1 grote array
	$output = array_merge($output1, $output2, $output3, $output4, $output5, $output6);
	
	// we geven de waarden door voor gebruik
	return $output;
	}


	// we roepen de functie aan om de bingokaart te genereren
	$output = createBingo();
	
	// en dan gaan we beginnen met de bingotrekking
	mt_srand((double)microtime() * 1000000);

	// we maken wat variabelen om in rij en kolom 7 van de tabel te kunnen gebruiken
	$r1 = 0;
	$r2 = 0;
	$r3 = 0;
	$r4 = 0;
	$r5 = 0;
	$r6 = 0;
	$k1 = 0;
	$k2 = 0;
	$k3 = 0;
	$k4 = 0;
	$k5 = 0;
	$k6 = 0;
	// we maken arrays van de rijen en kolommen van de bingokaart
	$rij1 = array($output[0], $output[1], $output[2], $output[3], $output[4], $output[5]);
	$rij2 = array($output[6], $output[7], $output[8], $output[9], $output[10], $output[11]);
	$rij3 = array($output[12], $output[13], $output[14], $output[15], $output[16], $output[17]);
	$rij4 = array($output[18], $output[19], $output[19], $output[20], $output[21], $output[22]);
	$rij5 = array($output[24], $output[25], $output[25], $output[26], $output[27], $output[28]);
	$rij6 = array($output[30], $output[31], $output[31], $output[32], $output[33], $output[34]);
	$kolom1 = array($output [0], $output[6], $output[12], $output[18], $output[24], $output[30]);
	$kolom2 = array($output [1], $output[7], $output[13], $output[19], $output[25], $output[31]);
	$kolom3 = array($output [2], $output[8], $output[14], $output[20], $output[26], $output[32]);
	$kolom4 = array($output [3], $output[9], $output[15], $output[21], $output[27], $output[33]);
	$kolom5 = array($output [4], $output[10], $output[16], $output[22], $output[28], $output[34]);
	$kolom6 = array($output [5], $output[11], $output[17], $output[23], $output[29], $output[35]);
	$trekking = array();
	$valseTrekking = array();
	
	// we gaan kijken of als we getallen trekken deze dubbel is en zo niet of het getal voorkomt in een rij of kolom
	while (($r1 <6) && ($r2 <6) && ($r3 <6) && ($r4 <6) && ($r5 <6) && ($r6 <6) && ($k1 <6) && ($k2 <6) && ($k3 <6) && ($k4 <6) && ($k5 <6) && ($k6 <6)) {
	$random = mt_rand(10,69);
	if (in_array($random, $trekking)) {
		array_push($valseTrekking, $random);
		}
	elseif (in_array($random, $rij1)) {
		array_push($trekking, $random);
		$r1++;
		if (in_array($random, $kolom1)) {
			$k1++;
		}
		elseif (in_array($random, $kolom2)) {
			$k2++;
		}
		elseif (in_array($random, $kolom3)) {
			$k3++;
		}
		elseif (in_array($random, $kolom4)) {
			$k4++;
		}
		elseif (in_array($random, $kolom5)) {
			$k5++;
		}
		elseif (in_array($random, $kolom6)) {
			$k6++;
		}
	}
	elseif (in_array($random, $rij2)){
		array_push($trekking, $random);
		$r2++;
		if (in_array($random, $kolom1)) {
			$k1++;
		}
		elseif (in_array($random, $kolom2)) {
			$k2++;
		}
		elseif (in_array($random, $kolom3)) {
			$k3++;
		}
		elseif (in_array($random, $kolom4)) {
			$k4++;
		}
		elseif (in_array($random, $kolom5)) {
			$k5++;
		}
		elseif (in_array($random, $kolom6)) {
			$k6++;
		}
	}
	elseif (in_array($random, $rij3)){
		array_push($trekking, $random);
		$r3++;
		if (in_array($random, $kolom1)) {
			$k1++;
		}
		elseif (in_array($random, $kolom2)) {
			$k2++;
		}
		elseif (in_array($random, $kolom3)) {
			$k3++;
		}
		elseif (in_array($random, $kolom4)) {
			$k4++;
		}
		elseif (in_array($random, $kolom5)) {
			$k5++;
		}
		elseif (in_array($random, $kolom6)) {
			$k6++;
		}
	}
	elseif (in_array($random, $rij4)){
		array_push($trekking, $random);
		$r4++;
		if (in_array($random, $kolom1)) {
			$k1++;
		}
		elseif (in_array($random, $kolom2)) {
			$k2++;
		}
		elseif (in_array($random, $kolom3)) {
			$k3++;
		}
		elseif (in_array($random, $kolom4)) {
			$k4++;
		}
		elseif (in_array($random, $kolom5)) {
			$k5++;
		}
		elseif (in_array($random, $kolom6)) {
			$k6++;
		}
	}
	elseif (in_array($random, $rij5)){
		array_push($trekking, $random);
		$r5++;
		if (in_array($random, $kolom1)) {
			$k1++;
		}
		elseif (in_array($random, $kolom2)) {
			$k2++;
		}
		elseif (in_array($random, $kolom3)) {
			$k3++;
		}
		elseif (in_array($random, $kolom4)) {
			$k4++;
		}
		elseif (in_array($random, $kolom5)) {
			$k5++;
		}
		elseif (in_array($random, $kolom6)) {
			$k6++;
		}
	}
	elseif (in_array($random, $rij6)){
		array_push($trekking, $random);
		$r6++;
		if (in_array($random, $kolom1)) {
			$k1++;
		}
		elseif (in_array($random, $kolom2)) {
			$k2++;
		}
		elseif (in_array($random, $kolom3)) {
			$k3++;
		}
		elseif (in_array($random, $kolom4)) {
			$k4++;
		}
		elseif (in_array($random, $kolom5)) {
			$k5++;
		}
		elseif (in_array($random, $kolom6)) {
			$k6++;
		}
	}
	else {
		array_push($trekking, $random);
	}
	
}
// we creëren een functie om de bingokaart te laten printen aan de hand van de input rijen
	function printBingo() {
	global $output;
	global $r1; global $r2; global $r3; global $r4; global $r5; global $r6;
    echo ("<tr class='rij1'><td class='k1'><div class='getallen'>$output[0]</div></td><td class='k2'><div class='getallen'>$output[1]</div></td><td class='k3'><div class='getallen'>$output[2]</div></td><td class='k4'><div class='getallen'>$output[3]</div></td><td class='k5'><div class='getallen'>$output[4]</div></td><td class='k6'><div class='getallen'>$output[5]</td><td class='k7'>$r1</td></tr>");
	echo ("<tr class='rij2'><td class='k1'><div class='getallen'>$output[6]</div></td><td class='k2'><div class='getallen'>$output[7]</div></td><td class='k3'><div class='getallen'>$output[8]</div></td><td class='k4'><div class='getallen'>$output[9]</div></td><td class='k5'><div class='getallen'>$output[10]</div></td><td class='k6'><div class='getallen'>$output[11]</td><td class='k7'>$r2</td></tr>");
	echo ("<tr class='rij3'><td class='k1'><div class='getallen'>$output[12]</div></td><td class='k2'><div class='getallen'>$output[13]</div></td><td class='k3'><div class='getallen'>$output[14]</div></td><td class='k4'><div class='getallen'>$output[15]</div></td><td class='k5'><div class='getallen'>$output[16]</div></td><td class='k6'><div class='getallen'>$output[17]</td><td class='k7'>$r3</td></tr>");
	echo ("<tr class='rij4'><td class='k1'><div class='getallen'>$output[18]</div></td><td class='k2'><div class='getallen'>$output[19]</div></td><td class='k3'><div class='getallen'>$output[20]</div></td><td class='k4'><div class='getallen'>$output[21]</div></td><td class='k5'><div class='getallen'>$output[22]</div></td><td class='k6'><div class='getallen'>$output[23]</td><td class='k7'>$r4</td></tr>");
	echo ("<tr class='rij5'><td class='k1'><div class='getallen'>$output[24]</div></td><td class='k2'><div class='getallen'>$output[25]</div></td><td class='k3'><div class='getallen'>$output[26]</div></td><td class='k4'><div class='getallen'>$output[27]</div></td><td class='k5'><div class='getallen'>$output[28]</div></td><td class='k6'><div class='getallen'>$output[29]</td><td class='k7'>$r5</td></tr>");
	echo ("<tr class='rij6'><td class='k1'><div class='getallen'>$output[30]</div></td><td class='k2'><div class='getallen'>$output[31]</div></td><td class='k3'><div class='getallen'>$output[32]</div></td><td class='k4'><div class='getallen'>$output[33]</div></td><td class='k5'><div class='getallen'>$output[34]</div></td><td class='k6'><div class='getallen'>$output[35]</td><td class='k7'>$r6</td></tr>");
	}
	
	
	//nu printen we de kaart in een html-tabel door de functie aan te roepen
	echo ("<table>");
	printBingo();
	echo ("<tr class='rij7'><td><div name='k1'>$k1</div></td><td name='k2'>$k2</td><td name='k3'>$k3</td><td name='k4'>$k4</td><td name='k5'>$k5</td><td name='k6'>$k6</td><td class='k7'></td>");
	echo ("</table>");
    
	// met deze if-reeks laten we de achtergrond van de rij of kolom die bingo geeft groen worden
	if ($r1 == 6) {
	  echo ("<style>.rij1 { background-color: green; }</style>");	
	}
	elseif ($r2 == 6) {
	  echo ("<style>.rij2 { background-color: green; }</style>");	
	}
	elseif ($r3 == 6) {
	  echo ("<style>.rij3 { background-color: green; }</style>");	
	}
	elseif ($r4 == 6) {
	  echo ("<style>.rij4 { background-color: green; }</style>");	
	}
	elseif ($r5 == 6) {
	  echo ("<style>.rij5 { background-color: green; }</style>");	
	}
	elseif ($r6 == 6) {
	  echo ("<style>.rij6 { background-color: green; }</style>");	
	}
	elseif ($k1 == 6) {
	  echo ("<style>.k1 { background-color: green; }</style>");	
	}
	elseif ($k2 == 6) {
	  echo ("<style>.k2 { background-color: green; }</style>");	
	}
		elseif ($k3 == 6) {
	  echo ("<style>.k3 { background-color: green; }</style>");	
	}
		elseif ($k4 == 6) {
	  echo ("<style>.k4 { background-color: green; }</style>");	
	}
		elseif ($k5 == 6) {
	  echo ("<style>.k5 { background-color: green; }</style>");	
	}
		elseif ($k6 == 6) {
	  echo ("<style>.k6 { background-color: green; }</style>");	
	}
	
	echo ("<p id='bingo'>Bingo!<br></p>");
	// en tenslotte printen we alle getrokken getallen
	echo ("de getrokken getallen:<br><br>");
	foreach ($trekking as $name_value) {
		print("$name_value ");
	}
	// en tellen het aantal getrokken getallen bij elkaar op.
	echo ("<br><br>het aantal getrokken getallen is: ".count($trekking));

	?>
	
</body>
</html>
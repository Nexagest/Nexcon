<?php
$var = 'ABCDEFGH:/MNRPQR/';
echo "Original: $var<hr />\n";

/* Estos dos ejemplos reemplazan todo $var por 'bob'. */
echo substr_replace($var, 'bob', 0) . "<br />\n";
echo substr_replace($var, 'bob', 0, strlen($var)) . "<br />\n";

/* Inserta 'bob' justo al comienzo de $var. */
echo substr_replace($var, 'bob', 0, 0) . "<br />\n";

/* Estos dos siguientes reemplazan 'MNRPQR' en $var por 'bob'. */
echo substr_replace($var, 'bob', 10, -1) . "<br />\n";
echo substr_replace($var, 'bob', -7, -1) . "<br />\n";

/* Elimina 'MNRPQR' de $var. */
echo substr_replace($var, '', 10, -1) . "<br />\n";
?>
<?php 

//Pega os dados postados pelo formulário HTML e os coloca em variaveis
$email_from='daniel@engenhodacana.com.br';	// Substitua essa linha pelo seu e-mail@seudominio


if( PATH_SEPARATOR ==';'){ $quebra_linha="\r\n";

} elseif (PATH_SEPARATOR==':'){ $quebra_linha="\n";

} elseif ( PATH_SEPARATOR!=';' and PATH_SEPARATOR!=':' )  {echo ('Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.');

}


//pego os dados enviados pelo formulário 
$nomeremetente = $_POST["nomeremetente"]; 
$emailremetente = $_POST["emailremetente"]; 
$email = $email_from; 
$assunto = $_POST["assunto"]; 
$telefone = $_POST["telefone"]; 
$movel = $_POST["celular"]; 
$categ_cliente = $_POST["categoria_depo"];
$mensagem = $_POST["mensagem"]; 
$local = $_POST["local_evento"];
$endereco = $_POST["end_evento"];
$data = $_POST["hora_evento"]; 
$hora = $_POST["data_evento"]; 
//formato o campo da mensagem 
$mensagem = wordwrap($mensagem, 50, "<br>", 1);
//valido os emails 
if (!ereg("^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$", $email)){ 

 
echo "<script>location.href='index.php?mensagem=erro#contato'</script>"; // Página que será redirecionada 

} 

$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE; 

if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){ 

$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb"); 
$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"])); 
$anexo = base64_encode($anexo); 

fclose($fp); 

$anexo = chunk_split($anexo); 


$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 

$mens = "--$boundary" . $quebra_linha . ""; 
$mens .= "Content-Transfer-Encoding: 8bits" . $quebra_linha . ""; 
$mens .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha . "<br />";
$quebra_linha . "" . $quebra_linha . ""; //plain  
$mens .= "<b>Nome: "."$nomeremetente</b>" . $quebra_linha . "<br />"; 
$mens .= "<b>Telefone: "."$telefone</b>" . $quebra_linha . "<br />"; 
$mens .= "<b>Celular: "."$movel</b>" . $quebra_linha . "<br />";
$mens .= "<b>E-mail: "."$emailremetente</b>" . $quebra_linha . "<br />"."<br />";
$mens .= "<b>Depoimento de um "."$categ_cliente</b>" . $quebra_linha . "<br />";
$mens .= "<b>$mensagem</b>" . $quebra_linha . "<br />". "<br />";
$mens .= "Endere&ccedil;o do evento: "."$endereco" . $quebra_linha . "<br />"; 
$mens .= "Data: "."$data" . $quebra_linha . ""; 
$mens .= "Hora: "."$hora" . $quebra_linha . "<br />". "<br />"; 
$mens .= "--$boundary" . $quebra_linha . ""; 
$mens .= "Content-Type: ".$arquivo["type"]."" . $quebra_linha . ""; 
$mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"" . $quebra_linha . ""; 
$mens .= "Content-Transfer-Encoding: base64" . $quebra_linha . "" . $quebra_linha . ""; 
$mens .= "$anexo" . $quebra_linha . ""; 
$mens .= "--$boundary--" . $quebra_linha . ""; 

$headers = "MIME-Version: 1.0" . $quebra_linha . ""; 
$headers .= "From: " . $emailremetente . $quebra_linha . ""; 
$headers .= "Return-Path: $email_from " . $quebra_linha . ""; 
$headers .= "Reply-To: " . $emailremetente . $quebra_linha;
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"" . $quebra_linha . ""; 
$headers .= "$boundary" . $quebra_linha . ""; 


//envio o email com o anexo 
mail($email,$assunto, $mens,$headers, "-r".$email_from); 
echo "<script>location.href='index.php?mensagem=enviada#eventos'</script>"; // Página que será redirecionada

} 

//se nao tiver anexo 
else{ 

$headers = "MIME-Version: 1.0" . $quebra_linha . ""; 
$headers .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha . ""; 
$headers .= "From:  " . $emailremetente . $quebra_linha . ""; 
$headers .= "Reply-To: " . $emailremetente . $quebra_linha;
$headers .= "Return-Path: $email_from " . $quebra_linha . ""; 
$mens .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha . "<br />". "<br />";  
$mens .= "<b>Nome: "."$nomeremetente</b>" . $quebra_linha . "<br />"; 
$mens .= "<b>Telefone: "."$telefone</b>" . $quebra_linha . "<br />"; 
$mens .= "<b>Celular: "."$movel</b>" . $quebra_linha . "<br />";
$mens .= "<b>E-mail: "."$emailremetente</b>" . $quebra_linha . "<br />"."<br />";
$mens .= "<b>Depoimento de um "."$categ_cliente</b>" . $quebra_linha . "<br />";
$mens .= "<b>$mensagem</b>" . $quebra_linha . "<br />". "<br />";
$mens .= "Endere&ccedil;o do evento: "."$endereco" . $quebra_linha . "<br />"; 
$mens .= "Data: "."$data" . $quebra_linha . ""; 
$mens .= "Hora: "."$hora" . $quebra_linha . "<br />". "<br />"; 

//envia o email sem anexo 
mail($email,$assunto,$mens,$headers, "-r".$email_from); 

echo "<script>location.href='index.php?mensagem=enviada#eventos'</script>"; // Página que será redirecionada 
} 

?>

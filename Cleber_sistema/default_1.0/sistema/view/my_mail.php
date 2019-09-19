<?php
$host = "imap.triangulocontabil.com.br"; //aqui você deve informar o seu servidor de Email, pode ser imap.domínio ou pop.domínio 
$usuario = "informatica@triangulocontabil.com.br";
$senha = "@1Triangulo_Informatica";
 
$caixaDeCorreio = imap_open("{".$host.":143/novalidate-cert}INBOX", $usuario, $senha);
 
if(!$caixaDeCorreio)
{
        print_r(imap_errors());
}
else
{
 
        $listaPastas = imap_getmailboxes($caixaDeCorreio, "{".$host."}", "*");
        if (is_array($listaPastas))
        {
                // Preparando a listagem de pastas
                echo ("<p>Listando as pastas do seu IMAP</p>\n");
                foreach ($listaPastas as $chavePastas => $valorPastas)
                {
                        echo "<p><b>".str_replace("{".$host."}", "", $valorPastas->name)."</b><br>\n";
 
                        $host2 = str_replace("}", ":143/novalidate-cert}", $valorPastas->name);
 
                        $caixaDeCorreio1 = imap_open($host2, $usuario, $senha);
                        if(!$caixaDeCorreio1)
                        {
                                echo "Erro ao tentar listar a pasta ".$valorPastas->name;
                                print_r(imap_errors());
                        }
                        else
                        {
                                $check = imap_mailboxmsginfo($caixaDeCorreio1);
                                if($check)
                                {
                                        // Mostrando os detalhes de cada pasta
                                        echo "Total de mensagens: <i>".$check->Nmsgs."</i><br>\n";
                                        echo "Mensagens nao lidas: <i>".$check->Unread."</i><br>\n";
                                        echo "Tamanho total: <i>".$check->Size." Bytes</i><br>\n";
                                        echo "</p>\n";
                                }
                                else
                                {
                                        echo "Erro ao obter os detalhes das pastas:<br>".imap_last_error();
                                }
                                $caixaDeCorreio1 = imap_close($caixaDeCorreio1);
                        }
 
                }
        }
        else
        {
                echo "Nao consegui obter a lista de pastas:<br>".imap_last_error();
        }

        /* grab emails */
		$emails = imap_search($caixaDeCorreio,'ALL');

		/* if emails are returned, cycle through each... */
		if($emails) {
			
			/* begin output var */
			$output = '';
			
			/* put the newest emails on top */
			rsort($emails);
			
			/* for every email... */
			foreach($emails as $email_number) {
				
				/* get information specific to this email */
				$overview = imap_fetch_overview($caixaDeCorreio,$email_number,0);
				$message = imap_fetchbody($caixaDeCorreio,$email_number,2);
				
				/* output the email header information */
				$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
				$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
				$output.= '<span class="from">'.$overview[0]->from.'</span>';
				//$output.= '<span class="date">on '.$overview[0]->date.'</span>';
				$output.= '</div>';
				
				/* output the email body */
				$output.= '<div class="body">'.$message.'</div>';
			}
			
			echo $output;
		} 

        $caixaDeCorreio = imap_close($caixaDeCorreio);
}
?>
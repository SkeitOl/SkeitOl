<?php
class MailAgent 
{
		
	private $_SMTPServer = 'smtp.mail.ru';
	private $_SMTPLogin = 'skeit.site@mail.ru';
	private $_SMTPPass = 'skeit0302';
	private $_mail = null;
	private $_mailFrom = 'skeit.site@mail.ru';
	
	private function initMailAgent()
	{
		include_once('class.phpmailer.php');
		
		$this->_mail  = new PHPMailer();
		// Устанавливаем, что наши сообщения будет идти через 
		// SMTP сервер
		$this->_mail->IsSMTP();
		
		// Можно раскомментировать след. строчку для отладки	
		// 1 = Ошибки и сообщения
		// 2 = Только сообщения
		//$mail->SMTPDebug  = 2;        		
		
		// Включение SMTP аутентификации
		// Большинство серверов ее требуют	
		$this->_mail->SMTPAuth   = true;   
		// SMTP Сервер отправки сообщений
		$this->_mail->Host       = $this->_SMTPServer; 
		// Порт сервера (чаще всего 25)
		$this->_mail->Port       = 25; 
		// SMTP Логин для авториации
		$this->_mail->Username   = $this->_SMTPLogin;
		// SMTP Пароль для авторизации	
		$this->_mail->Password   = $this->_SMTPPass;
		// Enable TLS encryption, `ssl` also accepted
		$this->_mail->SMTPSecure='tls';
		// Кодировка сообщения
		$this->_mail->CharSet    = 'utf-8';
	}
	
	public function sendMail( $address, $subject, $body, $from='' )
	{
		if ($this->_mail == null) {
			$this->initMailAgent();
		}
		
		// Устанавливаем от кого будет уходить почта
		$this->_mail->SetFrom($from=='' ? $this->_mailFrom : $from);
		
		// Устанавливаем заголовк письма
		$this->_mail->Subject    = $subject;
		// Текст сообщения
		$this->_mail->MsgHTML($body);
		
		if (is_array($address)) {
			// Отправка сообщений сразу нескольким пользователям
			foreach($address as $value) {
				$this->_mail->AddAddress($value);
			}
			} else {
			// Адрес получателя. Второй параметр - имя получателя (не обязательно)
			$this->_mail->AddAddress($address);
		}
		// Отправляем сообщение
		return $this->_mail->Send();
	}			
}
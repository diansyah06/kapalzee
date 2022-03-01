# Zee-Internal


Zee Internal
Step Clone to localhost
1. clone dari github

2. set php.ini 
	max_execution_time=300
	upload_max_filesize=52M
	memory_limit=1024M
	post_max_size=58M
restart apache
3. buat database 'ogs' dan import db file "ogs (1).sql"
4. buat db client 'c_ogs' dan import db file "c_ogs (1).sql"
5. set username pass.  phpmyadmin-> db ogs -> Privieges->add user account
	username : serverOfshore
	hostname : localhost
	password : 3twhvjttbm
	dan Go. 
6. karena zee dibuat dengan php5.6 maka akan ada banyak warning maka
	masuk php.ini.
	error_reporting = E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING
7. change connection client di folder class-> class_client.php ganti
			'host'	=> 'localhost',
			'username'	=> 'root'
			'password'	=> ''
			'dbname' => 'c_ogs'

8. php -S localhost:8000 -t Zee-Internal

9. untuk bisa login. maka kita pakai salah satu user misal defri. dan kita rubah menjadi super user.
	buka phpmyadmin ->db ogs tabel og_user dan jalankan perintah sql berikut :

UPDATE `og_user` SET `sandi` = '12b1c5392007adb035ac594b5481a2c8477acff4e00daf3e517823b9a738cca0b18f0de76bef977ad080383b2a36b0d2c6d6992ef05b7751f2ac4f67be219452', `garam` = 

'e7c43970d922a807a715afb89456faec8bb7250ab37f39dd64dd1844107a4878ef9868c5c06bb8caad8dc926caed23b339ec1a9603a4ce8f3947767595fc0e63',previl=9 WHERE `og_user`.`id_user` = 37;

	setelah itu bisa login dengan:
	user name : defri
	pass	 : 123456


10. happy coding.	


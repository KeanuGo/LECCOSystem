	
Setup & Installation Guide:

	ADMIN GUIDE:
		A. Installation:
			1. Install all vcredist (Microsoft Visual Studio).
			2. Install wamp_server_64.
			3. Set environment variable.
				-> Search "system environment variables".
				-> A pop-up window will display and click the "Environment Variables" button.
				-> Under System Variables, edit PATH. Add ";C:/wamp64/bin/php/php7.0.10".	
			4. Open cmd and run php -v to test if php is working.
			5. Install sqlsrv40 and set the directory to "C:/bin/php/php7.0.10".
			6. Replace php.ini found in "C:/wamp64/www/bin/php/php7.0.10".
			7. Install odbcsql.
			8. Move the lecco folder to "C:/wamp64/www/".
			9. Move the lecco.bat to lecco folder.
			10. In the lecco folder, open /.env file and /config/database.php using notepad++.
			11. In the mentioned files, edit the DB_HOST, "IP_ADDRESS" to set the desired HOST IP.
		B. Start-up
			1. To run the server, open the /LECCO SYSTEM.bat file.
			2. You can configure the hostname, IP address and port number by editing the 
			   LECCO SYSTEM.bat file using notepad++.
		C. Problems
			1. If cannot connect to database, do steps 10 and 11 in installation guide above.
			2. In case the IP address has changed, configure the host file of the user PCs using notepad
			   UNDER ADMINISTRATOR MODE ONLY, found in C:/Windows/System32/drivers/etc/host. 
			   In the end of the file, change the IP address found in the left of "lecco.com".

	USER GUIDE:
		APPLICATION NAME: lecco.com:8000
		1. Default features of new user are only VIEWS. EDIT, DELETE, and ADD features 
		   can be configured only by the admin.
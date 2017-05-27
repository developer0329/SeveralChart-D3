Copy files to /dst install location

Update apt
sudo apt-get update

Install apache
sudo apt-get install apache2

Install mysql
sudo apt-get install mysql-server

Install php
sudo apt-get install php5 libapache2-mod-php5

Restart apache
sudo /etc/init.d/apache2 restart

Open port for http (uncomment this line in VagrantFile)
config.vm.network "forwarded_port", guest: 80, host: 8080

Open port for mysql (uncomment this line in VagrantFile)
config.vm.network "forwarded_port", guest: 3306, host: 3306

Allow localhost connection by commenting out bind-address line in 
sudo vi /etc/mysql/my.cnf
Next update MySQL
>use mysql
>GRANT ALL ON *.* to root@'%' IDENTIFIED BY 'pass';
>FLUSH PRIVILEGES;

Restart vagrant
c:\>vagrant reload

Make a link to the directory
 sudo ln -s /vagrant/alert /var/www/html

Setup SQL db
 - run the create_Forecast.sql script

open browser on host to 
 http://localhost:8080/alert/

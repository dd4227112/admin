#du -k /var/lib/pgsql/data/log  > db_log.html

#specifically for checklingking error logs in postgres

cd /var/lib/pgsql/data/log
db_log=$(du -k)
db_log_val=${db_log/./}
printf $db_log_val >/usr/share/nginx/html/admin/storage/server/db_log.html



#specifucally check nginx error logs 
#du -k /var/log/nginx >nginx_log.html

cd /var/log/nginx
nginx_log=$(du -k)
nginx_log_val=${nginx_log/./}
printf $nginx_log_val >/usr/share/nginx/html/admin/storage/server/nginx_log.html


#check php -fpm 
cd /var/log/php-fpm
php_fpm=$(du -k)
php_fpm_val=${php_fpm/./}
printf $php_fpm_val >/usr/share/nginx/html/admin/storage/server/php_fpm_log.html

#du -k /var/log/php-fpm >php_fpm_log.html

#check db backup
cd /home/schema_backups/
db_backup=$(ls | wc -l)
db_backup_val=${db_backup/./}
printf $db_backup_val >/usr/share/nginx/html/admin/storage/server/db_backup.html


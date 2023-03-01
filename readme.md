Admin Panel is  a platform to manage shulesoft operations


-------------------------------------------------------------------------------

MODELS OPERATIONS

-------------------------------------------------------------------------------


Packages Used
krlove/eloquent-model-generator

php artisan krlove:generate:model User --table-name=user

#Limitations: Does not create relationships 
--------------------------------------------------------------------------------

git old commit url
https://shulesoft@bitbucket.org/shulesoft/shulesoft.git

#administration tasks under linux
Sync files btn servers
 rsync -azvr /home/schema_backups/* root@75.119.138.7:/home/sbackup/

#update duplicates
UPDATE t SET phoneid=userid FROM (SELECT count(*),phoneid FROM t GROUP BY phoneid HAVING count(*)>1) AS foo WHERE t.phoneid=foo.phoneid;

ALTER USER postgres PASSWORD 'myPassword';
ALTER ROLE
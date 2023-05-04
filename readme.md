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

#limit idle connections in postgres
SET SESSION idle_in_transaction_session_timeout = '3s';

#delete duplicate data differ by date
WITH cte AS (
  SELECT student_id, installment_id,
         ROW_NUMBER() OVER (PARTITION BY student_id, installment_id ORDER BY created_at DESC) AS rn
  FROM shulesoft.tmembers
)
DELETE FROM shulesoft.tmembers
WHERE (student_id, installment_id) IN (
  SELECT student_id, installment_id
  FROM cte
  WHERE rn > 1
);